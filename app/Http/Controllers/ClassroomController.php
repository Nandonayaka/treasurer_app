<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::where('user_id', Auth::id())->latest()->get();
        return view('dashboard', compact('classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'weekly_fee' => 'required|numeric|min:0',
            'billing_period_days' => 'required|numeric|min:0.0001',
            'billing_at_time' => 'required|string',
        ]);

        Classroom::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'weekly_fee' => $request->weekly_fee,
            'billing_period_days' => $request->billing_period_days,
            'billing_at_time' => $request->billing_at_time,
            'billing_cycle_anchor' => now(),
            'current_period' => 1,
            'accumulated_expected_fees' => $request->weekly_fee,
        ]);

        return redirect()->route('dashboard')->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        if ($classroom->user_id !== Auth::id()) {
            abort(403);
        }

        $currentPeriod = (int)($classroom->current_period ?? 1);
        
        // Build periods
        $periods = [];
        $anchor = $classroom->billing_cycle_anchor ?? $classroom->created_at;
        $periodDays = (float)($classroom->billing_period_days ?? 7);

        for ($i = 1; $i <= $currentPeriod; $i++) {
            $periods[] = [
                'index' => $i,
                'fee' => (float)$classroom->weekly_fee,
                'date' => $anchor->copy()->addDays(($i - 1) * $periodDays)
            ];
        }

        // CONSISTENCY FIX: Calculate total expected from periods sum
        $totalExpectedAmount = collect($periods)->sum('fee');
        
        // Sync back to DB if needed (to keep accumulated_expected_fees updated)
        if ($classroom->accumulated_expected_fees != $totalExpectedAmount || $classroom->current_period === null) {
            $classroom->update([
                'current_period' => $currentPeriod,
                'accumulated_expected_fees' => $totalExpectedAmount
            ]);
        }

        $classroom->load(['members.transactions' => function($query) {
            $query->latest('date');
        }]);

        foreach($classroom->members as $member) {
            $totalPaid = $member->transactions->where('type', 'income')->sum('amount');
            $remaining = $totalPaid; 
            $unpaidPeriods = [];

            foreach($periods as $p) {
                if ($remaining >= $p['fee']) {
                    $remaining -= $p['fee'];
                } else {
                    $amountDue = $p['fee'] - max(0, $remaining);
                    $unpaidPeriods[] = [
                        'index' => $p['index'],
                        'date' => $p['date']->translatedFormat('d M Y'),
                        'is_past' => $p['index'] < $currentPeriod,
                        'is_current' => $p['index'] == $currentPeriod,
                        'amount_due' => (float)$amountDue
                    ];
                    $remaining = 0;
                }
            }

            $member->debt = (float)($totalPaid - $totalExpectedAmount);
            $member->unpaid_list = $unpaidPeriods;
            $member->is_unpaid = count($unpaidPeriods) > 0;
        }

        // Sort members: unpaid count first, then by name
        $sortedMembers = $classroom->members->sort(function($a, $b) {
            if (count($a->unpaid_list) !== count($b->unpaid_list)) {
                return count($b->unpaid_list) - count($a->unpaid_list);
            }
            return strcasecmp($a->name, $b->name);
        });

        $allTransactions = $classroom->transactions()->latest()->get();
        $transactions = $allTransactions->take(5);

        $membersData = $sortedMembers->map(function($m) use ($currentPeriod) {
            $latestTx = $m->transactions->first();
            return [
                'id' => $m->id,
                'name' => $m->name ?? 'Unknown',
                'gender' => $m->gender ?? 'male',
                'income' => (float)$m->transactions->where('type', 'income')->sum('amount'),
                'debt' => (float)$m->debt,
                'unpaidList' => $m->unpaid_list,
                'lastTxdiff' => $latestTx ? \Carbon\Carbon::parse($latestTx->date)->diffForHumans(null, true, true) : 'Baru',
                'isUnpaid' => (bool)$m->is_unpaid,
                'currentPeriodIndex' => $currentPeriod,
                'allData' => [
                    'id' => $m->id,
                    'name' => $m->name,
                    'gender' => $m->gender,
                    'debt' => (float)$m->debt,
                    'income' => (float)$m->transactions->where('type', 'income')->sum('amount'),
                    'unpaidList' => $m->unpaid_list,
                    'isUnpaid' => (bool)$m->is_unpaid,
                    'transactions' => $m->transactions->take(10)->map(function($t) {
                        return [
                            'name' => $t->name,
                            'amount' => (float)$t->amount,
                            'type' => $t->type,
                            'date' => $t->date
                        ];
                    })
                ]
            ];
        })->values();
        
        return view('classrooms.show', compact('classroom', 'transactions', 'allTransactions', 'sortedMembers', 'membersData'));
    }

    /**
     * Increment the period manually.
     */
    public function nextPeriod(Classroom $classroom)
    {
        if ($classroom->user_id !== Auth::id()) {
            abort(403);
        }

        $classroom->increment('current_period');
        $classroom->increment('accumulated_expected_fees', $classroom->weekly_fee);

        return redirect()->route('classrooms.show', $classroom)
            ->with('success', "Berhasil! Periode sekarang adalah Ke-{$classroom->current_period}. Tagihan anggota otomatis bertambah Rp" . number_format($classroom->weekly_fee, 0, ',', '.'));
    }


    /**
     * Display the full history of transactions.
     */
    public function history(Classroom $classroom)
    {
        if ($classroom->user_id !== Auth::id()) {
            abort(403);
        }

        $transactions = $classroom->transactions()->latest()->paginate(15);
        
        return view('classrooms.history', compact('classroom', 'transactions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        if ($classroom->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'weekly_fee' => 'required|numeric|min:0',
            'billing_period_days' => 'required|numeric|min:0.0001',
            'billing_at_time' => 'required|string',
        ]);

        $classroom->update([
            'name' => $request->name,
            'description' => $request->description,
            'weekly_fee' => $request->weekly_fee,
            'billing_period_days' => $request->billing_period_days,
            'billing_at_time' => $request->billing_at_time,
        ]);

        return redirect()->route('classrooms.show', $classroom)->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        if ($classroom->user_id !== Auth::id()) {
            abort(403);
        }

        $classroom->delete();

        return redirect()->route('dashboard')->with('success', 'Kelas berhasil dihapus!');
    }
}
