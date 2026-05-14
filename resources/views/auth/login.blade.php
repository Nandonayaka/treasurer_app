<x-guest-layout>
    <div class="flex flex-col min-h-screen bg-white md:bg-white">
        <!-- Static Top Section (No Overlap Risk) -->
        <div class="bg-emerald-600 px-6 pt-12 pb-24 relative overflow-hidden shrink-0">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl text-white"></div>
            
            <div class="flex justify-between items-center mb-10 relative z-10">
                <a href="{{ url('/') }}" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white hover:bg-white/30 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-[10px] font-black text-emerald-50 hover:text-white transition-colors uppercase tracking-widest leading-none">Daftar</a>
                @endif
            </div>

            <div class="relative z-10">
                <h1 class="text-4xl font-black text-white tracking-tight leading-none mb-1">Masuk</h1>
                <p class="text-emerald-100 font-bold text-xs opacity-90">Halo! Selamat datang kembali, kami merindukanmu!</p>
            </div>
        </div>

        <!-- Sheet Section -->
        <div class="flex-1 bg-white -mt-12 rounded-t-[3rem] px-8 pt-10 pb-12 relative z-20 shadow-[0_-20px_50px_-20px_rgba(0,0,0,0.1)]">
            <div class="max-w-md mx-auto">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                            placeholder="Alamat Email"
                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-emerald-500 transition-all">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="relative">
                            <input id="password" type="password" name="password" required 
                                placeholder="Kata Sandi"
                                class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-emerald-500 transition-all">
                            <button type="button" class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        
                        @if (Route::has('password.request'))
                            <div class="text-right">
                                <a class="text-[11px] font-black text-slate-400 hover:text-emerald-600 transition-colors" href="{{ route('password.request') }}">
                                    Lupa Kata Sandi?
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-lg shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all active:scale-95 leading-none">
                            Masuk
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="my-10 flex items-center gap-4">
                    <div class="flex-1 h-px bg-slate-100"></div>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Atau Masuk Dengan</span>
                    <div class="flex-1 h-px bg-slate-100"></div>
                </div>

                <!-- Social Logins -->
                <div class="space-y-4">
                    <button class="w-full py-4 px-6 bg-slate-50 rounded-2xl flex items-center justify-center gap-3 hover:bg-slate-100 transition-all active:scale-[0.98]">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                        <span class="text-sm font-black text-slate-600">Continue with Google</span>
                    </button>
                    <button class="w-full py-4 px-6 bg-slate-50 rounded-2xl flex items-center justify-center gap-3 hover:bg-slate-100 transition-all active:scale-[0.98]">
                        <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" class="w-5 h-5" alt="Facebook">
                        <span class="text-sm font-black text-slate-600">Continue with Facebook</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
