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
        txType: 'income',
        activeMember: null,
        memberSearch: '',
        genderFilter: 'all',
        statusFilter: 'all',
        currentPage: 1,
        perPage: 10,
        members: @js($membersData),
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
    }" x-on:keydown.escape="showDrawer = false; showEditDrawer = false; showMemberDrawer = false; showDetailModal = false; showConfirmModal = false; showNextPeriodModal = false;">
        
        <!-- Main Content -->
        <div class="py-6 md:py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Header Section -->
                <div class="flex items-center justify-between gap-4 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-slate-900 rounded-2xl md:rounded-[1.5rem] flex items-center justify-center text-white shadow-xl shadow-slate-200 shrink-0">
                            <span class="text-xl md:text-3xl font-black">{{ strtoupper(substr($classroom->name, 0, 1)) }}</span>
                        </div>
                        <div class="min-w-0">
                            <h1 class="text-xl md:text-3xl font-black text-slate-800 tracking-tight leading-none truncate">{{ $classroom->name }}</h1>
                            <div class="space-y-1 mt-2 md:mt-3">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded-lg text-[8px] md:text-[10px] font-black uppercase tracking-widest">
                                        {{ strtoupper(\Carbon\Carbon::now()->translatedFormat('l, d F Y')) }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[8px] md:text-[10px] font-black uppercase tracking-widest border border-emerald-100 flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        PERIODE {{ $classroom->current_period }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 md:gap-3 shrink-0">
                        <!-- Next Period Action -->
                        <button @click="showNextPeriodModal = true" class="flex items-center justify-center gap-2.5 px-4 h-10 md:h-14 md:px-6 bg-emerald-600 text-white rounded-2xl shadow-lg shadow-emerald-100 hover:bg-emerald-700 active:scale-95 transition-all group overflow-hidden relative">
                            <svg class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                            <span class="hidden md:inline font-black text-[11px] uppercase tracking-widest">Lanjut Periode</span>
                        </button>

                        <!-- Add Transaction Action -->
                        <button @click="showDrawer = true" class="flex items-center justify-center gap-2.5 px-3 h-10 md:h-14 md:px-6 bg-slate-900 text-white rounded-2xl shadow-xl shadow-slate-200 hover:bg-slate-800 active:scale-95 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                            <span class="hidden md:inline font-black text-[11px] uppercase tracking-widest">Transaksi</span>
                        </button>

                        <!-- Menu Action -->
                        <div x-data="{ menuOpen: false }" class="relative">
                            <button @click="menuOpen = !menuOpen" @click.away="menuOpen = false" class="w-10 h-10 md:w-14 md:h-14 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 12c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                            <div x-show="menuOpen" x-transition.origin.top.right class="absolute right-0 mt-3 w-48 bg-white border border-slate-100 rounded-2xl shadow-2xl py-2 z-50" style="display: none;">
                                <button @click="showMemberDrawer = true; menuOpen = false" class="w-full text-left px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Tambah Anggota</button>
                                <button @click="showEditDrawer = true; menuOpen = false" class="w-full text-left px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">Pengaturan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid Section -->
                <div class="mb-10 space-y-4">
                    @php
                        $income = $allTransactions->where('type', 'income')->sum('amount');
                        $expense = $allTransactions->where('type', 'expense')->sum('amount');
                        $balance = $income - $expense;
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Saldo Card -->
                        <div class="md:col-span-2 relative h-40 md:h-auto rounded-[2rem] overflow-hidden shadow-2xl shadow-emerald-100/50 flex flex-col justify-center items-center text-center p-8">
                            <img src="{{ asset('images/banner-total-balance.png') }}" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/90 to-emerald-500/80"></div>
                            <div class="relative z-10">
                                <p class="text-white/70 text-[10px] md:text-xs font-black uppercase tracking-[0.3em] mb-2">Saldo Tersedia</p>
                                <h2 class="text-3xl md:text-5xl font-black text-white tracking-tighter tabular-nums drop-shadow-xl">Rp{{ number_format($balance, 0, ',', '.') }}</h2>
                            </div>
                        </div>

                        <!-- In/Out Cards -->
                        <div class="grid grid-cols-2 md:grid-cols-1 gap-3 md:gap-4 h-full">
                            <div class="bg-white rounded-[2rem] p-4 md:p-6 border border-slate-100 shadow-sm flex items-center md:justify-center gap-4 group transition-all hover:border-emerald-100">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <div>
                                    <p class="text-[8px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Masuk</p>
                                    <h3 class="text-sm md:text-xl font-black text-slate-800">Rp{{ number_format($income, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                            <div class="bg-white rounded-[2rem] p-4 md:p-6 border border-slate-100 shadow-sm flex items-center md:justify-center gap-4 group transition-all hover:border-rose-100">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"/></svg>
                                </div>
                                <div>
                                    <p class="text-[8px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Keluar</p>
                                    <h3 class="text-sm md:text-xl font-black text-slate-800">Rp{{ number_format($expense, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Member Count Card -->
                    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm flex items-center md:justify-center gap-4 group hover:border-emerald-100 transition-all">
                        <div class="w-10 h-10 md:w-14 md:h-14 bg-slate-50 text-slate-300 rounded-2xl group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-colors flex items-center justify-center shrink-0 overflow-hidden relative">
                             <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Anggota Terdaftar</p>
                            <h3 class="text-sm md:text-2xl font-black text-slate-800">{{ $classroom->members->count() }} Orang Anggota</h3>
                        </div>
                    </div>
                </div>

                <!-- Activity Header -->
                <div class="flex items-center justify-between mb-4 px-1">
                    <h3 class="text-[10px] md:text-sm font-black text-slate-400 uppercase tracking-widest">Aktivitas Terbaru</h3>
                    <a href="{{ route('classrooms.history', $classroom) }}" class="flex items-center gap-1.5 text-slate-400 hover:text-slate-900 transition-colors group">
                        <span class="text-[9px] md:text-[11px] font-black uppercase">Lihat Riwayat</span>
                        <svg class="w-3 h-3 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <!-- Activity List -->
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-2xl shadow-slate-200/40 overflow-hidden mb-12">
                    <div class="divide-y divide-slate-50">
                        @forelse($transactions as $transaction)
                            <div class="px-5 py-4 md:px-10 md:py-6 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                                <div class="flex items-center gap-4 flex-1 min-w-0">
                                    <div class="w-10 h-10 md:w-14 md:h-14 rounded-2xl shrink-0 flex items-center justify-center text-xs md:text-xl shadow-sm {{ $transaction->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                        @if($transaction->type === 'income')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"/></svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-black text-slate-800 text-sm md:text-lg tabular-nums truncate">
                                            {{ $transaction->name === 'General' || $transaction->name === 'Umum' ? $transaction->description : $transaction->name }}
                                        </h4>
                                        <div class="flex items-center gap-2 md:gap-3 mt-1">
                                            <span class="text-slate-400 text-[10px] md:text-xs font-bold">{{ \Carbon\Carbon::parse($transaction->date)->format('d M, H:i') }}</span>
                                            <span class="w-0.5 h-0.5 bg-slate-200 rounded-full"></span>
                                            <span class="text-emerald-500/80 text-[10px] md:text-xs font-black">{{ $transaction->member ? $transaction->member->name : 'Kas Utama' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="text-sm md:text-xl font-black {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-slate-900' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center">
                                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada aktivitas</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Member Section -->
                <div id="members-section" class="mb-8">
                    <!-- Member Search & Filters -->
                    <div class="flex flex-col md:flex-row gap-4 mb-8">
                        <div class="relative flex-1">
                            <input type="text" x-model="memberSearch" @input="currentPage = 1" placeholder="Cari nama anggota..." 
                                class="w-full bg-white border border-slate-100 rounded-2xl py-4 pl-12 pr-4 text-xs md:text-sm font-bold text-slate-600 focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all shadow-sm">
                            <svg class="w-5 h-5 text-slate-300 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <div class="flex gap-3">
                             <select x-model="statusFilter" @change="currentPage = 1" class="bg-white border border-slate-100 rounded-2xl px-5 py-4 text-[11px] font-black uppercase tracking-widest text-slate-500 appearance-none focus:ring-2 focus:ring-slate-900 focus:border-transparent shadow-sm cursor-pointer min-w-[140px]">
                                <option value="all">Status</option>
                                <option value="paid">Lunas</option>
                                <option value="unpaid">Nunggak</option>
                            </select>
                            <select x-model="genderFilter" @change="currentPage = 1" class="bg-white border border-slate-100 rounded-2xl px-5 py-4 text-[11px] font-black uppercase tracking-widest text-slate-500 appearance-none focus:ring-2 focus:ring-slate-900 focus:border-transparent shadow-sm cursor-pointer min-w-[140px]">
                                <option value="all">Kelamin</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Member Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                        <template x-for="member in paginatedMembers" :key="member.id">
                            <div @click="activeMember = member.allData; showDetailModal = true" class="group bg-white rounded-[2rem] p-4 md:p-6 border border-slate-50 shadow-lg shadow-slate-100/50 active:scale-95 transition-all cursor-pointer relative overflow-hidden flex flex-col justify-between min-h-[140px] md:min-h-[190px]">
                                <template x-if="member.isUnpaid">
                                    <div class="absolute top-0 right-0">
                                        <div class="bg-rose-500 text-white text-[7px] md:text-[9px] font-black px-2.5 py-1 rounded-bl-xl uppercase tracking-tighter">Nunggak</div>
                                    </div>
                                </template>
                                <template x-if="!member.isUnpaid">
                                    <div class="absolute top-3 right-3 w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-lg">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </template>

                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-10 h-10 md:w-14 md:h-14 rounded-2xl flex items-center justify-center transition-all bg-slate-50 group-hover:scale-110" :class="member.gender === 'female' ? 'text-rose-400 group-hover:bg-rose-500 group-hover:text-white' : 'text-blue-400 group-hover:bg-blue-500 group-hover:text-white'">
                                        <template x-if="member.gender === 'female'">
                                            <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 100 8 4 4 0 000-8zM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v3m-2-2h4"/></svg>
                                        </template>
                                        <template x-if="member.gender !== 'female'">
                                            <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </template>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-black text-slate-800 text-xs md:text-lg leading-tight truncate mb-1" x-text="member.name"></h4>
                                    <p class="text-[8px] md:text-[10px] text-slate-400 font-bold uppercase tracking-tight" x-text="member.lastTxdiff"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Pagination -->
                    <div x-show="totalPages > 1" class="mt-10 flex items-center justify-center gap-2 md:gap-3">
                        <button @click="currentPage--; window.scrollTo({top: document.getElementById('members-section').offsetTop - 100, behavior: 'smooth'})" :disabled="currentPage === 1" class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 disabled:opacity-20 hover:text-emerald-600 transition-all shadow-sm active:scale-95">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <div class="px-5 h-10 md:h-12 bg-white border border-slate-100 rounded-xl md:rounded-2xl flex items-center justify-center shadow-sm">
                            <span class="text-[10px] md:text-sm font-black text-emerald-600" x-text="currentPage"></span>
                            <span class="text-[8px] md:text-[10px] font-bold text-slate-300 mx-2">/</span>
                            <span class="text-[10px] md:text-sm font-black text-slate-800" x-text="totalPages"></span>
                        </div>
                        <button @click="currentPage++; window.scrollTo({top: document.getElementById('members-section').offsetTop - 100, behavior: 'smooth'})" :disabled="currentPage === totalPages" class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 disabled:opacity-20 hover:text-emerald-600 transition-all shadow-sm active:scale-95">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Transaction Modal -->
        <div x-show="showDrawer" class="fixed inset-0 z-[120] flex items-end md:items-center justify-center p-4 md:p-6" style="display: none;">
            <div x-show="showDrawer" x-transition.opacity @@click="showDrawer = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-show="showDrawer" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full md:translate-y-0 md:scale-95" x-transition:enter-end="opacity-100 translate-y-0 md:scale-100" class="relative w-full max-w-md bg-white shadow-3xl rounded-t-[2rem] md:rounded-[2rem] overflow-hidden flex flex-col max-h-[90vh]">
                <div class="px-6 py-6 md:px-10 md:pt-10 md:pb-6 border-b border-slate-50 flex justify-between items-center shrink-0">
                    <h1 class="text-xl md:text-2xl font-black text-slate-900">Tambah Transaksi</h1>
                    <button @click="showDrawer = false" class="p-2 md:p-2.5 bg-slate-50 rounded-xl text-slate-400 hover:text-rose-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form id="txForm" action="{{ route('transactions.store') }}" method="POST" @submit.prevent="showConfirmModal = true" class="flex-1 p-6 md:p-10 space-y-6 md:space-y-8 overflow-y-auto custom-scrollbar">
                    @csrf
                    <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                    <input type="hidden" name="member_id" x-model="selectedMember">
                    <div class="space-y-6">
                        <div class="relative" x-data="{ memberListOpen: false }">
                            <label class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">Pilih Anggota / Kas</label>
                            <div @@click="memberListOpen = !memberListOpen" class="w-full p-4 md:p-5 bg-slate-50 rounded-2xl border border-slate-50 flex items-center justify-between cursor-pointer group hover:bg-slate-100 transition-all">
                                <span class="font-black text-slate-800 text-sm md:text-base tabular-nums" x-text="memberName || 'Cari nama di sini...'"></span>
                                <svg class="w-4 h-4 text-slate-300 transition-transform" :class="memberListOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <input type="hidden" name="name" x-model="memberName">
                            <div x-show="memberListOpen" @@click.away="memberListOpen = false" class="absolute z-20 mt-2 w-full bg-white border border-slate-100 rounded-3xl shadow-3xl p-3" style="display: none;">
                                <input type="text" x-model="searchMember" placeholder="Ketik nama di sini..." class="w-full rounded-2xl border-none bg-slate-50 mb-3 focus:ring-2 focus:ring-emerald-500 text-xs p-4 font-bold shadow-inner">
                                <div class="max-h-52 overflow-y-auto custom-scrollbar space-y-1 pr-1">
                                    <div @@click="selectedMember = ''; memberName = 'Umum'; memberListOpen = false" class="p-3.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-2xl cursor-pointer flex items-center justify-between transition-all">
                                        <span class="font-black text-[10px] uppercase tracking-widest">Kas Utama (Umum)</span>
                                        <svg class="w-5 h-5 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <template x-for="m in members.filter(item => item.name.toLowerCase().includes(searchMember.toLowerCase()))" :key="m.id">
                                        <div @@click="selectedMember = m.id; memberName = m.name; memberListOpen = false" class="p-3.5 hover:bg-slate-50 rounded-2xl cursor-pointer flex items-center justify-between transition-all">
                                            <span class="font-black text-slate-700 text-xs md:text-sm" x-text="m.name"></span>
                                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest" x-text="m.gender === 'male' ? 'L' : 'P'"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 block px-1">Nominal</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-sm font-black text-slate-400">Rp</span>
                                    <input type="number" name="amount" required x-model="txAmount" class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-12 pr-5 font-black text-lg text-slate-800 focus:ring-2 focus:ring-slate-900 transition-all shadow-inner tabular-nums">
                                </div>
                            </div>
                            <div>
                                <label class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 block px-1">Tipe</label>
                                <select name="type" x-model="txType" class="w-full border-none rounded-2xl font-black text-[10px] md:text-xs p-4 py-[1.125rem] focus:ring-0 transition-all uppercase tracking-widest shadow-inner cursor-pointer" :class="txType === 'expense' ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600'">
                                    <option value="income">Pemasukan (+)</option>
                                    <option value="expense">Pengeluaran (-)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 block px-1">Keterangan / Pesan</label>
                            <input type="text" name="description" x-model="txDescription" placeholder="Contoh: Bayar kas, beli buku..." class="w-full bg-slate-50 border-none rounded-2xl p-4 md:p-5 font-bold text-xs md:text-sm text-slate-700 focus:ring-2 focus:ring-slate-900 transition-all shadow-inner">
                        </div>

                        <div>
                            <label class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 block px-1">Waktu Transaksi</label>
                            <input type="datetime-local" name="date" required value="{{ date('Y-m-d\TH:i') }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 md:p-5 font-black text-[10px] md:text-xs text-slate-700 focus:ring-2 focus:ring-slate-900 transition-all shadow-inner cursor-pointer">
                        </div>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl md:rounded-3xl font-black text-base md:text-lg shadow-xl shadow-slate-200 active:scale-95 transition-all">Lanjutkan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Confirm Transaction Modal -->
        <div x-show="showConfirmModal" class="fixed inset-0 z-[200] flex items-center justify-center p-6" style="display: none;" x-transition>
            <div x-show="showConfirmModal" x-transition.opacity @click="showConfirmModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            <div x-show="showConfirmModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative w-full max-w-sm bg-white rounded-[2rem] shadow-3xl overflow-hidden p-8 md:p-10 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-emerald-500 text-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-emerald-100">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-xl md:text-2xl font-black text-slate-900 mb-2">Konfirmasi Kas?</h3>
                <p class="text-slate-400 text-xs md:text-sm font-bold mb-10 px-4">Nominal <span class="text-emerald-500" x-text="'Rp' + parseInt(txAmount || 0).toLocaleString('id-ID')"></span> akan dicatat ke saldo.</p>
                <div class="flex flex-col gap-3" x-data="{ loading: false }">
                    <button type="button" @click="loading = true; document.getElementById('txForm').submit()" :disabled="loading" class="w-full py-4 md:py-5 bg-emerald-600 text-white rounded-2xl md:rounded-[1.5rem] font-black text-sm md:text-base shadow-xl shadow-emerald-100 active:scale-95 transition-all disabled:opacity-50 flex items-center justify-center gap-3">
                        <template x-if="loading"><svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></template>
                        <span x-text="loading ? 'Memproses...' : 'Ya, Masukkan Kas'"></span>
                    </button>
                    <button type="button" @click="showConfirmModal = false" :disabled="loading" class="w-full py-3 text-slate-400 font-bold text-xs uppercase tracking-widest hover:text-slate-600 transition-colors">Batal</button>
                </div>
            </div>
        </div>

        <!-- Confirm Next Period Modal -->
        <div x-show="showNextPeriodModal" class="fixed inset-0 z-[200] flex items-center justify-center p-6" style="display: none;" x-transition>
            <div x-show="showNextPeriodModal" x-transition.opacity @click="showNextPeriodModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            <div x-show="showNextPeriodModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative w-full max-w-sm bg-white rounded-[2rem] shadow-3xl overflow-hidden p-8 md:p-12 text-center">
                <div class="w-20 h-20 bg-emerald-500 text-white rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-xl shadow-emerald-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-3">Lanjut Periode?</h3>
                <p class="text-slate-400 text-xs md:text-sm font-bold mb-10">Ini akan mengaktifkan <span class="text-emerald-500 font-black tracking-tight">Periode Ke-{{ $classroom->current_period + 1 }}</span>.<br>Tunggakan otomatis ditambahkan.</p>
                <form action="{{ route('classrooms.next-period', $classroom) }}" method="POST" x-data="{ loading: false }" @submit="loading = true" class="flex flex-col gap-3">
                    @csrf
                    <button type="submit" :disabled="loading" class="w-full py-5 bg-emerald-600 text-white rounded-2xl md:rounded-[1.5rem] font-black text-base shadow-xl shadow-emerald-100 active:scale-95 transition-all disabled:opacity-50 flex items-center justify-center gap-3">
                        <template x-if="loading"><svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></template>
                        <span x-text="loading ? 'Sedang Memproses...' : 'Ya, Mulai Sekarang'"></span>
                    </button>
                    <button type="button" @click="showNextPeriodModal = false" :disabled="loading" class="w-full py-3 text-slate-400 font-bold text-xs uppercase tracking-widest">Tunda</button>
                </form>
            </div>
        </div>

        <!-- Add Member Drawer -->
        <div x-show="showMemberDrawer" class="fixed inset-0 z-[120] overflow-hidden" style="display: none;">
            <div x-show="showMemberDrawer" x-transition.opacity @@click="showMemberDrawer = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
            <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
                <div x-show="showMemberDrawer" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" class="w-screen max-w-md">
                    <div class="h-full flex flex-col bg-white shadow-3xl rounded-l-[2rem] overflow-hidden" x-data="{ gender: 'male' }">
                        <div class="px-6 py-6 md:px-10 md:pt-12 md:pb-6 border-b border-slate-50 flex justify-between items-center">
                            <h2 class="text-xl md:text-2xl font-black text-slate-900">Tambah Anggota</h2>
                            <button @@click="showMemberDrawer = false" class="p-2 md:p-2.5 bg-slate-50 rounded-xl text-slate-400 hover:text-rose-500 transition-colors"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        <form action="{{ route('members.store') }}" method="POST" class="flex-1 p-6 md:p-10 space-y-8 overflow-y-auto custom-scrollbar">
                            @csrf
                            <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-3 block px-1">Nama Lengkap Siswa</label>
                                    <input type="text" name="name" required placeholder="Masukkan nama..." class="w-full bg-slate-50 border-none rounded-2xl p-4 md:p-5 font-black text-slate-800 text-sm md:text-base focus:ring-2 focus:ring-slate-900 transition-all shadow-inner">
                                </div>
                                <div x-data="{ selGender: 'male' }">
                                    <label class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-4 block px-1">Jenis Kelamin</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="gender" value="male" x-model="selGender" class="sr-only">
                                            <div class="p-5 rounded-2xl md:rounded-3xl border-2 transition-all flex flex-col items-center gap-3 shadow-sm" :class="selGender === 'male' ? 'bg-blue-600 border-blue-600 text-white shadow-xl shadow-blue-100' : 'bg-slate-50 border-slate-50 text-slate-400 group-hover:bg-slate-100'">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                <span class="text-[10px] font-black uppercase tracking-widest">Laki-laki</span>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="gender" value="female" x-model="selGender" class="sr-only">
                                            <div class="p-5 rounded-2xl md:rounded-3xl border-2 transition-all flex flex-col items-center gap-3 shadow-sm" :class="selGender === 'female' ? 'bg-rose-500 border-rose-500 text-white shadow-xl shadow-rose-100' : 'bg-slate-50 border-slate-50 text-slate-400 group-hover:bg-slate-100'">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 100 8 4 4 0 000-8zM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v3m-2-2h4"/></svg>
                                                <span class="text-[10px] font-black uppercase tracking-widest">Perempuan</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-6">
                                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-3xl font-black text-lg shadow-2xl active:scale-95 transition-all">Simpan Anggota</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Class Drawer -->
        <div x-show="showEditDrawer" class="fixed inset-0 z-[120] overflow-hidden" style="display: none;">
            <div x-show="showEditDrawer" x-transition.opacity @@click="showEditDrawer = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
            <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
                <div x-show="showEditDrawer" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" class="w-screen max-w-md">
                    <div class="h-full flex flex-col bg-white shadow-3xl rounded-l-[2rem] overflow-hidden">
                        <div class="px-6 py-6 md:px-10 md:pt-12 md:pb-6 border-b border-slate-50 flex justify-between items-center text-center">
                            <h2 class="text-xl md:text-2xl font-black text-slate-900">Pengaturan Ruang</h2>
                            <button @@click="showEditDrawer = false" class="p-2 md:p-2.5 bg-slate-50 rounded-xl text-slate-400 hover:text-rose-500 transition-colors"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        <form action="{{ route('classrooms.update', $classroom) }}" method="POST" class="flex-1 p-6 md:p-10 space-y-8 overflow-y-auto custom-scrollbar">
                            @csrf
                            @method('PUT')
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest pl-1 mb-2 block">Nama Ruang</label>
                                    <input type="text" name="name" value="{{ $classroom->name }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-black text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all shadow-inner">
                                </div>
                                <div>
                                    <label class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest pl-1 mb-2 block">Deskripsi</label>
                                    <textarea name="description" rows="3" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all shadow-inner resize-none">{{ $classroom->description }}</textarea>
                                </div>
                                <div class="p-6 bg-emerald-50 rounded-[2rem] border border-emerald-100 shadow-sm">
                                    <label class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-4 block text-center">Biaya Kas Per Periode</label>
                                    <div class="relative mb-6">
                                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-xs font-black text-emerald-400">Rp</span>
                                        <input type="number" name="weekly_fee" value="{{ (float)$classroom->weekly_fee }}" required class="w-full bg-white border-emerald-100 border-2 rounded-2xl py-4 pl-12 pr-6 text-base font-black text-emerald-600 focus:ring-2 focus:ring-emerald-500 transition-all tabular-nums">
                                    </div>
                                    <input type="hidden" name="billing_period_days" value="{{ $classroom->billing_period_days }}">
                                    <input type="hidden" name="billing_at_time" value="00:00">
                                    <div class="bg-white/60 rounded-2xl p-4 text-center border border-emerald-100">
                                        <p class="text-[9px] text-emerald-400 font-bold uppercase tracking-widest mb-1">Status Sesi</p>
                                        <p class="text-xs font-black text-emerald-700">Aktif di Periode Ke-{{ $classroom->current_period }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-6 space-y-4">
                                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-3xl font-black text-lg shadow-2xl active:scale-95 transition-all">Simpan Perubahan</button>
                                <button type="button" @click="if(confirm('Hapus ruang ini selamanya?')) document.getElementById('delete-form').submit()" class="w-full py-4 text-rose-500 font-bold text-[10px] uppercase tracking-widest hover:bg-rose-50 rounded-2xl transition-colors">Hapus Ruang Ini</button>
                            </div>
                        </form>
                        <form id="delete-form" action="{{ route('classrooms.destroy', $classroom) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Member Detail Modal -->
        <div x-show="showDetailModal" class="fixed inset-0 z-[110] flex items-end md:items-center justify-center p-0 md:p-6" style="display: none;">
            <div x-show="showDetailModal" x-transition.opacity @@click="showDetailModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-show="showDetailModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full md:translate-y-0 md:scale-95" x-transition:enter-end="opacity-100 translate-y-0 md:scale-100" class="relative w-full max-w-lg bg-white rounded-t-[2rem] md:rounded-[2rem] shadow-3xl overflow-hidden flex flex-col max-h-[90vh]">
                <div class="px-6 py-6 md:px-10 md:pt-10 md:pb-6 border-b border-slate-50 flex items-center justify-between shrink-0">
                    <template x-if="activeMember">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 md:w-16 md:h-16 rounded-2xl flex items-center justify-center shadow-lg" :class="activeMember.gender === 'female' ? 'bg-rose-500 text-white shadow-rose-100' : 'bg-blue-500 text-white shadow-blue-100'">
                                <template x-if="activeMember.gender === 'female'"><svg class="w-6 h-6 md:w-9 md:h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 100 8 4 4 0 000-8zM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v3m-2-2h4"/></svg></template>
                                <template x-if="activeMember.gender !== 'female'"><svg class="w-6 h-6 md:w-9 md:h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></template>
                            </div>
                            <div>
                                <h3 class="text-lg md:text-xl font-black text-slate-800 leading-tight" x-text="activeMember.name"></h3>
                                <p class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest mt-0.5" x-text="activeMember.gender === 'male' ? 'Laki-laki' : 'Perempuan'"></p>
                            </div>
                        </div>
                    </template>
                    <button @@click="showDetailModal = false" class="p-2 md:p-2.5 bg-slate-50 rounded-xl text-slate-400 hover:text-rose-500 transition-colors"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="flex-1 overflow-y-auto p-6 md:p-10 custom-scrollbar">
                    <template x-if="activeMember">
                        <div class="space-y-10">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-emerald-50 rounded-3xl p-5 border border-emerald-100">
                                    <p class="text-emerald-500 text-[8px] md:text-[10px] font-black uppercase tracking-widest mb-1">Sudah Bayar</p>
                                    <p class="text-sm md:text-xl font-black text-emerald-700 tabular-nums">Rp<span x-text="activeMember.income.toLocaleString('id-ID')"></span></p>
                                </div>
                                <div class="bg-slate-50 rounded-3xl p-5 border border-slate-100">
                                    <p class="text-slate-400 text-[8px] md:text-[10px] font-black uppercase tracking-widest mb-1">Riwayat</p>
                                    <p class="text-sm md:text-xl font-black text-slate-800" x-text="activeMember.transactions.length + ' Kali'"></p>
                                </div>
                            </div>
                            <template x-if="activeMember.isUnpaid">
                                <div class="bg-rose-50 rounded-[2rem] p-6 md:p-8 border border-rose-100 shadow-xl shadow-rose-100/50">
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-12 h-12 bg-rose-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-100"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                        <div>
                                            <h4 class="text-sm md:text-base font-black text-rose-900 leading-tight">Total Tunggakan</h4>
                                            <p class="text-lg md:text-2xl font-black text-rose-600 tabular-nums" x-text="'-Rp' + Math.abs(activeMember.debt).toLocaleString('id-ID')"></p>
                                        </div>
                                    </div>
                                    <div class="space-y-3 max-h-64 overflow-y-auto custom-scrollbar pr-2">
                                        <template x-for="u in activeMember.unpaidList" :key="u.index">
                                            <div class="flex items-center justify-between p-4 bg-white/70 rounded-2xl border border-rose-100/50">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center text-[10px] font-black" :class="u.is_past ? 'bg-rose-500 text-white' : 'bg-amber-400 text-white'"><span x-text="u.index"></span></div>
                                                    <div class="flex flex-col">
                                                        <span class="font-black text-slate-700 text-[10px] md:text-sm" x-text="u.date"></span>
                                                        <span class="text-[8px] md:text-[9px] font-bold text-slate-400 uppercase tracking-tighter" x-text="'Periode ' + u.index"></span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2 md:gap-4">
                                                    <p class="font-black text-rose-600 text-[10px] md:text-sm tabular-nums" x-text="'Rp' + u.amount_due.toLocaleString('id-ID')"></p>
                                                    <button @@click="selectedMember = activeMember.id; memberName = activeMember.name; txAmount = u.amount_due; txDescription = 'Bayar Periode ' + u.index; txType = 'income'; showDetailModal = false; showDrawer = true" class="px-3 py-1.5 md:px-4 md:py-2 bg-emerald-500 text-white text-[9px] md:text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 active:scale-95 transition-all shadow-md shadow-emerald-100">Bayar</button>
                                                </div>
                                            </div>
                                        </template>

                                    </div>
                                    <div class="mt-8 pt-4">
                                        <button @@click="selectedMember = activeMember.id; memberName = activeMember.name; txAmount = Math.abs(activeMember.debt); txDescription = 'Lunas Tunggakan'; txType = 'income'; showDetailModal = false; showDrawer = true" class="w-full py-5 bg-emerald-600 text-white rounded-3xl font-black text-sm uppercase tracking-widest shadow-xl shadow-emerald-200 active:scale-95 transition-all">Bayar Semua Sekarang</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>

    </div> <!-- min-h-screen root -->

    @push('styles')
    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .shadow-3xl { box-shadow: 0 40px 80px -15px rgba(15, 23, 42, 0.08); }
    </style>
    @endpush
</x-app-layout>
