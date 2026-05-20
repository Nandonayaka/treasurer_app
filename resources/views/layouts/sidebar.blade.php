<aside id="sidebar" class="hidden lg:flex flex-col w-64 bg-white border-r border-slate-100 h-screen sticky top-0 z-40">
    <!-- Sidebar Header: Logo -->
    <div class="p-6 pb-2">
        <a href="{{ route('dashboard') }}" class="block">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto">
        </a>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="flex-1 px-3 py-6 space-y-1">
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600 shadow-sm shadow-emerald-100/50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('dashboard') ? 'bg-white shadow-sm text-emerald-600' : 'bg-slate-50 text-slate-400 group-hover:bg-white group-hover:text-slate-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <span class="font-bold text-sm tracking-tight">Dashboard</span>
        </a>

        <a href="{{ route('profile.edit') }}" 
           class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('profile.*') ? 'bg-emerald-50 text-emerald-600 shadow-sm shadow-emerald-100/50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('profile.*') ? 'bg-white shadow-sm text-emerald-600' : 'bg-slate-50 text-slate-400 group-hover:bg-white group-hover:text-slate-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <span class="font-bold text-sm tracking-tight">Profil Saya</span>
        </a>
    </nav>

    <!-- Sidebar Footer: Stats & Logout -->
    <div class="p-4 border-t border-slate-50">
        @php
            $total_managed = \App\Models\Transaction::whereHas('classroom', function($q) {
                $q->where('user_id', Auth::id());
            })->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as balance")->value('balance') ?? 0;
        @endphp
        
        <div class="px-5 py-5 bg-slate-900 rounded-2xl text-white overflow-hidden relative group mb-3 shadow-lg shadow-slate-200/50">
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-emerald-600 rounded-full blur-2xl opacity-40 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 text-center md:text-left">
                <p class="text-[8px] font-black text-white/30 uppercase tracking-widest mb-1">Total Saldo</p>
                <p class="text-base font-black tracking-tight leading-tight">Rp{{ number_format($total_managed, 0, ',', '.') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    onclick="event.preventDefault(); this.closest('form').submit();"
                    class="w-full flex items-center gap-4 px-4 py-4 rounded-2xl text-rose-500 hover:bg-rose-50 transition-all font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>
