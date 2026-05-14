<nav x-data="{ open: false }" class="pt-2 pb-16 md:pb-20 relative shrink-0 overflow-hidden">
    <!-- Background: Banner Image + Emerald Overlay -->
    <div class="absolute inset-0 pointer-events-none">
        <img src="{{ asset('images/banner.png') }}" alt="" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-emerald-700/70"></div>
    </div>
    <!-- Background Decor -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl text-white"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-8 h-8 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white group-hover:bg-white/30 transition-all">
                             <!-- Using SVG icon if logo image path breaks, or you can use image -->
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-white font-black text-xl tracking-tight hidden md:block">Treasurer.</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <a href="{{ route('dashboard') }}" class="h-full flex items-center px-1 text-sm font-black transition-all border-b-2 {{ request()->routeIs('dashboard') ? 'text-white border-white' : 'text-emerald-100/70 border-transparent hover:text-white hover:border-emerald-300/50' }}">
                        Beranda
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-black rounded-xl text-emerald-700 bg-white hover:bg-emerald-50 focus:outline-none transition-all shadow-lg active:scale-95 gap-2">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-4 w-4 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="font-bold text-slate-700 hover:text-emerald-600 hover:bg-emerald-50">
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

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-emerald-100 hover:text-white hover:bg-white/20 focus:outline-none transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         @click.away="open = false"
         class="absolute top-20 left-4 right-4 bg-white rounded-[2rem] shadow-2xl shadow-slate-900/10 z-[100] border border-slate-100 overflow-hidden sm:hidden" style="display: none;">
        
        <div class="p-6">
            <!-- User Info -->
            <div class="flex items-center gap-4 mb-4 pb-4 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 font-black text-xl border border-slate-100 shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-black text-slate-800 text-base truncate">{{ Auth::user()->name }}</h3>
                    <p class="font-bold text-slate-400 text-xs truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Links -->
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-4 rounded-2xl transition-all active:scale-[0.98] {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-slate-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span class="font-black">Beranda</span>
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-4 rounded-2xl transition-all active:scale-[0.98] {{ request()->routeIs('profile.edit') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-slate-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span class="font-black">Profil</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-2 pt-2 border-t border-dashed border-slate-100">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-between p-4 rounded-2xl text-rose-500 bg-rose-50/50 hover:bg-rose-100 transition-all active:scale-[0.98]">
                        <span class="font-black text-sm">Keluar</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
