<x-app-layout>
    <div class="py-6 md:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('classrooms.show', $classroom) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Full History</h1>
                        <p class="text-slate-400 font-bold text-xs">{{ $classroom->name }}</p>
                    </div>
                </div>
            </div>

            <!-- History List -->
            <div class="bg-white rounded-[2rem] md:rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/40 overflow-hidden mb-8">
                <div class="divide-y divide-slate-50">
                    @forelse($transactions as $transaction)
                        @php
                            $displayTitle = $transaction->name === 'General' ? $transaction->description : $transaction->name;
                            $isLong = strlen($displayTitle) > 50;
                        @endphp
                        <div x-data="{ expanded: false }" class="px-6 py-6 md:px-10 md:py-8 flex items-start justify-between hover:bg-slate-50/50 transition-all">
                            <div class="flex items-start gap-4 md:gap-8 flex-1 min-w-0">
                                <div class="w-10 h-10 md:w-14 md:h-14 rounded-xl md:rounded-2xl shrink-0 flex items-center justify-center shadow-sm {{ $transaction->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                    @if($transaction->type === 'income')
                                        <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                    @else
                                        <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"/></svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col">
                                        <h4 class="font-black text-slate-800 text-sm md:text-base leading-tight break-words"
                                            :class="expanded ? '' : 'line-clamp-1 truncate'">
                                            {{ $displayTitle }}
                                        </h4>
                                        @if($isLong)
                                            <button @click="expanded = !expanded" class="text-[9px] font-black text-blue-500 hover:text-blue-700 mt-1 text-left uppercase tracking-tighter">
                                                <span x-text="expanded ? 'Show Less' : 'Read More'"></span>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        <span class="text-slate-400 text-[10px] font-medium">{{ \Carbon\Carbon::parse($transaction->date)->format('d F Y') }}</span>
                                        <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                        <span class="text-emerald-500/80 text-[10px] font-black">{{ $transaction->member ? $transaction->member->name : 'Kas Kelas' }}</span>
                                    </div>
                                    @if($transaction->name !== 'General' && $transaction->description)
                                        <p class="text-[10px] text-slate-400 mt-1 font-bold">{{ $transaction->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right shrink-0 ml-4">
                                <p class="text-sm md:text-lg font-black {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-slate-900' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                </p>
                                @if($transaction->category)
                                    <span class="inline-block px-2 py-0.5 bg-slate-100 text-slate-400 rounded-full text-[8px] font-black uppercase mt-1">#{{ $transaction->category }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <p class="text-slate-400 font-bold">No transactions found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
