<x-app-layout>
    @push('styles')
    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }
    </style>
    @endpush
    <div class="py-6 md:py-12 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="flex flex-col gap-6 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('classrooms.show', $classroom) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        <div>
                            <h1 class="text-xl font-black text-slate-900 tracking-tight">Riwayat Kas</h1>
                            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">{{ $classroom->name }}</p>
                        </div>
                    </div>
                    <a href="{{ route('pdf.history', [$classroom] + request()->query()) }}" class="flex items-center gap-2 px-4 h-10 rounded-xl bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200/50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                        Cetak
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <form action="{{ route('classrooms.history', $classroom) }}" method="GET" class="flex flex-col gap-3 mb-8">
                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari transaksi (nama/catatan)..." 
                        class="w-full bg-white border-0 rounded-2xl py-4 pl-12 pr-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 shadow-sm transition-all group-hover:shadow-md">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="relative flex-1">
                        <select name="type" onchange="this.form.submit()" 
                            class="w-full bg-white border-0 rounded-2xl py-3.5 px-5 text-xs font-black uppercase tracking-widest text-slate-600 focus:ring-2 focus:ring-emerald-500 shadow-sm appearance-none">
                            <option value="">Semua Tipe</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    
                    <div class="relative flex-1">
                        <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()"
                            class="w-full bg-white border-0 rounded-2xl py-3.5 px-5 text-xs font-black uppercase tracking-widest text-slate-600 focus:ring-2 focus:ring-emerald-500 shadow-sm cursor-pointer">
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>

                    <button type="submit" class="md:hidden h-12 px-8 bg-slate-900 text-white rounded-2xl flex items-center justify-center active:scale-95 transition-all shadow-lg shadow-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>

                    @if(request('search') || request('type') || request('date'))
                        <a href="{{ route('classrooms.history', $classroom) }}" class="md:ml-auto px-6 py-3.5 flex items-center justify-center bg-slate-200 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-300 transition-all">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- History List -->
            <div class="space-y-4">
                @forelse($transactions as $transaction)
                    @php
                        $displayTitle = ($transaction->name === 'Umum' || $transaction->name === 'General') ? $transaction->description : $transaction->name;
                        $isLong = strlen($displayTitle) > 40;
                    @endphp
                    <div x-data="{ expanded: false }" class="bg-white rounded-[2rem] p-5 md:p-6 border border-slate-100 shadow-sm flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-10 h-10 rounded-2xl shrink-0 flex items-center justify-center {{ $transaction->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                @if($transaction->type === 'income')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"/></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-black text-slate-800 text-sm truncate">
                                    {{ $displayTitle }}
                                </h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-slate-400 text-[10px] font-bold uppercase tracking-tighter">{{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d M Y') }}</span>
                                    <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                    <span class="text-emerald-500 text-[10px] font-black">{{ $transaction->member ? $transaction->member->name : 'Umum' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right shrink-0 flex flex-col items-end gap-1.5">
                            <p class="text-sm font-black {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('pdf.receipt', $transaction) }}" class="flex items-center gap-1 px-2 py-1 bg-slate-50 text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 rounded-lg text-[8px] font-black uppercase tracking-widest transition-all">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                                PDF
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center bg-white rounded-[2rem] border border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold text-sm uppercase tracking-widest">Belum ada transaksi</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
