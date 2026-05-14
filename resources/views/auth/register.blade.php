<x-guest-layout>
    <div class="flex flex-col min-h-screen bg-white md:bg-white" x-data="{ password: '' }">
        <!-- Static Top Section (No Overlap Risk) -->
        <div class="bg-emerald-600 px-6 pt-12 pb-24 relative overflow-hidden shrink-0">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl text-white"></div>
            
            <div class="flex justify-between items-center mb-10 relative z-10">
                <a href="{{ url('/') }}" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white hover:bg-white/30 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <a href="{{ route('login') }}" class="text-[10px] font-black text-emerald-50 hover:text-white transition-colors uppercase tracking-widest leading-none">Masuk</a>
            </div>

            <div class="relative z-10">
                <h1 class="text-4xl font-black text-white tracking-tight leading-none mb-1">Daftar</h1>
                <p class="text-emerald-100 font-bold text-xs opacity-90">Mulai kelola kas kelas sekarang juga</p>
            </div>
        </div>

        <!-- Sheet Section -->
        <div class="flex-1 bg-white -mt-12 rounded-t-[3rem] px-8 pt-10 pb-12 relative z-20 shadow-[0_-20px_50px_-20px_rgba(0,0,0,0.1)]">
            <div class="max-w-md mx-auto">
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-1">
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            placeholder="Nama Lengkap"
                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-1">
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                            placeholder="Alamat Email"
                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password Only (Confirmation hidden/auto-filled) -->
                    <div class="space-y-1">
                        <input id="password" type="password" name="password" x-model="password" required autocomplete="new-password"
                            placeholder="Kata Sandi"
                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300">
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Hidden confirmation to satisfy Breeze default validation -->
                    <input type="hidden" name="password_confirmation" x-bind:value="password">

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-lg shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all active:scale-95 leading-none">
                            Daftar
                        </button>
                    </div>
                </form>

                <div class="mt-10">
                    <!-- Divider -->
                    <div class="flex items-center gap-4 mb-8">
                        <div class="flex-1 h-px bg-slate-100"></div>
                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Atau Daftar Dengan</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </div>

                    <!-- Social Login -->
                    <button class="w-full py-4 px-6 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center gap-3 hover:bg-slate-100 transition-all active:scale-[0.98]">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                        <span class="text-xs font-black text-slate-600">Continue with Google</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
