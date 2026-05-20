<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function downloadReceipt(Transaction $transaction)
    {
        $transaction->load(['classroom', 'member']);
        $pdf = Pdf::loadView('pdf.receipt', compact('transaction'));
        
        return $pdf->download('receipt-' . $transaction->id . '.pdf');
    }

    public function downloadHistory(Request $request, Classroom $classroom)
    {
        $query = $classroom->transactions()->with('member');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('date', 'desc')->get();
        $pdf = Pdf::loadView('pdf.history', compact('classroom', 'transactions'));
        
        return $pdf->download('laporan-kas-' . str_replace(' ', '-', strtolower($classroom->name)) . '.pdf');
    }
}
