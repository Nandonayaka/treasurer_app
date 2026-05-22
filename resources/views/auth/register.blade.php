<x-guest-layout>
    <div class="flex flex-col md:flex-row min-h-screen bg-white md:bg-slate-50 font-plus-jakarta overflow-hidden" 
         x-data="{ isLogin: {{ request()->routeIs('login') ? 'true' : 'false' }} }">
        
        <!-- MOBILE BANNER (ANDROID STYLE) -->
        <div class="md:hidden px-6 pt-12 pb-24 relative overflow-hidden shrink-0 bg-emerald-600" data-aos="fade-down">
            <img src="{{ asset('images/banner2.png') }}" class="absolute inset-[-20%] w-[140%] h-[140%] object-cover opacity-40 mix-blend-overlay -rotate-12">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/50 to-transparent"></div>
            
            <div class="flex justify-between items-center mb-10 relative z-10" data-aos="fade-right" data-aos-delay="200">
                <a href="{{ url('/') }}" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
            </div>

            <div class="relative z-10" data-aos="fade-up" data-aos-delay="400">
                <h1 class="text-4xl font-black text-white tracking-tight leading-none mb-1" x-text="isLogin ? 'Masuk' : 'Daftar'"></h1>
                <p class="text-emerald-100 font-bold text-xs opacity-90" x-text="isLogin ? 'Halo! Selamat datang kembali!' : 'Mulai kelola kas organisasi sekarang!'"></p>
            </div>
        </div>

        <!-- DESKTOP BANNER (LEFT SIDE - FIXING POSITION) -->
        <div class="hidden md:flex md:w-[45%] lg:w-[40%] relative overflow-hidden bg-emerald-600 p-16 flex-col justify-between border-r border-slate-100 order-first">
            <img src="{{ asset('images/banner2.png') }}" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-emerald-900/40 backdrop-blur-[1px]"></div>

            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center border border-white/20">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain brightness-0 invert">
                        </div>
                    </a>
                </div>

                <div class="max-w-sm" data-aos="fade-up" data-aos-delay="400">
                    <h1 class="text-4xl lg:text-5xl font-black text-white tracking-tight leading-[1.1] mb-6">
                        Solusi Kelola <br><span class="text-white/80" x-text="isLogin ? 'Kas Kita.' : 'Organisasi.'"></span>
                    </h1>
                    <p class="text-white/70 text-lg font-medium leading-relaxed" 
                       x-text="isLogin ? 'Masuk ke dashboard untuk kelola keuangan organisasi.' : 'Mulai catat transaksi secara transparan sekarang.'"></p>
                </div>

                <div class="grid grid-cols-3 gap-3" data-aos="fade-up" data-aos-delay="600">
                    <div :class="isLogin ? 'bg-white shadow-xl' : 'bg-white/20'" class="rounded-[1.5rem] h-28 flex flex-col items-center justify-center transition-all group">
                        <div :class="isLogin ? 'bg-emerald-600 text-white' : 'bg-white/40 text-white/80'" class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-black mb-3">1</div>
                        <p :class="isLogin ? 'text-emerald-900' : 'text-white/80'" class="text-[9px] font-black tracking-widest leading-none text-center">DATA AKUN</p>
                    </div>
                    <div class="bg-white/20 rounded-[1.5rem] h-28 flex flex-col items-center justify-center border border-white/20">
                        <div class="w-6 h-6 bg-white/40 text-white/80 rounded-full flex items-center justify-center text-[10px] font-black mb-3">2</div>
                        <p class="text-[9px] font-black text-white/80 tracking-widest leading-none text-center">PILIH RUANG</p>
                    </div>
                    <div class="bg-white/20 rounded-[1.5rem] h-28 flex flex-col items-center justify-center border border-white/20">
                        <div class="w-6 h-6 bg-white/40 text-white/80 rounded-full flex items-center justify-center text-[10px] font-black mb-3">3</div>
                        <p class="text-[9px] font-black text-white/80 tracking-widest leading-none text-center">KELOLA KAS</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORM SECTION (RIGHT SIDE ON DESKTOP) -->
        <div class="flex-1 bg-white -mt-12 md:mt-0 rounded-t-[3rem] md:rounded-none px-8 pt-10 pb-12 relative z-20 flex flex-col justify-center order-last">
            <div class="w-full max-w-[440px] mx-auto relative flex flex-col justify-center">
                
                <div class="mb-10 hidden md:block" data-aos="fade-down" data-aos-delay="800">
                    <h2 class="text-4xl font-black text-slate-900 tracking-tight mb-2" x-text="isLogin ? 'Masuk Akun' : 'Daftar Akun'"></h2>
                    <p class="text-slate-500 text-sm font-medium" x-text="isLogin ? 'Silakan masuk ke akun Anda.' : 'Buat akun Anda dalam hitungan detik.'"></p>
                </div>

                <!-- LOGIN FORM -->
                <div x-show="isLogin" x-transition:enter="transition-all ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <input type="email" name="email" :value="old('email')" required placeholder="Alamat Email"
                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-emerald-600 transition-all">
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="password" required placeholder="Kata Sandi"
                                class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 pr-14 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-emerald-600 transition-all">
                            <button type="button" @click="show = !show" class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 transition-colors focus:outline-none">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.040m4.577-2.274A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.101-2.101L3 3m1.442 1.442a9.956 9.956 0 0110.87-10.87m2.41 2.41a3.041 3.041 0 011.162 1.162M12 12c-1.103 0-2.002.899-2.002 2.002a3.003 3.003 0 003.003 3.003M9.75 9.75l4.5 4.5"/></svg>
                            </button>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-lg shadow-xl shadow-slate-200 hover:bg-emerald-600 transition-all active:scale-95 leading-none">
                                Masuk
                            </button>
                        </div>
                    </form>
                    <div class="mt-8 text-center text-sm font-medium text-slate-500">
                        Belum punya akun? <button @click="isLogin = false; history.pushState(null, '', '{{ route('register') }}')" class="text-emerald-600 font-black hover:text-emerald-700 transition-colors">Daftar Sekarang</button>
                    </div>
                </div>

                <!-- REGISTER FORM -->
                <div x-show="!isLogin" x-transition:enter="transition-all ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-cloak data-aos="fade-up" data-aos-delay="1000">
                    <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ rPass: '' }">
                        @csrf
                        <input type="text" name="name" required placeholder="Nama Lengkap"
                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-600 transition-all">
                        <input type="email" name="email" required placeholder="Alamat Email"
                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-600 transition-all">
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="password" x-model="rPass" required placeholder="Password"
                                class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 pr-14 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-600 transition-all">
                            <button type="button" @click="show = !show" class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 transition-colors focus:outline-none">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.040m4.577-2.274A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.101-2.101L3 3m1.442 1.442a9.956 9.956 0 0110.87-10.87m2.41 2.41a3.041 3.041 0 011.162 1.162M12 12c-1.103 0-2.002.899-2.002 2.002a3.003 3.003 0 003.003 3.003M9.75 9.75l4.5 4.5"/></svg>
                            </button>
                        </div>
                        <input type="hidden" name="password_confirmation" x-bind:value="rPass">
                        <div class="pt-4">
                            <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-lg shadow-xl shadow-slate-200 hover:bg-emerald-600 transition-all active:scale-95 leading-none">
                                Daftar
                            </button>
                        </div>
                    </form>
                    <div class="mt-8 text-center text-sm font-medium text-slate-500">
                        Sudah punya akun? <button @click="isLogin = true; history.pushState(null, '', '{{ route('login') }}')" class="text-emerald-600 font-black hover:text-emerald-700 transition-colors">Masuk</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
