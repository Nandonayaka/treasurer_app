<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kasly - Solusi Kelola Uang Kas Modern</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            img {
                -webkit-user-drag: none;
                -khtml-user-drag: none;
                -moz-user-drag: none;
                -o-user-drag: none;
                user-drag: none;
                user-select: none;
            }
            .font-outfit {
                font-family: 'Outfit', sans-serif;
            }
            .glass {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
            .hero-gradient {
                background: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
            }
            .step-line {
                background: linear-gradient(90deg, #10B981 0%, #10B981 100%);
                height: 2px;
                position: absolute;
                top: 2.5rem;
                left: 10%;
                right: 10%;
                z-index: 0;
            }
            @media (max-width: 768px) {
                .step-line {
                    display: none;
                }
            }
        </style>
    </head>
    <body class="antialiased bg-white text-slate-900 overflow-x-hidden">
        <!-- Navbar -->
        <nav class="fixed top-0 left-0 right-0 z-50 glass">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain" draggable="false">
                </div>

                <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="#fitur" class="hover:text-emerald-600 transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="hover:text-emerald-600 transition-colors">Cara Kerja</a>
                    <a href="#preview" class="hover:text-emerald-600 transition-colors">Preview</a>
                    <a href="#testimoni" class="hover:text-emerald-600 transition-colors">Testimoni</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-slate-900 text-white rounded-full text-sm font-bold shadow-lg shadow-slate-200 hover:scale-105 transition-all active:scale-95">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-600">Log in</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-full text-sm font-bold shadow-lg shadow-emerald-200 hover:scale-105 transition-all active:scale-95">Mulai Sekarang</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative pt-40 pb-20 hero-gradient">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <!-- Badges -->
                <div class="flex flex-wrap justify-center gap-3 mb-10">
                    <span class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100 flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Tanpa Install Aplikasi
                    </span>
                    <span class="px-4 py-2 bg-slate-50 text-slate-600 rounded-full text-xs font-bold border border-slate-100 flex items-center gap-2">
                        <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v1a1 1 0 11-2 0v-1a1 1 0 112 0zM13.336 16.336a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 011.414-1.414l.707.707z" /></svg>
                        Cepat & Praktis
                    </span>
                    <span class="px-4 py-2 bg-slate-50 text-slate-600 rounded-full text-xs font-bold border border-slate-100">
                        Multi User
                    </span>
                </div>

                <h1 class="text-4xl md:text-7xl font-black tracking-tight text-slate-900 mb-6 leading-[1.1]">
                    Catat keuangan organisasi<br>
                    <span class="text-emerald-600">langsung dari smartphone.</span>
                </h1>
                
                <p class="max-w-2xl mx-auto text-lg md:text-xl text-slate-500 font-medium leading-relaxed mb-10">
                    Cara paling simpel mencatat pengeluaran dan pemasukan harian organisasi hanya melalui satu dashboard terintegrasi.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-5 bg-emerald-600 text-white rounded-2xl font-black text-lg shadow-2xl shadow-emerald-200 hover:bg-emerald-700 transition-all active:scale-95 group">
                        Mulai Catat uang
                        <svg class="w-5 h-5 inline-block ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </main>

        <!-- Cara Pakai Video Section -->
        <section id="cara-kerja" class="py-32 bg-slate-50/50 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-white to-transparent"></div>
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="text-center mb-16">
                    <h3 class="text-emerald-600 font-bold tracking-widest text-sm uppercase mb-4">Cara Pakai</h3>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight">Video Panduan Praktis</h2>
                </div>

                <div class="max-w-4xl mx-auto group">
                    <div class="relative pt-[56.25%] rounded-[2.5rem] overflow-hidden shadow-2xl shadow-emerald-900/10 border-8 border-white group-hover:scale-[1.01] transition-transform duration-700">
                        <iframe 
                            class="absolute inset-0 w-full h-full"
                            src="https://www.youtube.com/embed/0X5coeoru5o?autoplay=1&mute=1&loop=1&playlist=0X5coeoru5o&controls=0&modestbranding=1&rel=0" 
                            title="Panduan KasKelas" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen>
                        </iframe>
                    </div>
                    
                    <!-- Decorative elements around video -->
                    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="flex items-center gap-4 p-4 bg-white rounded-2xl shadow-sm">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold">1</div>
                            <p class="text-sm font-bold text-slate-600 uppercase tracking-widest">Tonton Panduan</p>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-white rounded-2xl shadow-sm">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold">2</div>
                            <p class="text-sm font-bold text-slate-600 uppercase tracking-widest">Pahami Sistem</p>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-white rounded-2xl shadow-sm">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold">3</div>
                            <p class="text-sm font-bold text-slate-600 uppercase tracking-widest">Mulai Kelola</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-white to-transparent"></div>
        </section>

        <!-- Preview Section -->
        <section id="preview" class="py-32">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <h3 class="text-emerald-600 font-bold tracking-widest text-sm uppercase mb-4 text-center">Preview</h3>
                    <h2 class="text-4xl font-black text-slate-900">Dashboard ringkas</h2>
                    <p class="text-slate-500 font-medium mt-4">Angka statistik beranimasi saat kamu scroll — gambaran nyata saldo dan arus kas.</p>
                </div>

                <!-- Dashboard Mockup -->
                <div class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-slate-100 overflow-hidden">
                    <div class="p-8 md:p-12">
                        <div class="flex items-center justify-between mb-10">
                            <div>
                                <h5 class="text-slate-400 font-bold uppercase text-[10px] tracking-widest mb-1">Ringkasan</h5>
                                <p class="text-slate-900 font-bold">Bulan ini</p>
                            </div>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-full text-[10px] font-black uppercase">Live</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Pemasukan</p>
                                <p class="text-2xl font-black text-emerald-600">Rp 5.240.000</p>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Pengeluaran</p>
                                <p class="text-2xl font-black text-pink-500">Rp 1.890.000</p>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Saldo</p>
                                <p class="text-2xl font-black text-slate-900">Rp 3.350.000</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Transaksi Terbaru</p>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-50 shadow-sm">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-pink-50 rounded-full flex items-center justify-center text-pink-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-sm">Keluar · Kopi</p>
                                            <p class="text-[10px] text-slate-400 font-bold">Hari ini</p>
                                        </div>
                                    </div>
                                    <p class="font-black text-pink-500">-15.000</p>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-50 shadow-sm">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-sm">Masuk · Gaji</p>
                                            <p class="text-[10px] text-slate-400 font-bold">Hari ini</p>
                                        </div>
                                    </div>
                                    <p class="font-black text-emerald-600">+500.000</p>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-50 shadow-sm">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-pink-50 rounded-full flex items-center justify-center text-pink-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-sm">Keluar · Makan siang</p>
                                            <p class="text-[10px] text-slate-400 font-bold">Kemarin</p>
                                        </div>
                                    </div>
                                    <p class="font-black text-pink-500">-25.000</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-20 bg-slate-900 text-white">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain brightness-0 invert" draggable="false">
                    </div>
                    <p class="text-slate-400 font-medium mb-8 max-w-sm">
                        Solusi terbaik untuk pengelolaan keuangan organisasi yang transparan, mudah, dan menyenangkan bagi bendahara dan anggota.
                    </p>
                </div>
                <div>
                    <h5 class="text-slate-100 font-bold mb-6">Tautan Cepat</h5>
                    <ul class="space-y-4 text-slate-400 font-medium text-sm">
                        <li><a href="#" class="hover:text-emerald-500 transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-emerald-500 transition-colors">Fitur</a></li>
                        <li><a href="#cara-kerja" class="hover:text-emerald-500 transition-colors">Cara Kerja</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-500 transition-colors">Masuk</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-slate-100 font-bold mb-6">Kontak</h5>
                    <ul class="space-y-4 text-slate-400 font-medium text-sm">
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            support@kasly.id
                        </li>
                    </ul>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-6 mt-20 pt-8 border-t border-slate-800 text-center text-slate-500 text-xs font-bold uppercase tracking-widest">
                &copy; {{ date('Y') }} Kasly. All rights reserved.
            </div>
        </footer>
    </body>
</html>
