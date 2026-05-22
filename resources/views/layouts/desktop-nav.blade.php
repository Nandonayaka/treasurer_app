@php
    $total_managed = \App\Models\Transaction::whereHas('classroom', function($q) {
        $q->where('user_id', Auth::id());
    })->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as balance")->value('balance') ?? 0;
@endphp

<header x-data="{}" class="hidden lg:flex items-center justify-between px-8 h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-30">
    <div class="flex items-center gap-4">
        <div class="flex flex-col">
            <h2 class="text-sm font-black text-slate-800 tracking-tight leading-none">
                {{ request()->routeIs('dashboard') ? 'Tampilan Utama' : (isset($classroom) ? $classroom->name : 'Halaman Profil') }}
            </h2>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Sistem Pengelola Kas
            </p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="flex-1 max-w-md mx-8">
        <div class="relative group">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" placeholder="Cari ruang kas / kelas..." 
                @keydown.enter="$dispatch('search-classrooms', $el.value)"
                class="w-full bg-slate-50 border-none rounded-2xl py-3 pl-11 pr-4 text-xs font-bold text-slate-600 focus:ring-2 focus:ring-emerald-500/20 focus:bg-white transition-all placeholder:text-slate-400 shadow-inner">
        </div>
    </div>

    <div class="flex items-center gap-6">
        <!-- Quick Stats -->
        <div class="flex flex-col text-right">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Kelolaan</p>
            <p class="text-sm font-black text-emerald-600 tabular-nums">Rp{{ number_format($total_managed, 0, ',', '.') }}</p>
        </div>

        <div class="w-px h-8 bg-slate-100"></div>

        <!-- User Profile Dropdown -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center gap-3 group focus:outline-none">
                    <div class="text-right hidden xl:block">
                        <p class="text-[11px] font-black text-slate-800 leading-none mb-1">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Pengelola</p>
                    </div>
                    <div class="w-10 h-10 rounded-2xl overflow-hidden border-2 border-slate-50 shadow-sm group-hover:border-emerald-100 transition-all">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-emerald-50 flex items-center justify-center text-emerald-600 font-black text-xs uppercase">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="px-5 py-4 border-b border-slate-50 bg-slate-50/50">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Akun</p>
                    <p class="text-xs font-black text-emerald-600">Terverifikasi</p>
                </div>
                <x-dropdown-link :href="route('profile.edit')" class="font-bold text-slate-700 hover:text-emerald-600 hover:bg-emerald-50">
                    Pengaturan Profil
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="font-bold text-rose-600 hover:text-rose-700 hover:bg-rose-50">
                        Keluar Aplikasi
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>
