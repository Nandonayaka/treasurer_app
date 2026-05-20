<x-app-layout>
    <div x-data="{ 
        showDrawer: {{ $errors->any() ? 'true' : 'false' }},
        now: new Date(),
        init() {
            setInterval(() => {
                this.now = new Date();
            }, 1000);
        },
        get formattedTime() {
            return new Intl.DateTimeFormat('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false,
                timeZone: 'Asia/Jakarta'
            }).format(this.now);
        },
        get formattedDate() {
            return new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                timeZone: 'Asia/Jakarta'
            }).format(this.now);
        }
    }" class="min-h-screen bg-slate-50/50">
        <!-- Main Dashboard Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
            <!-- Mobile Clock & Date Header -->
            <div class="lg:hidden mb-10 flex items-center justify-between bg-emerald-600 rounded-[1.2rem] p-6 border border-emerald-500 shadow-[0_15px_40px_-20px_rgba(16,185,129,0.4)] relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <p x-text="formattedDate" class="text-emerald-50 font-bold text-[10px] tracking-tight uppercase mb-1.5"></p>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></div>
                        <p class="text-white/80 font-black text-[9px] uppercase tracking-[0.2em]">Waktu Indonesia (WIB)</p>
                    </div>
                </div>
                <div class="relative z-10 text-right">
                    <h2 x-text="formattedTime" class="text-3xl font-black text-white tracking-tighter tabular-nums leading-none"></h2>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                
                <!-- Middle Area: Content (Classroom Cards) -->
                <div class="flex-1 space-y-10">
                    <!-- Dashboard Welcome Banner (Simplified) -->
                    <div class="relative bg-gradient-to-r from-emerald-500/10 to-teal-500/5 rounded-3xl p-6 md:p-8 overflow-hidden mb-8 group border border-emerald-100 flex items-center justify-between">
                        <div class="absolute -right-10 -top-10 w-64 h-64 bg-emerald-200/20 rounded-full blur-[80px] group-hover:scale-110 transition-transform duration-1000"></div>
                        
                        <div class="relative z-10 text-left">
                            <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight leading-none mb-2">Halo {{ Auth::user()->name }}!</h1>
                            <p class="text-slate-500 font-medium text-xs md:text-sm max-w-sm leading-relaxed">Siap untuk mengelola keuangan organisasi hari ini?</p>
                        </div>

                        <div class="relative z-10 shrink-0 hidden md:block">
                            <div class="w-20 h-20 bg-white/40 backdrop-blur-sm rounded-2xl p-4 flex items-center justify-center shadow-lg shadow-emerald-900/5 border border-white/50">
                                <svg class="w-full h-full text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Ruang Kas Saya</h2>
                        <button @click="showDrawer = true" class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200/50 flex items-center gap-2 active:scale-95 text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                            Buat Baru
                        </button>
                    </div>

                    <!-- Classes List (Grid Style) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-20">
                        @forelse($classrooms as $classroom)
                            @php
                                $income = $classroom->transactions->where('type', 'income')->sum('amount');
                                $expense = $classroom->transactions->where('type', 'expense')->sum('amount');
                                $balance = $income - $expense;
                                
                                $colors = ['emerald', 'blue', 'indigo', 'rose', 'amber'];
                                $color = $colors[$classroom->id % count($colors)];
                            @endphp
                            <a href="{{ route('classrooms.show', $classroom) }}" 
                               class="group relative bg-white border border-slate-100 p-6 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-emerald-100/30 hover:border-emerald-200 hover:-translate-y-1 transition-all duration-500 flex flex-col justify-between overflow-hidden">
                                <!-- Subtle Background Pattern -->
                                <div class="absolute -right-8 -top-8 w-24 h-24 bg-{{ $color }}-50 rounded-full blur-3xl opacity-50 group-hover:opacity-100 group-hover:bg-emerald-50 transition-all duration-700"></div>
                                
                                <div class="relative z-10">
                                    <div class="flex items-start justify-between mb-6">
                                        <div class="w-12 h-12 bg-{{ $color }}-50 rounded-xl flex items-center justify-center text-{{ $color }}-600 group-hover:bg-emerald-600 group-hover:text-white group-hover:scale-110 transition-all duration-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1">Total Saldo</p>
                                            <p class="text-lg font-black text-slate-900 tabular-nums tracking-tight">Rp{{ number_format($balance, 0, ',', '.') }}</p>
                                        </div>
                                    </div>

                                    <div>
                                        <h3 class="text-lg font-black text-slate-800 tracking-tight group-hover:text-emerald-600 transition-colors mb-1 leading-tight">{{ $classroom->name }}</h3>
                                        <p class="text-slate-400 font-medium text-xs line-clamp-1 opacity-80 group-hover:opacity-100 transition-opacity">{{ $classroom->description }}</p>
                                    </div>
                                </div>

                                <div class="relative z-10 mt-6 pt-4 border-t border-slate-50 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-1.5 h-1.5 rounded-full bg-slate-200 group-hover:bg-emerald-400 transition-colors"></div>
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter group-hover:text-slate-600 transition-colors">{{ $classroom->members_count ?? $classroom->members()->count() }} Anggota</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-1.5 h-1.5 rounded-full bg-slate-200 group-hover:bg-emerald-400 transition-colors"></div>
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter group-hover:text-slate-600 transition-colors">{{ $classroom->transactions->count() }} Transaksi</span>
                                        </div>
                                    </div>
                                    <div class="w-7 h-7 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"/></svg>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="md:col-span-2 py-24 text-center bg-white rounded-[2.5rem] border border-dashed border-slate-200">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <h4 class="text-slate-800 font-black text-xl tracking-tight">Belum Ada Ruang Kas</h4>
                                <p class="text-slate-400 font-medium mt-2">Mulai dengan membuat ruang pertama Anda hari ini.</p>
                                <button @click="showDrawer = true" class="mt-8 bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-emerald-600 transition-all shadow-xl active:scale-95 text-sm">Buat Ruang Sekarang</button>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Area: Sidebar (Clock, Calendar, Stats) -->
                <div class="w-full lg:w-[310px] space-y-6">
                    <!-- Real-time Indonesia Date & Time (Desktop only) -->
                    <div class="hidden lg:block bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-3xl p-7 text-white relative overflow-hidden group shadow-lg shadow-emerald-900/20">
                        <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-1000"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></div>
                                <p class="text-[9px] font-black text-emerald-100/70 uppercase tracking-widest">Waktu Indonesia (WIB)</p>
                            </div>
                            <h2 x-text="formattedTime" class="text-4xl font-black tracking-tight tabular-nums mb-1 leading-none"></h2>
                            <p x-text="formattedDate" class="text-emerald-50/80 font-bold text-xs tracking-tight capitalize"></p>
                        </div>
                    </div>

                    <!-- Modern Calendar Component (Desktop only) -->
                    <div class="hidden lg:block bg-white rounded-3xl p-7 border border-slate-50 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-base font-black text-slate-800 tracking-tight" x-text="new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' }).format(now)"></h3>
                            <div class="flex gap-2">
                                <button class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-emerald-600 transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg></button>
                                <button class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-emerald-600 transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg></button>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-7 gap-y-3 text-center">
                            @php
                                $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                                $today = now()->day;
                            @endphp
                            @foreach($days as $day)
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-tight mb-2">{{ $day }}</span>
                            @endforeach
                            
                            @php
                                $startOfMonth = now()->startOfMonth();
                                $daysInMonth = now()->daysInMonth;
                                $dayOfWeek = $startOfMonth->dayOfWeekIso; // 1 (Mon) to 7 (Sun)
                            @endphp
                            
                            @for($i = 1; $i < $dayOfWeek; $i++)
                                <span></span>
                            @endfor
                            
                            @for($day = 1; $day <= $daysInMonth; $day++)
                                <div class="relative flex items-center justify-center py-1 h-8">
                                    @if($day == $today)
                                        <div class="absolute inset-0 bg-emerald-600 rounded-xl shadow-lg shadow-emerald-50 scale-90"></div>
                                        <span class="relative z-10 text-[11px] font-black text-white leading-none">{{ $day }}</span>
                                    @else
                                        <span class="text-[11px] font-bold text-slate-500 hover:text-emerald-600 transition-colors leading-none cursor-default">{{ $day }}</span>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Slide-over Drawer for Creating Class -->
        <div x-show="showDrawer" class="fixed inset-0 z-[100] overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="showDrawer" 
                     x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                     @click="showDrawer = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] transition-opacity"></div>

                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div x-show="showDrawer" 
                         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" 
                         class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl rounded-l-[3rem]">
                            <div class="px-8 pt-10 pb-6 border-b border-slate-50 text-center">
                                <h2 class="text-2xl font-black text-slate-800 tracking-tight" id="slide-over-title">Buat Ruang Kas</h2>
                                <p class="mt-1 text-sm text-slate-500 font-medium tracking-tight px-4">Buat wadah baru untuk mengelola catatan kas organisasi Anda.</p>
                            </div>

                            <form action="{{ route('classrooms.store') }}" method="POST" class="flex-1 px-8 py-10 space-y-5">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest pl-1 mb-2">Nama Ruang / Organisasi</label>
                                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="contoh: Kantor Cabang, Tim Marketing, XII IPA 1"
                                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-600 transition-all placeholder:text-slate-300 shadow-inner">
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest pl-1 mb-2">Deskripsi</label>
                                        <textarea name="description" rows="4" required placeholder="Tujuan atau catatan tentang organisasi ini..."
                                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-600 transition-all placeholder:text-slate-300 shadow-inner resize-none">{{ old('description') }}</textarea>
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>

                                    <div class="p-6 bg-emerald-50 rounded-[2rem] border border-emerald-100">
                                        <label class="text-[10px] font-black text-emerald-600 uppercase tracking-widest pl-1 mb-4 block text-center">Biaya Kas Per Periode</label>
                                        
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400">Rp</span>
                                            <input type="number" name="weekly_fee" value="{{ old('weekly_fee', 0) }}" required
                                                class="w-full bg-white border-emerald-100 border rounded-2xl py-4 pl-10 pr-6 text-sm font-black text-slate-700 focus:ring-2 focus:ring-emerald-600 transition-all shadow-sm">
                                        </div>
                                        <p class="text-[8px] text-emerald-600 mt-3 text-center font-bold uppercase tracking-tighter">*Siklus pembayaran kini dikelola secara manual (Next Periode)</p>
                                        
                                        <input type="hidden" name="billing_period_days" value="7">
                                        <input type="hidden" name="billing_at_time" value="00:00">
                                    </div>
                                </div>

                                <div class="pt-6 flex flex-col gap-3">
                                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-base shadow-xl shadow-slate-200 hover:bg-emerald-600 transition-all active:scale-95">
                                        Mulai Kelola Kas
                                    </button>
                                    <button @click="showDrawer = false" type="button" class="w-full py-4 text-slate-400 font-black text-sm hover:text-slate-600 transition-colors">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        [x-cloak] { display: none !important; }
        @keyframes pulse-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .animate-pulse-soft { animation: pulse-soft 3s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
    @endpush
</x-app-layout>



