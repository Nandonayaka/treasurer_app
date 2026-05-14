<x-app-layout>
    <div x-data="{ 
        showDrawer: false, 
        showEditDrawer: false,
        showMemberDrawer: false, 
        showDetailModal: false,
        showConfirmModal: false,
        showNextPeriodModal: false,
        searchMember: '', 
        selectedMember: '', 
        memberName: '',
        txAmount: '',
        txDescription: '',
        activeMember: null
    }">
        <!-- Main Content -->
        <div class="py-6 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section (Mobile Optimized) -->
                <div class="mb-8 flex flex-col gap-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <a href="{{ route('dashboard') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                            </a>
                            <div>
                                <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $classroom->name }}</h1>
                                <div class="flex items-center gap-2">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Treasurer Dashboard</p>
                                    <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                    <span class="text-[8px] font-black bg-emerald-100 text-emerald-600 px-2 py-0.5 rounded-full uppercase tracking-widest flex items-center gap-1">
                                        Periode {{ $classroom->current_period }}
                                        <span class="w-1 h-1 bg-emerald-300 rounded-full"></span>
                                        <span class="opacity-70">Manual</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 md:gap-3">
                            <!-- Management Group (Clean pill style) -->
                            <div class="flex bg-white/50 backdrop-blur-md p-1 rounded-xl md:p-1.5 md:rounded-2xl border border-slate-200/60 shadow-sm items-center gap-0.5 md:gap-1">
                                <button @click="showEditDrawer = true" title="Pengaturan Kelas" class="w-8 h-8 md:w-9 md:h-9 rounded-lg md:rounded-xl flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-300">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </button>
                                <div class="w-px h-3 md:h-4 bg-slate-200 mx-0.5 md:mx-1"></div>
                                <button @click="showMemberDrawer = true" title="Tambah Anggota" class="w-8 h-8 md:w-9 md:h-9 rounded-lg md:rounded-xl flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-300">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                </button>
                            </div>

                            <!-- Next Period Action (Prominent Glass) -->
                            <button @click="showNextPeriodModal = true" class="flex items-center gap-2.5 px-4 md:px-5 h-10 md:h-12 rounded-2xl bg-emerald-600 text-white hover:bg-emerald-700 active:scale-95 transition-all duration-300 shadow-lg shadow-emerald-200/50 group overflow-hidden relative">
                                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                <svg class="w-4 h-4 md:w-5 md:h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                                <span class="text-[10px] md:text-xs font-black uppercase tracking-widest relative z-10">Next Periode</span>
                            </button>

                            <!-- Primary Action (Icon only for balance) -->
                            <button @click="showDrawer = true" title="Tambah Transaksi" class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-xl shadow-slate-200 hover:bg-slate-800 active:scale-90 transition-all duration-300">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>
                    </div>
                    
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                             class="bg-emerald-500 text-white px-4 py-3 rounded-2xl text-[11px] font-black flex items-center gap-2 shadow-lg shadow-emerald-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <!-- Stats Section (Compact) -->
                <div class="mb-6 space-y-3">
                    @php
                        $income = $allTransactions->where('type', 'income')->sum('amount');
                        $expense = $allTransactions->where('type', 'expense')->sum('amount');
                        $balance = $income - $expense;
                    @endphp
                    
                    <!-- Balance Hero Card (Slim) -->
                    <div class="rounded-[1.5rem] text-white relative overflow-hidden shadow-lg" style="min-height: 80px;">
                        <img src="{{ asset('images/banner-total-balance.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover object-center">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-800/70 to-emerald-600/50"></div>
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="relative z-10 flex flex-col items-center text-center px-5 py-4">
                            <p class="text-white/70 text-[8px] font-black uppercase tracking-[0.2em] mb-0.5">Saldo utama</p>
                            <h2 class="text-lg md:text-2xl font-black tracking-tight drop-shadow-lg">Rp{{ number_format($balance, 0, ',', '.') }}</h2>
                        </div>
                    </div>

                    <!-- In/Out Grid (Compact) -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-white rounded-[1.5rem] md:rounded-[2rem] p-3 md:p-6 border border-slate-100 shadow-sm flex flex-col items-center">
                            <p class="text-emerald-500 text-[7px] md:text-[9px] font-black uppercase tracking-wider">Total Masuk</p>
                            <h3 class="text-xs md:text-xl font-black text-slate-800 mt-0.5">Rp{{ number_format($income, 0, ',', '.') }}</h3>
                        </div>

                        <div class="bg-white rounded-[1.5rem] md:rounded-[2rem] p-3 md:p-6 border border-slate-100 shadow-sm flex flex-col items-center">
                            <p class="text-rose-500 text-[7px] md:text-[9px] font-black uppercase tracking-wider">Total Keluar</p>
                            <h3 class="text-xs md:text-xl font-black text-slate-800 mt-0.5">Rp{{ number_format($expense, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="space-y-12">
                    <!-- Activity Table Section (MOVED TO TOP) -->
                    <div class="w-full">
                        <div class="flex items-center justify-between mb-4 px-1">
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Aktivitas Terbaru</h3>
                            <a href="{{ route('classrooms.history', $classroom) }}" class="flex items-center gap-1 text-slate-400 hover:text-slate-900 transition-colors group">
                                <span class="text-[10px] font-black uppercase">Lihat Riwayat</span>
                                <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-all text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                        <div class="bg-white rounded-[2rem] md:rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/40 overflow-hidden">
                            <div class="divide-y divide-slate-50">
                                @forelse($transactions as $transaction)
                                    @php
                                        $displayTitle = $transaction->name === 'General' ? $transaction->description : $transaction->name;
                                        $isLong = strlen($displayTitle) > 40;
                                    @endphp
                                    <div x-data="{ expanded: false }" class="px-5 py-4 md:px-10 md:py-8 flex items-start justify-between hover:bg-slate-50/50 transition-all border-b border-slate-50 last:border-0">
                                        <div class="flex items-start gap-4 md:gap-8 flex-1 min-w-0">
                                            <div class="w-10 h-10 md:w-16 md:h-16 rounded-xl md:rounded-2xl shrink-0 flex items-center justify-center text-xs md:text-xl shadow-sm {{ $transaction->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                                @if($transaction->type === 'income')
                                                    <svg class="w-4 h-4 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                                @else
                                                    <svg class="w-4 h-4 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"/></svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-col">
                                                    <h4 class="font-black text-slate-800 text-sm md:text-xl leading-snug break-words"
                                                        :class="expanded ? '' : 'line-clamp-1 truncate'">
                                                        {{ $displayTitle }}
                                                    </h4>
                                                    @if($isLong)
                                                        <button @click="expanded = !expanded" class="text-[9px] md:text-xs font-black text-blue-500 hover:text-blue-700 mt-1 text-left uppercase tracking-tighter">
                                                            <span x-text="expanded ? 'Hide' : 'Read More'"></span>
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-1.5 md:gap-3 mt-1.5">
                                                    <span class="text-slate-400 text-[9px] md:text-sm font-medium">{{ \Carbon\Carbon::parse($transaction->date)->format('d M, H:i') }}</span>
                                                    <span class="w-0.5 h-0.5 bg-slate-200 rounded-full"></span>
                                                    <span class="text-emerald-500/80 text-[9px] md:text-sm font-black">{{ $transaction->member ? $transaction->member->name : 'Class Fund' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0 ml-4">
                                            <p class="text-xs md:text-2xl font-black {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-slate-900' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }}Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-12 text-center">
                                        <p class="text-slate-400 font-bold text-xs">Belum ada aktivitas</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                     @push('scripts')
                     <script>
                         function memberPanel() {
                             return {
                                 memberSearch: '', 
                                 genderFilter: 'all', 
                                 statusFilter: 'all',
                                 currentPage: 1, 
                                 perPage: 6,
                                 members: @json($membersData),
                                 get filteredMembers() {
                                     return this.members.filter(m => {
                                         const matchSearch = String(m.name || '').toLowerCase().includes(this.memberSearch.toLowerCase());
                                         const matchGender = this.genderFilter === 'all' || m.gender === this.genderFilter;
                                         
                                         let matchStatus = true;
                                         if (this.statusFilter === 'paid') matchStatus = !m.isUnpaid;
                                         if (this.statusFilter === 'unpaid') matchStatus = m.isUnpaid;
                                         
                                         return matchSearch && matchGender && matchStatus;
                                     });
                                 },
                                 get paginatedMembers() {
                                     const start = (this.currentPage - 1) * this.perPage;
                                     return this.filteredMembers.slice(start, start + this.perPage);
                                 },
                                 get totalPages() {
                                     return Math.ceil(this.filteredMembers.length / this.perPage);
                                 },
                                 get unpaidCount() {
                                     return this.members.filter(m => m.isUnpaid).length;
                                 }
                             }
                         }
                     </script>
                     @endpush

                    <!-- Member Panel (Grid Layout) -->
                    <div class="w-full" x-data="memberPanel()">
                        <!-- Reminder Banner -->
                        <template x-if="unpaidCount > 0 && {{ (float)$classroom->weekly_fee }} > 0">
                            <div class="mb-8 p-4 md:p-6 bg-rose-50 border border-rose-100 rounded-[2rem] flex items-center justify-between shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-rose-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-rose-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm md:text-base font-black text-rose-900">Pengingat Mingguan</h4>
                                        <p class="text-[10px] md:text-xs font-bold text-rose-500 uppercase tracking-widest"><span x-text="unpaidCount"></span> anggota belum bayar minggu ini</p>
                                    </div>
                                </div>
                                <div class="text-right hidden sm:block">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Uang Kas</p>
                                    <p class="text-sm font-black text-slate-900">Rp{{ number_format($classroom->weekly_fee, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </template>

                        <!-- Member Controls (Enhanced Dropdowns) -->
                        <div class="flex flex-col md:flex-row gap-4 mb-8">
                            <!-- Search -->
                            <div class="relative flex-1">
                                <input type="text" x-model="memberSearch" @input="currentPage = 1" placeholder="Cari nama..." 
                                    class="w-full bg-white border border-slate-200 rounded-2xl py-4 pl-12 pr-4 text-xs font-bold text-slate-600 focus:ring-2 focus:ring-slate-900 focus:border-transparent shadow-sm">
                                <svg class="w-5 h-5 text-slate-300 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>

                            <!-- Dropdowns -->
                            <div class="flex gap-3">
                                <div class="relative min-w-[120px]">
                                    <select x-model="statusFilter" @change="currentPage = 1"
                                        class="w-full bg-white border border-slate-200 rounded-2xl py-4 pl-4 pr-10 text-[10px] font-black uppercase tracking-widest text-slate-600 appearance-none focus:ring-2 focus:ring-slate-900 focus:border-transparent shadow-sm cursor-pointer">
                                        <option value="all">Cek Status</option>
                                        <option value="paid">Lunas</option>
                                        <option value="unpaid">Belum Lunas</option>
                                    </select>
                                    <svg class="w-4 h-4 text-slate-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                                </div>

                                <div class="relative min-w-[120px]">
                                    <select x-model="genderFilter" @change="currentPage = 1"
                                        class="w-full bg-white border border-slate-200 rounded-2xl py-4 pl-4 pr-10 text-[10px] font-black uppercase tracking-widest text-slate-600 appearance-none focus:ring-2 focus:ring-slate-900 focus:border-transparent shadow-sm cursor-pointer">
                                        <option value="all">Jenis Kelamin</option>
                                        <option value="male">Laki-laki</option>
                                        <option value="female">Perempuan</option>
                                    </select>
                                    <svg class="w-4 h-4 text-slate-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4 min-h-[150px]">
                            <template x-for="member in paginatedMembers" :key="member.id">
                                <div @click="activeMember = member.allData; showDetailModal = true" 
                                     class="group bg-white rounded-2xl md:rounded-[2rem] p-4 md:p-5 border border-slate-100 shadow-xl shadow-slate-100/30 active:scale-95 transition-all cursor-pointer flex flex-col justify-between min-h-[130px] md:min-h-[180px] w-full max-w-[180px] mx-auto relative overflow-hidden">
                                     
                                     <!-- Unpaid Badge -->
                                     <template x-if="member.isUnpaid">
                                         <div class="absolute top-0 right-0">
                                             <div class="bg-rose-500 text-white text-[6px] md:text-[8px] font-black px-2 py-1 rounded-bl-xl uppercase tracking-tighter shadow-sm">
                                                 Belum Bayar
                                             </div>
                                         </div>
                                     </template>

                                     <!-- Paid indicator -->
                                     <template x-if="!member.isUnpaid">
                                         <div class="absolute top-3 right-3 w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                                             <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
                                         </div>
                                     </template>

                                     <div class="flex items-start justify-between">
                                         <div class="p-2 md:p-2.5 rounded-lg md:rounded-xl transition-all shrink-0"
                                              :class="member.gender === 'female' ? 'bg-rose-50 text-rose-300 group-hover:bg-rose-500 group-hover:text-white' : 'bg-blue-50 text-blue-300 group-hover:bg-blue-500 group-hover:text-white'">
                                             <template x-if="member.gender === 'female'">
                                                 <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 100 8 4 4 0 000-8zM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z" />
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v3m-2-2h4" />
                                                 </svg>
                                             </template>
                                             <template x-if="member.gender !== 'female'">
                                                 <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                             </template>
                                         </div>
                                         <div class="text-right">
                                             <template x-if="member.isUnpaid">
                                                 <div>
                                                     <p class="text-[6px] md:text-[8px] font-black text-rose-400 uppercase tracking-tight">Total Tunggakan</p>
                                                     <p class="text-[9px] md:text-sm font-black text-rose-600" x-text="member.debt < 0 ? '-Rp' + Math.abs(member.debt).toLocaleString('id-ID') : 'Rp0'"></p>
                                                 </div>
                                             </template>
                                             <template x-if="!member.isUnpaid">
                                                 <div>
                                                     <p class="text-[6px] md:text-[8px] font-black text-emerald-400 uppercase tracking-tight">Status</p>
                                                     <p class="text-[9px] md:text-sm font-black text-emerald-600">LUNAS</p>
                                                 </div>
                                             </template>
                                         </div>
                                     </div>
                                    
                                    <div class="mt-3">
                                        <h4 class="font-black text-slate-800 text-[10px] md:text-base leading-tight truncate transition-colors"
                                            :class="member.gender === 'female' ? 'group-hover:text-rose-600' : 'group-hover:text-blue-600'" x-text="member.name"></h4>
                                        <p class="text-[7px] md:text-[10px] text-slate-400 font-bold mt-0.5" x-text="member.lastTxdiff"></p>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Empty State -->
                        <div x-show="filteredMembers.length === 0" class="py-12 text-center bg-white rounded-[2rem] border border-dashed border-slate-200">
                             <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Anggota tidak ditemukan</p>
                        </div>

                        <!-- Pagination Controls -->
                        <x-pagination alpine class="mt-8" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Member Detail Modal (Mobile Tight) -->
        <div x-show="showDetailModal" class="fixed inset-0 z-[110] flex items-end md:items-center justify-center p-0 md:p-4" style="display: none;">
            <div x-show="showDetailModal" x-transition.opacity @click="showDetailModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-show="showDetailModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full md:translate-y-0 md:scale-95" x-transition:enter-end="opacity-100 translate-y-0 md:scale-100"
                 class="relative w-full max-w-2xl bg-white rounded-t-[2.5rem] md:rounded-[3rem] shadow-3xl overflow-hidden p-6 md:p-10">
                
                <template x-if="activeMember">
                    <div>
                        <div class="flex items-center justify-between mb-6 md:mb-8">
                            <div class="flex items-center gap-4 md:gap-6">
                                <div class="w-12 h-12 md:w-20 md:h-20 rounded-2xl md:rounded-3xl flex items-center justify-center shadow-lg"
                                     :class="activeMember.gender === 'female' ? 'bg-rose-500 text-white shadow-rose-100' : 'bg-blue-500 text-white shadow-blue-100'">
                                    <template x-if="activeMember.gender === 'female'">
                                        <svg class="w-6 h-6 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 100 8 4 4 0 000-8zM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v3m-2-2h4" />
                                        </svg>
                                    </template>
                                    <template x-if="activeMember.gender !== 'female'">
                                        <svg class="w-6 h-6 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </template>
                                </div>
                                <div>
                                    <h3 class="text-xl md:text-3xl font-black text-slate-900" x-text="activeMember.name"></h3>
                                    <p class="text-slate-400 font-bold uppercase text-[9px] md:text-xs tracking-widest mt-0.5" x-text="activeMember.gender === 'male' ? 'Laki-laki' : 'Perempuan'"></p>
                                </div>
                            </div>
                            <button @click="showDetailModal = false" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-6 mb-8">
                            <div class="bg-emerald-50 rounded-2xl p-4 md:p-6 border border-emerald-100">
                                <p class="text-emerald-600 text-[8px] md:text-xs font-black uppercase tracking-tight">Total Masuk</p>
                                <p class="text-sm md:text-2xl font-black text-emerald-700 mt-1">
                                    Rp<span x-text="activeMember.income.toLocaleString('id-ID')"></span>
                                </p>
                            </div>
                            <div class="bg-slate-50 rounded-2xl p-4 md:p-6 border border-slate-100">
                                <p class="text-slate-400 text-[8px] md:text-xs font-black uppercase tracking-tight">Frekuensi</p>
                                <p class="text-sm md:text-2xl font-black text-slate-800 mt-1" x-text="activeMember.transactions.length + 'x'"></p>
                            </div>
                             <div class="col-span-2 md:col-span-1 rounded-2xl p-4 md:p-6 border transition-all"
                                  :class="activeMember.isUnpaid ? 'bg-rose-50 border-rose-100' : 'bg-emerald-50 border-emerald-100'">
                                 <p class="text-[8px] md:text-xs font-black uppercase tracking-tight"
                                    :class="activeMember.isUnpaid ? 'text-rose-600' : 'text-emerald-600'">Status Saat Ini</p>
                                 <p class="text-sm md:text-xl font-black mt-1"
                                    :class="activeMember.isUnpaid ? 'text-rose-700' : 'text-emerald-700'"
                                    x-text="activeMember.isUnpaid ? 'BELUM LUNAS' : 'LUNAS'"></p>
                             </div>
                        </div>

                        <template x-if="activeMember.isUnpaid">
                            <div class="mb-8 space-y-3">
                                <div class="p-4 bg-rose-500 rounded-2xl md:rounded-3xl shadow-lg shadow-rose-100 flex items-center gap-4">
                                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-white shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-white font-black text-xs md:text-sm uppercase tracking-widest">Detail Tunggakan</h4>
                                        <p class="text-rose-100 text-[10px] md:text-xs font-bold mt-0.5" 
                                           x-text="activeMember.debt < 0 ? 'Total Kurang: -Rp' + Math.abs(activeMember.debt).toLocaleString('id-ID') : 'Belum bayar periode ini'"></p>
                                    </div>
                                    <button @click="selectedMember = activeMember.id; memberName = activeMember.name; txAmount = Math.abs(activeMember.debt); txDescription = 'Bayar Semua Tunggakan'; showDetailModal = false; showDrawer = true" 
                                            class="bg-white text-rose-600 px-4 py-2 rounded-xl font-black text-xs shadow-sm active:scale-95 transition-all">
                                        Bayar Semua
                                    </button>
                                </div>
                                
                                <div class="bg-rose-50/50 rounded-[2rem] p-5 md:p-7 border border-rose-100/50">
                                    <p class="text-rose-600 font-black text-[9px] md:text-[10px] uppercase tracking-[0.2em] mb-4 opacity-70">Rincian Tagihan Per Periode:</p>
                                    <div class="space-y-3">
                                        <template x-for="unpaid in activeMember.unpaidList" :key="unpaid.index">
                                            <div class="flex items-center justify-between p-3 bg-white rounded-2xl border border-rose-100 shadow-sm">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center text-[10px] font-black shadow-sm"
                                                         :class="unpaid.is_past ? 'bg-rose-500 text-white shadow-rose-100' : 'bg-amber-500 text-white shadow-amber-100'">
                                                        <span x-text="unpaid.index"></span>
                                                    </div>
                                                    <div>
                                                        <p class="font-black text-slate-700 text-xs md:text-sm" x-text="unpaid.date"></p>
                                                        <p class="text-[8px] md:text-[10px] font-bold" :class="unpaid.is_past ? 'text-rose-400' : 'text-amber-500'" 
                                                           x-text="unpaid.is_past ? 'Tagihan Lewat' : 'Periode Berjalan'"></p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <div class="text-right">
                                                        <p class="font-black text-rose-600 text-xs md:text-base leading-none" x-text="'Rp' + unpaid.amount_due.toLocaleString('id-ID')"></p>
                                                    </div>
                                                    <button @click="selectedMember = activeMember.id; memberName = activeMember.name; txAmount = unpaid.amount_due; txDescription = 'Bayar Periode ' + unpaid.index; showDetailModal = false; showDrawer = true"
                                                            class="w-8 h-8 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow-lg shadow-emerald-100 active:scale-95 transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="max-h-60 overflow-y-auto custom-scrollbar">
                            <div class="divide-y divide-slate-50">
                                <template x-for="tx in activeMember.transactions" :key="tx.id">
                                    <div class="py-3 flex justify-between items-center">
                                        <div>
                                            <p class="font-black text-slate-800 text-xs" x-text="tx.name"></p>
                                            <p class="text-[9px] font-bold text-slate-400" x-text="new Date(tx.date).toLocaleString('en-US', {day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit'})"></p>
                                        </div>
                                        <p class="font-black text-sm" :class="tx.type === 'income' ? 'text-emerald-600' : 'text-slate-800'" x-text="(tx.type === 'income' ? '+' : '-') + 'Rp' + parseInt(tx.amount).toLocaleString('en-US')"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Add Transaction Drawer -->
        <div x-show="showDrawer" class="fixed inset-0 z-[120] overflow-hidden" style="display: none;">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="showDrawer" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                     @click="showDrawer = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>

                <div class="fixed inset-y-0 right-0 flex max-w-full pl-6 md:pl-10">
                    <div x-show="showDrawer" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                         class="w-screen max-w-md">
                        <div class="flex h-full flex-col bg-white shadow-2xl rounded-l-[2rem] md:rounded-l-[3.5rem] overflow-hidden">
                            <div class="px-6 py-6 md:px-10 md:pt-12 md:pb-8 border-b border-slate-50 flex justify-between items-center">
                                <h1 class="text-xl md:text-3xl font-black text-slate-900">Tambah Transaksi</h1>
                                <button @click="showDrawer = false" class="p-2 md:p-3 bg-slate-50 rounded-xl text-slate-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <form id="txForm" x-ref="txForm" action="{{ route('transactions.store') }}" method="POST" @submit.prevent="showConfirmModal = true" class="flex-1 px-6 py-6 md:px-10 md:py-10 space-y-6 md:space-y-10 overflow-y-auto custom-scrollbar">
                                @csrf
                                <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                                <input type="hidden" name="member_id" x-model="selectedMember">
                                
                                <div class="space-y-6">
                                    <div class="relative" x-data="{ open: false, members: {{ $classroom->members->map(fn($m) => ['id' => $m->id, 'name' => $m->name])->toJson() }} }">
                                        <label class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest block mb-2">Pilih Anggota / Referensi</label>
                                        <div @click="open = !open" class="w-full p-4 md:p-5 bg-slate-50 rounded-xl md:rounded-[1.25rem] border border-slate-100 flex items-center justify-between cursor-pointer">
                                            <span class="font-black text-slate-800 text-sm md:text-base" x-text="memberName || 'Pilih anggota atau umum...'"></span>
                                            <svg class="w-4 h-4 text-slate-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                        <input type="hidden" name="name" x-model="memberName">
                                        
                                        <div x-show="open" @click.away="open = false" 
                                             class="absolute z-20 mt-2 w-full bg-white border border-slate-100 rounded-xl shadow-2xl p-2">
                                            <input type="text" x-model="searchMember" placeholder="Cari referensi..." 
                                                class="w-full rounded-lg border-slate-100 bg-slate-50 mb-2 focus:ring-0 text-xs p-3">
                                            <div class="max-h-40 overflow-y-auto custom-scrollbar space-y-1">
                                                <!-- General Option -->
                                                <div @click="selectedMember = ''; memberName = 'Umum'; open = false;" 
                                                     class="p-3 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg cursor-pointer flex items-center justify-between mb-1">
                                                    <span class="font-black text-[10px] uppercase">Kas Kelas (Umum)</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                </div>

                                                <template x-for="member in members.filter(m => m.name.toLowerCase().includes(searchMember.toLowerCase()))" :key="member.id">
                                                    <div @click="selectedMember = member.id; memberName = member.name; open = false;" 
                                                         class="p-3 hover:bg-slate-50 rounded-lg cursor-pointer flex items-center justify-between">
                                                        <span class="font-bold text-slate-600 text-xs" x-text="member.name"></span>
                                                    </div>
                                                </template>

                                                <div @click="memberName = searchMember; selectedMember = ''; open = false;" x-show="searchMember && !members.some(m => m.name.toLowerCase().includes(searchMember.toLowerCase()))"
                                                     class="p-3 bg-slate-900 rounded-lg cursor-pointer">
                                                     <p class="font-bold text-white text-[10px]" x-text="'Gunakan kustom: ' + searchMember"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4" x-data="{ type: 'income' }">
                                        <div>
                                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Nominal</label>
                                            <input type="number" name="amount" required x-model="txAmount"
                                                class="w-full bg-slate-50 border-0 rounded-xl p-4 font-black text-lg focus:ring-2 focus:ring-slate-900 transition-all">
                                        </div>
                                        <div>
                                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Tipe</label>
                                            <select name="type" x-model="type" class="w-full border-0 rounded-xl font-black text-[10px] p-4 focus:ring-0 transition-all uppercase tracking-tighter"
                                                :class="type === 'expense' ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600'">
                                                <option value="income">Masuk (+)</option>
                                                <option value="expense">Keluar (-)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 block">
                                            Catatan / Deskripsi
                                            <span x-show="memberName === 'Umum'" class="text-rose-500">*</span>
                                            <span x-show="memberName !== 'Umum'" class="text-slate-300 font-normal normal-case">(Opsional)</span>
                                        </label>
                                        <input type="text" name="description" :required="memberName === 'Umum'" x-model="txDescription" placeholder="contoh: Beli buku, dana sosial, dll." 
                                            class="w-full bg-slate-50 border-0 rounded-xl p-4 font-bold text-xs focus:ring-0">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-[9px] font-black text-slate-400 uppercase mb-2 block">Tanggal & Jam</label>
                                            <input type="datetime-local" name="date" required value="{{ date('Y-m-d\TH:i') }}" 
                                                class="w-full bg-slate-50 border-0 rounded-xl p-4 font-bold text-xs focus:ring-0 shadow-inner">
                                        </div>
                                        <div>
                                             <label class="text-[9px] font-black text-slate-400 uppercase mb-2 block">Tag</label>
                                            <input type="text" name="category" placeholder="Opsional" 
                                                class="w-full bg-slate-50 border-0 rounded-xl p-4 font-bold text-xs focus:ring-0 shadow-inner">
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4" x-data="{ loading: false }">
                                    <button type="submit" :disabled="loading" @click="if(document.getElementById('txForm').reportValidity()) { loading = true; showConfirmModal = true; loading = false; } else { return; }"
                                            class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-lg shadow-xl active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span x-show="!loading">Tinjau & Simpan</span>
                                        <div x-show="loading" class="flex items-center justify-center gap-2">
                                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>Memproses...</span>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Member Drawer -->
        <div x-show="showMemberDrawer" class="fixed inset-0 z-[120] overflow-hidden" style="display: none;">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="showMemberDrawer" x-transition.opacity @click="showMemberDrawer = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
                <div class="fixed inset-y-0 right-0 flex max-w-full pl-6 md:pl-10">
                    <div x-show="showMemberDrawer" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                         class="w-screen max-w-md">
                        <div class="flex h-full flex-col bg-white shadow-2xl rounded-l-[2rem] overflow-hidden" x-data="{ gender: 'male' }">
                            <div class="px-6 py-6 border-b border-slate-50 flex justify-between items-center text-center">
                                <h2 class="text-xl font-black text-slate-900">Tambah Anggota</h2>
                                <button @click="showMemberDrawer = false" class="p-2 bg-slate-50 rounded-xl text-slate-400"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>
                            </div>
                            <form action="{{ route('members.store') }}" method="POST" class="p-6 space-y-6">
                                @csrf
                                <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Nama Lengkap</label>
                                    <input type="text" name="name" required placeholder="Masukkan nama..." 
                                        class="w-full bg-slate-50 border-0 rounded-xl p-4 font-black text-slate-800 text-base focus:ring-2 focus:ring-slate-900">
                                </div>
                                
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Jenis Kelamin</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="gender" value="male" x-model="gender" class="sr-only">
                                            <div class="p-4 rounded-xl border-2 transition-all flex flex-col items-center gap-2"
                                                 :class="gender === 'male' ? 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-100' : 'bg-slate-50 border-slate-100 text-slate-400'">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                <span class="text-[10px] font-black uppercase">Laki-laki</span>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="gender" value="female" x-model="gender" class="sr-only">
                                            <div class="p-4 rounded-xl border-2 transition-all flex flex-col items-center gap-2"
                                                 :class="gender === 'female' ? 'bg-rose-500 border-rose-500 text-white shadow-lg shadow-rose-100' : 'bg-slate-50 border-slate-100 text-slate-400'">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 100 8 4 4 0 000-8zM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v3m-2-2h4" />
                                                </svg>
                                                <span class="text-[10px] font-black uppercase">Perempuan</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-lg shadow-xl active:scale-95 transition-transform">Simpan Anggota</button>
                                </div>
                            </form>
                        </div> <!-- flex h-full flex-col -->
                    </div> <!-- w-screen max-w-md -->
                </div> <!-- fixed inset-y-0 -->
            </div> <!-- absolute inset-0 -->
        </div> <!-- showMemberDrawer container -->

        <!-- Confirm Transaction Modal -->
        <div x-show="showConfirmModal" class="fixed inset-0 z-[200] flex items-center justify-center p-4" style="display: none;" x-transition>
            <div x-show="showConfirmModal" x-transition.opacity @click="showConfirmModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-show="showConfirmModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="relative w-full max-w-sm bg-white rounded-[2rem] shadow-3xl overflow-hidden p-8 text-center">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2">Simpan Transaksi?</h3>
                <p class="text-slate-400 text-xs font-bold mb-8">Pastikan nominal dan nama sudah sesuai sebelum menyimpan.</p>
                
                <div class="flex flex-col gap-3" x-data="{ submitting: false }">
                    <button type="button" @click="submitting = true; document.getElementById('txForm').submit()" :disabled="submitting"
                            class="w-full py-4 bg-emerald-500 text-white rounded-xl font-black shadow-lg shadow-emerald-100 active:scale-95 transition-all disabled:opacity-50 flex items-center justify-center gap-2">
                        <template x-if="submitting">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <span x-text="submitting ? 'Menyimpan...' : 'Ya, Simpan Sekarang'"></span>
                    </button>
                    <button type="button" @click="showConfirmModal = false" :disabled="submitting"
                            class="w-full py-3 text-slate-400 font-bold hover:text-slate-600 transition-colors">
                        Periksa Kembali
                    </button>
                </div>
            </div>
        </div>

        <!-- Confirm Next Period Modal -->
        <div x-show="showNextPeriodModal" class="fixed inset-0 z-[200] flex items-center justify-center p-4" style="display: none;" x-transition>
            <div x-show="showNextPeriodModal" x-transition.opacity @click="showNextPeriodModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-show="showNextPeriodModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="relative w-full max-w-sm bg-white rounded-[2rem] shadow-3xl overflow-hidden p-8 text-center">
                <div class="w-20 h-20 bg-emerald-500 text-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-emerald-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-2">Next Periode?</h3>
                <p class="text-slate-400 text-xs font-bold mb-8">
                    Ini akan menambah <span class="text-emerald-500 font-black">Periode Ke-{{ $classroom->current_period + 1 }}</span>.<br>
                    Tunggakan semua anggota akan otomatis bertambah <span class="text-rose-500 font-black">Rp{{ number_format($classroom->weekly_fee, 0, ',', '.') }}</span>.
                </p>
                
                <div class="flex flex-col gap-3" x-data="{ submitting: false }">
                    <form action="{{ route('classrooms.next-period', $classroom) }}" method="POST" @submit="submitting = true">
                        @csrf
                        <button type="submit" :disabled="submitting"
                                class="w-full py-5 bg-emerald-600 text-white rounded-2xl font-black text-lg shadow-xl shadow-emerald-100 active:scale-95 transition-all disabled:opacity-50 flex items-center justify-center gap-2">
                            <template x-if="submitting">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                            <span x-text="submitting ? 'Memproses...' : 'Ya, Lanjut Periode'"></span>
                        </button>
                    </form>
                    <button type="button" @click="showNextPeriodModal = false" :disabled="submitting"
                            class="w-full py-3 text-slate-400 font-bold hover:text-slate-600 transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>

        <!-- Edit Class Drawer -->
        <div x-show="showEditDrawer" class="fixed inset-0 z-[120] overflow-hidden" style="display: none;">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="showEditDrawer" x-transition.opacity @click="showEditDrawer = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
                <div class="fixed inset-y-0 right-0 flex max-w-full pl-6 md:pl-10">
                    <div x-show="showEditDrawer" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                         class="w-screen max-w-md">
                        <div class="flex h-full flex-col bg-white shadow-2xl rounded-l-[2rem] overflow-hidden">
                            <div class="px-6 py-6 border-b border-slate-50 flex justify-between items-center text-center">
                                <h1 class="text-xl font-black text-slate-900">Pengaturan Kelas</h1>
                                <button @click="showEditDrawer = false" class="p-2 bg-slate-50 rounded-xl text-slate-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <form action="{{ route('classrooms.update', $classroom) }}" method="POST" class="flex-1 p-8 space-y-6 overflow-y-auto custom-scrollbar">
                                @csrf
                                @method('PUT')
                                <div class="space-y-6">
                                    <div>
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1 mb-2 block">Nama Kelas</label>
                                        <input type="text" name="name" value="{{ old('name', $classroom->name) }}" required 
                                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-black text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all shadow-inner">
                                    </div>

                                    <div>
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1 mb-2 block">Deskripsi</label>
                                        <textarea name="description" rows="3" required
                                            class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all shadow-inner resize-none">{{ old('description', $classroom->description) }}</textarea>
                                    </div>

                                    <div class="p-6 bg-emerald-50 rounded-[2rem] border border-emerald-200">
                                        <label class="text-[10px] font-black text-emerald-600 uppercase tracking-widest pl-1 mb-4 block text-center">Pengaturan Pembayaran</label>
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-[9px] font-black text-emerald-400 uppercase tracking-widest pl-1 mb-2 block">Nominal Uang Kas</label>
                                                <div class="relative">
                                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400">Rp</span>
                                                    <input type="number" name="weekly_fee" value="{{ old('weekly_fee', (float)$classroom->weekly_fee) }}" required
                                                        class="w-full bg-white border-emerald-100 border rounded-xl py-3 pl-10 pr-4 text-sm font-black text-slate-700 focus:ring-1 focus:ring-emerald-500 transition-all">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="text-[9px] font-black text-emerald-400 uppercase tracking-widest pl-1 mb-2 block">Siklus Pembayaran (Hari)</label>
                                                <input type="number" name="billing_period_days" value="{{ old('billing_period_days', (float)$classroom->billing_period_days) }}" required
                                                    class="w-full bg-white border-emerald-100 border rounded-xl py-3 px-4 text-xs font-black text-emerald-700 focus:ring-emerald-500">
                                                <p class="text-[8px] text-emerald-400 mt-2 italic">*Hanya untuk estimasi tanggal di riwayat</p>
                                            </div>

                                            <input type="hidden" name="billing_at_time" value="00:00">
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 p-4 bg-white/50 rounded-2xl border border-dashed border-emerald-200 text-center">
                                        <p class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider">Status Saat Ini</p>
                                        <p class="text-sm font-black text-emerald-700 mt-1">Periode Ke-{{ $classroom->current_period }}</p>
                                    </div>
                                    <div class="mt-6">
                                        <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-sm shadow-lg shadow-emerald-100 active:scale-95 transition-all">Simpan Periode</button>
                                    </div>
                                    </div>
                                </div>

                                <div class="pt-4 flex flex-col gap-3">
                                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-lg shadow-xl active:scale-95 transition-all">Simpan Perubahan</button>
                                    
                                    <!-- Delete Button -->
                                    <button type="button" @click="if(confirm('Apakah Anda yakin ingin menghapus kelas ini? Data yang dihapus tidak dapat dikembalikan.')) { document.getElementById('delete-class-form').submit(); }" 
                                            class="w-full py-4 text-rose-500 font-bold text-xs hover:bg-rose-50 rounded-2xl transition-colors">
                                        Hapus Kelas Ini
                                    </button>
                                </div>
                            </form>
                            <form id="delete-class-form" action="{{ route('classrooms.destroy', $classroom) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- min-h-screen root -->

    @push('styles')
    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .shadow-bold { box-shadow: 0 10px 20px -10px rgba(0, 0, 0, 0.1); }
        .shadow-3xl { box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.1); }
    </style>
    @endpush
</x-app-layout>



