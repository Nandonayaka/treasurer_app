<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Treasurer') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
        @stack('styles')
    </head>
    <body class="antialiased text-slate-900 bg-slate-50">
        <!-- Global Notification Toast -->
        @php
            $success_message = session('success') ?? session('status');
            $message_map = [
                'profile-updated' => 'Profil berhasil diperbarui!',
                'password-updated' => 'Kata sandi berhasil diperbarui!',
                'verification-link-sent' => 'Link verifikasi telah dikirim!',
            ];
            if (is_string($success_message) && isset($message_map[$success_message])) {
                $success_message = $message_map[$success_message];
            }
        @endphp

        @if($success_message && is_string($success_message))
        <div x-data="{ 
                show: true, 
                message: '{{ $success_message }}',
                init() {
                    setTimeout(() => this.show = false, 4000);
                }
            }"
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="-translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-full opacity-0"
            class="fixed top-6 left-0 right-0 z-[500] flex justify-center px-4 pointer-events-none"
            x-cloak>
            <div class="bg-white/90 backdrop-blur-xl border border-emerald-100 px-6 py-4 rounded-[2rem] shadow-2xl shadow-emerald-200/50 flex items-center gap-4 max-w-md w-full pointer-events-auto border-b-4 border-emerald-500">
                <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-0.5">Berhasil!</p>
                    <p class="text-xs font-bold text-slate-700 leading-snug" x-text="message"></p>
                </div>
                <button @click="show = false" class="text-slate-300 hover:text-slate-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        @endif

        <div class="min-h-screen flex bg-slate-50">
            <!-- Left Sidebar (Desktop) -->
            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col min-w-0 min-h-screen">
                <!-- Desktop Navigation Bar -->
                @include('layouts.desktop-nav')

                <!-- Top Navigation (Mobile) -->
                @unless(request()->routeIs('profile.*'))
                    @include('layouts.navigation')
                @endunless

                <!-- Page Content -->
                <main class="flex-1 bg-white md:bg-slate-50 overflow-x-hidden">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
