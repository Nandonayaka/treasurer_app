@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center gap-2 md:gap-3">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="p-2.5 md:p-3 bg-white border border-slate-100 rounded-xl md:rounded-2xl text-slate-200 cursor-not-allowed shadow-sm">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="p-2.5 md:p-3 bg-white border border-slate-100 rounded-xl md:rounded-2xl text-slate-400 hover:text-emerald-600 hover:border-emerald-100 transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
            </a>
        @endif

        {{-- Pagination Elements (Desktop) --}}
        <div class="hidden sm:flex items-center gap-2">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="text-xs font-black text-slate-300 px-2">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-emerald-500 text-white rounded-xl md:rounded-2xl text-xs md:text-sm font-black shadow-lg shadow-emerald-100 border border-emerald-500">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-white border border-slate-100 text-slate-500 rounded-xl md:rounded-2xl text-xs md:text-sm font-black hover:text-emerald-600 hover:border-emerald-100 transition-all shadow-sm active:scale-95">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Mobile Page Indicator --}}
        <div class="flex sm:hidden items-center gap-2 px-4 py-2 bg-white border border-slate-100 rounded-xl shadow-sm">
            <span class="text-[10px] font-black text-emerald-600">{{ $paginator->currentPage() }}</span>
            <span class="text-[8px] font-bold text-slate-300">/</span>
            <span class="text-[10px] font-black text-slate-800">{{ $paginator->lastPage() }}</span>
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="p-2.5 md:p-3 bg-white border border-slate-100 rounded-xl md:rounded-2xl text-slate-400 hover:text-emerald-600 hover:border-emerald-100 transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <span class="p-2.5 md:p-3 bg-white border border-slate-100 rounded-xl md:rounded-2xl text-slate-200 cursor-not-allowed shadow-sm">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    </nav>
@endif

