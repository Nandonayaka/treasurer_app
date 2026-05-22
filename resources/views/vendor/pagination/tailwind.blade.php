@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center gap-2 md:gap-3">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="w-10 h-10 md:w-12 md:h-12 bg-white border border-slate-100 rounded-xl md:rounded-2xl text-slate-200 cursor-not-allowed shadow-sm flex items-center justify-center">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-10 h-10 md:w-12 md:h-12 bg-white border border-slate-100 rounded-xl md:rounded-2xl text-slate-400 hover:text-emerald-600 hover:border-emerald-100 transition-all shadow-sm active:scale-95 flex items-center justify-center">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
            </a>
        @endif

        {{-- Page Indicator (X/Y) --}}
        <div class="px-5 h-10 md:h-12 bg-white border border-slate-100 rounded-xl md:rounded-2xl flex items-center justify-center shadow-sm">
            <span class="text-[10px] md:text-sm font-black text-emerald-600">{{ $paginator->currentPage() }}</span>
            <span class="text-[8px] md:text-[10px] font-bold text-slate-300 mx-2">/</span>
            <span class="text-[10px] md:text-sm font-black text-slate-800">{{ $paginator->lastPage() }}</span>
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-10 h-10 md:w-12 md:h-12 bg-white border border-slate-100 rounded-xl md:rounded-2xl text-slate-400 hover:text-emerald-600 hover:border-emerald-100 transition-all shadow-sm active:scale-95 flex items-center justify-center">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <span class="w-10 h-10 md:w-12 md:h-12 bg-white border border-slate-100 rounded-xl md:rounded-2xl text-slate-200 cursor-not-allowed shadow-sm flex items-center justify-center">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    </nav>
@endif

