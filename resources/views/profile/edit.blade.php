<x-app-layout>
    <div class="min-h-screen bg-[#F8F9FA] pb-20 relative overflow-hidden font-sans">
        <!-- Full-Top Emerald Header -->
        <div class="absolute top-0 left-0 right-0 h-[400px] pointer-events-none overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-emerald-900"></div>
            <img src="{{ asset('images/banner.png') }}" alt="" class="w-full h-full object-cover opacity-20 scale-125">
            <div class="absolute inset-0 bg-black/10"></div>
            
            <!-- Dynamic Curve -->
            <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                <path fill="#F8F9FA" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,197.3C384,203,480,181,576,149.3C672,117,768,75,864,80C960,85,1056,139,1152,154.7C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>

        <div class="max-w-md mx-auto px-6 relative pt-24 md:pt-32">
            <!-- Content starts below navigation bar -->

            <!-- Profile Info Header -->
            <div class="flex flex-col items-center mb-8">
                <form id="avatarForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="relative mb-6">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    
                    <div class="w-24 h-24 md:w-28 md:h-28 rounded-[2.5rem] bg-white p-1.5 shadow-2xl relative group overflow-hidden border border-white/50">
                        <div class="w-full h-full rounded-[2rem] bg-slate-100 overflow-hidden relative border border-slate-50">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-400 to-emerald-600 text-white">
                                    <span class="text-3xl font-black">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <label for="avatarInput" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </label>
                        </div>
                        <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*" onchange="document.getElementById('avatarForm').submit()">
                    </div>
                </form>

                <div class="text-center">
                    <h2 class="text-2xl font-black text-white tracking-tight">{{ $user->name }}</h2>
                    <p class="text-white/70 font-bold text-xs mt-1">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Banner Card (Emerald Style) -->
            <div class="mb-8 p-6 bg-gradient-to-r from-emerald-500 to-emerald-700 rounded-[2rem] relative overflow-hidden shadow-xl shadow-emerald-100 border border-emerald-400/20">
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 flex items-center justify-center text-white bg-white/20 rounded-2xl backdrop-blur-md border border-white/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-black text-sm tracking-tight text-shadow-sm">Undang Teman</h4>
                        <p class="text-emerald-50/90 text-[10px] font-bold">Kelola catatan kas kelas bersama.</p>
                    </div>
                </div>
                <!-- Floaties -->
                <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute top-2 right-12 w-2 h-2 bg-emerald-300/30 rounded-full"></div>
            </div>

            <!-- Settings List -->
            <div class="space-y-3">
                <!-- Manage Profile -->
                <div x-data="{ open: false }" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between hover:bg-emerald-50/30 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="text-slate-400 group-hover:text-emerald-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <span class="font-bold text-slate-800 text-sm group-hover:text-emerald-700 transition-colors">Informasi Profil</span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 group-hover:bg-emerald-100 group-hover:text-emerald-500 transition-all shadow-sm">
                             <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-7 pb-8 pt-2">
                             @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div x-data="{ open: false }" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between hover:bg-emerald-50/30 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="text-slate-400 group-hover:text-emerald-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <span class="font-bold text-slate-800 text-sm group-hover:text-emerald-700 transition-colors">Keamanan Login</span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 group-hover:bg-emerald-100 group-hover:text-emerald-500 transition-all shadow-sm">
                             <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-7 pb-8 pt-2">
                             @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <!-- Logout -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full px-6 py-5 flex items-center justify-between hover:bg-rose-50 transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="text-slate-400 group-hover:text-rose-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </div>
                                <span class="font-bold text-slate-800 text-sm group-hover:text-rose-600 transition-colors">Keluar Akun</span>
                            </div>
                            <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 group-hover:bg-rose-100 group-hover:text-rose-500 transition-all shadow-sm">
                                 <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Delete Account -->
                <div x-data="{ open: false }" class="bg-rose-50/30 rounded-3xl border border-rose-100 overflow-hidden">
                    <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between hover:bg-rose-100/40 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="text-rose-300 group-hover:text-rose-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                            <span class="font-black text-rose-400 text-[10px] uppercase tracking-widest group-hover:text-rose-500 transition-colors">Delete Account</span>
                        </div>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="px-7 pb-8 pt-2">
                             @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 text-center pb-10">
                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]">Treasurer v1.0.4</p>
            </div>
        </div>
    </div>
</x-app-layout>
