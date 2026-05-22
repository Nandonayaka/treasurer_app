@php
    $total_managed = \App\Models\Transaction::whereHas('classroom', function($q) {
        $q->where('user_id', Auth::id());
    })->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as balance")->value('balance') ?? 0;
@endphp
<nav x-data="{ open: false }" class="lg:hidden {{ request()->routeIs('profile.*') ? 'absolute top-0 left-0 right-0 z-[100]' : 'relative bg-gradient-to-r from-emerald-600 to-emerald-500 backdrop-blur-xl border-b border-white/10 z-30 shadow-lg shadow-emerald-900/10' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Subtle Background Image for Navbar -->
        <img src="{{ asset('images/banner-total-balance.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-overlay pointer-events-none">
        
        <div class="flex justify-between h-16 relative z-10">
            <div class="flex">
                <!-- Logo (Mobile Only) -->
                <div class="shrink-0 flex items-center lg:hidden">
                    <a href="{{ route('dashboard') }}" class="block">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-7 w-auto">
                    </a>
                </div>

                <!-- Navigation Links (Mobile Only) -->
                <div class="hidden sm:flex lg:hidden space-x-8 sm:-my-px sm:ms-10 items-center">
                    @if(request()->routeIs('profile.*'))
                         <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-1 text-sm font-black transition-all text-emerald-50 hover:text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                            Kembali
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="h-full flex items-center px-1 text-sm font-black transition-all border-b-2 {{ request()->routeIs('dashboard') ? 'text-white border-white' : 'text-emerald-100/70 border-transparent hover:text-white' }}">
                            Beranda
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-1.5 py-1.5 border border-white/20 text-sm font-black rounded-full text-white bg-white/10 hover:bg-white/20 focus:outline-none transition-all active:scale-95 gap-3 pr-5 backdrop-blur-md">
                            <div class="w-9 h-9 rounded-full overflow-hidden shrink-0 bg-white/20 border-2 border-white/30 shadow-sm">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-emerald-600 font-black text-xs">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-4 w-4 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-5 py-4 bg-slate-50/50 border-b border-slate-50">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Saldo Dikelola</p>
                            <p class="text-sm font-black text-emerald-600">Rp{{ number_format($total_managed, 0, ',', '.') }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="mt-1 font-bold text-slate-700 hover:text-emerald-600 hover:bg-emerald-50">
                            Profil
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="font-bold text-rose-600 hover:text-rose-700 hover:bg-rose-50">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Profile Action (Mobile) -->
            <div class="flex items-center gap-4 sm:hidden">
                <div class="text-right">
                    <p class="text-[8px] font-black text-emerald-100 uppercase tracking-tighter leading-none">Total Saldo</p>
                    <p class="text-[11px] font-black text-white mt-1 leading-none">Rp{{ number_format($total_managed, 0, ',', '.') }}</p>
                </div>
                @if(request()->routeIs('profile.*'))
                    <a href="{{ route('dashboard') }}" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white/30 transition-all border border-white/10 shadow-sm">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                @else
                    <a href="{{ route('profile.edit') }}" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white/30 transition-all border border-white/10 shadow-sm overflow-hidden">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @endif
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>
