<x-app-layout>
    <div x-data="{ showDrawer: {{ $errors->any() ? 'true' : 'false' }} }">
        <!-- Main Content -->
        <div class="py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Kelas Saya</h1>
                        <p class="text-slate-500 font-medium mt-1">Pilih kelas untuk mengelola kas.</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        @if(session('success'))
                            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                                 class="bg-emerald-50 text-emerald-700 px-4 py-2 rounded-2xl text-sm font-bold border border-emerald-100 flex items-center gap-2 shadow-sm">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                {{ session('success') }}
                            </div>
                        @endif
                        <button @click="showDrawer = true" class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 hover:bg-slate-800 transition-all hover:shadow-lg active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            Buat Kelas Baru
                        </button>
                    </div>
                </div>

                <!-- Classes Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($classrooms as $classroom)
                        @php
                            $income = $classroom->transactions->where('type', 'income')->sum('amount');
                            $expense = $classroom->transactions->where('type', 'expense')->sum('amount');
                            $balance = $income - $expense;
                        @endphp
                        <a href="{{ route('classrooms.show', $classroom) }}" class="group">
                            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-100/50 hover:shadow-slate-200/60 transition-all group-hover:-translate-y-2 relative overflow-hidden h-full flex flex-col">
                                <div class="absolute -right-4 -top-4 w-24 h-24 bg-slate-50 rounded-full blur-2xl group-hover:bg-emerald-50 transition-colors"></div>
                                
                                <div class="relative z-10 flex-1">
                                    <h3 class="text-2xl font-black text-slate-800 tracking-tight group-hover:text-emerald-600 transition-colors">{{ $classroom->name }}</h3>
                                    <p class="text-slate-400 font-medium mt-2 line-clamp-2 text-sm">{{ $classroom->description }}</p>
                                    
                                    <div class="mt-8 grid grid-cols-2 gap-4">
                                        <div class="bg-slate-50 rounded-2xl p-4">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Saldo</p>
                                            <p class="text-sm font-black text-slate-800 mt-1">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="bg-slate-50 rounded-2xl p-4">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aktivitas</p>
                                            <p class="text-sm font-black text-slate-800 mt-1">{{ $classroom->transactions->count() }} Transaksi</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 pt-6 border-t border-slate-50 flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Buka Dashboard</span>
                                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center group-hover:bg-emerald-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <h4 class="text-slate-800 font-black text-xl">Kelas Tidak Ditemukan</h4>
                            <p class="text-slate-500 font-medium">Buat kelas pertama Anda untuk mulai mencatat transaksi.</p>
                            <button @click="showDrawer = true" class="mt-8 bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold hover:bg-slate-800 transition-all shadow-lg active:scale-95">Mulai</button>
                        </div>
                    @endforelse
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
                                <h2 class="text-2xl font-black text-slate-800" id="slide-over-title">Buat Kelas</h2>
                                <p class="mt-1 text-sm text-slate-500 font-medium tracking-tight px-4">Buat grup baru untuk mengelola catatan kas kelas.</p>
                            </div>

                            <form action="{{ route('classrooms.store') }}" method="POST" class="flex-1 px-8 py-10 space-y-5">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest pl-1 mb-2">Nama Kelas</label>
                                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="contoh: Kelas XII IPA 1"
                                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300 shadow-inner">
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest pl-1 mb-2">Deskripsi</label>
                                        <textarea name="description" rows="4" required placeholder="Tujuan atau catatan tentang kelas ini..."
                                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all placeholder:text-slate-300 shadow-inner resize-none">{{ old('description') }}</textarea>
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>

                                    <div class="p-6 bg-emerald-50 rounded-[2rem] border border-emerald-100" x-data="{ 
                                        periodType: '7', 
                                        customDays: 7, 
                                        customHours: 0,
                                        targetDate: '',
                                        totalPeriodDays: 7,
                                        weeklyFee: {{ old('weekly_fee', 0) }}, billingTime: '00:00',
                                        updateFromDate() {
                                            if (!this.targetDate) return;
                                            const target = new Date(this.targetDate);
                                            const now = new Date();
                                            let diffMs = target - now;
                                            
                                            // If user picks a past or near date, allow it but cap at a tiny positive number to avoid server error
                                            if (diffMs < 1000) diffMs = 1000; 
                                            
                                            this.totalPeriodDays = diffMs / (1000 * 60 * 60 * 24);
                                            this.customDays = Math.floor(this.totalPeriodDays);
                                            this.customHours = Math.round((this.totalPeriodDays - this.customDays) * 24);
                                            this.billingTime = target.getHours().toString().padStart(2, '0') + ':' + target.getMinutes().toString().padStart(2, '0');
                                        }
                                    }">
                                        <label class="text-[10px] font-black text-emerald-600 uppercase tracking-widest pl-1 mb-4 block text-center">Sistem Periode</label>
                                        
                                        <div class="flex bg-white/50 p-1 rounded-2xl mb-4 border border-emerald-50">
                                            <button type="button" @click="periodType = '3'; customDays = 3; customHours = 0; billingTime = '00:00'; totalPeriodDays = 3" :class="periodType == '3' ? 'bg-emerald-600 text-white shadow-lg' : 'text-emerald-400'" class="flex-1 py-3 rounded-xl text-[10px] font-black transition-all">3 HARI</button>
                                            <button type="button" @click="periodType = '7'; customDays = 7; customHours = 0; billingTime = '00:00'; totalPeriodDays = 7" :class="periodType == '7' ? 'bg-emerald-600 text-white shadow-lg' : 'text-emerald-400'" class="flex-1 py-3 rounded-xl text-[10px] font-black transition-all">7 HARI</button>
                                            <button type="button" @click="periodType = 'custom'" :class="periodType == 'custom' ? 'bg-emerald-600 text-white shadow-lg' : 'text-emerald-400'" class="flex-1 py-3 rounded-xl text-[10px] font-black transition-all">KUSTOM</button>
                                        </div>

                                        <div x-show="periodType === 'custom'" x-transition class="space-y-3 mb-4">
                                            <div class="bg-white/60 p-4 rounded-xl border border-emerald-100 text-center">
                                                <label class="text-[9px] font-black text-emerald-500 uppercase mb-2 block">Pilih Tanggal Deadline</label>
                                                <input type="datetime-local" x-model="targetDate" @change="updateFromDate()"
                                                    class="w-full bg-white border-emerald-100 border rounded-xl py-2 px-3 text-[10px] font-black text-emerald-700">
                                            </div>
                                            <div class="grid grid-cols-2 gap-2 hidden">
                                                <input type="number" x-model="customDays" placeholder="Hari"
                                                    class="w-full bg-white border-emerald-100 border rounded-xl py-3 px-4 text-xs font-black text-emerald-700">
                                                <input type="number" x-model="customHours" placeholder="Jam"
                                                    class="w-full bg-white border-emerald-100 border rounded-xl py-3 px-4 text-xs font-black text-emerald-700">
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="billing_period_days" :value="totalPeriodDays"><input type="hidden" name="weekly_fee" :value="weeklyFee">

                                        <div class="mt-4 pt-4 border-t border-emerald-100 flex gap-3" x-show="periodType !== 'custom'">
                                            <div class="flex-1">
                                                <label class="text-[9px] font-black text-emerald-400 uppercase tracking-widest pl-1 mb-2 block text-center">Pukul</label>
                                                <input type="time" name="billing_at_time" x-model="billingTime" :disabled="periodType === 'custom'"
                                                    class="w-full bg-white border-emerald-100 border rounded-xl py-2 px-3 text-[10px] font-black text-emerald-700 text-center">
                                            </div>
                                            <div class="flex-1">
                                                <label class="text-[9px] font-black text-emerald-400 uppercase tracking-widest pl-1 mb-2 block text-center">Uang Kas</label>
                                                <div class="relative">
                                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400">Rp</span>
                                                    <input type="number" x-model="weeklyFee" :disabled="periodType === 'custom'"
                                                        class="w-full bg-white border-emerald-100 border rounded-xl py-2 pl-8 pr-3 text-[10px] font-black text-slate-700 focus:ring-1 focus:ring-emerald-500 transition-all">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 pt-4 border-t border-emerald-100" x-show="periodType === 'custom'">
                                            <div class="flex gap-4 items-end">
                                                <div class="flex-1 hidden">
                                                    <label class="text-[9px] font-black text-emerald-400 uppercase tracking-widest pl-1 mb-2 block text-center">Pukul</label>
                                                    <input type="time" name="billing_at_time" x-model="billingTime" :disabled="periodType !== 'custom'"
                                                        class="w-full bg-white border-emerald-100 border rounded-xl py-2 px-3 text-[10px] font-black text-emerald-700 text-center">
                                                </div>
                                                <div class="flex-1">
                                                    <label class="text-[9px] font-black text-emerald-400 uppercase tracking-widest pl-1 mb-2 block text-center">Uang Kas</label>
                                                    <div class="relative">
                                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400">Rp</span>
                                                        <input type="number" x-model="weeklyFee" :disabled="periodType !== 'custom'"
                                                            class="w-full bg-white border-emerald-100 border rounded-xl py-3 pl-10 pr-4 text-sm font-black text-slate-700 focus:ring-1 focus:ring-emerald-500 transition-all">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('weekly_fee')" class="mt-2" />
                                        <x-input-error :messages="$errors->get('billing_period_days')" class="mt-2" />
                                        <x-input-error :messages="$errors->get('billing_at_time')" class="mt-2" />
                                        
                                        <!-- Persistent hidden billing_at_time for custom mode -->
                                        <input type="hidden" name="billing_at_time" :value="billingTime" x-bind:disabled="periodType !== 'custom' && !!document.querySelector('input[name=billing_at_time]:not([type=hidden])')">
                                    </div>
                                </div>

                                <div class="pt-6 flex flex-col gap-3">
                                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-base shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all active:scale-95">
                                        Buat Kelas
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
    </style>
    @endpush
</x-app-layout>


