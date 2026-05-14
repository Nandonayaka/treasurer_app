<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Selamat Datang - Treasurer App</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased bg-white overflow-hidden">
        <div class="h-screen flex flex-col">
            <!-- Top Logo Area -->
            <div class="flex-1 flex flex-col items-center justify-center p-4">
                <div class="w-48 h-48 md:w-64 md:h-64 flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
            </div>

            <!-- Bottom Welcome Sheet -->
            <div class="bg-emerald-500 rounded-t-[2rem] md:rounded-t-[4rem] px-6 py-8 md:px-16 md:py-16 shadow-[0_-15px_40px_-10px_rgba(16,185,129,0.2)]">
                <div class="max-w-md mx-auto">
                    <h2 class="text-2xl md:text-4xl font-black text-white tracking-tight mb-2">Welcome</h2>
                    <p class="text-emerald-50 font-bold text-[11px] md:text-base leading-relaxed opacity-90 mb-6">
                        Classroom financial tracking made easy and transparent.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-2.5">
                        <a href="{{ route('login') }}" class="flex-1 bg-slate-900 text-white text-center py-3.5 rounded-xl font-black text-sm md:text-base shadow-xl hover:bg-slate-800 transition-all active:scale-95">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="flex-1 bg-white text-emerald-600 text-center py-3.5 rounded-xl font-black text-sm md:text-base shadow-xl hover:bg-slate-50 transition-all active:scale-95">
                            Register
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>
