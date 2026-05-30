<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pejuang Sukses') }} - Siswa Portal</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .heading-font {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-[#f0f2f5] text-slate-800 min-h-screen flex flex-col h-full">

    <!-- Topbar Navigation -->
    <header class="h-16 bg-white border-b border-slate-200 sticky top-0 z-20 flex items-center justify-between px-8 shadow-sm">
        <!-- Logo Left -->
        <div class="flex items-center gap-2.5">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo Pejuang Sukses" class="h-9 w-9 object-contain rounded-xl">
            <div>
                <span class="heading-font text-sm font-extrabold text-[#1a3d6e] leading-tight block">Pejuang Sukses</span>
                <span class="text-[9px] text-[#1D9E75] font-bold uppercase tracking-wider block">Siswa Portal</span>
            </div>
        </div>

        <!-- Menu Navigation Center -->
        <nav class="hidden md:flex items-center gap-6">
            <a href="{{ route('dashboard') }}" 
               class="text-xs font-bold transition-all px-3 py-2 rounded-xl {{ request()->routeIs('dashboard') ? 'text-[#1D9E75] bg-[#e8f4f0]' : 'text-slate-500 hover:text-[#1a3d6e] hover:bg-slate-50' }}">
                <i class="fa-solid fa-chart-pie mr-1 text-[11px]"></i> Dashboard
            </a>
            <a href="{{ route('dashboard') }}#semua" 
               class="text-xs font-bold text-slate-500 hover:text-[#1a3d6e] transition-all px-3 py-2 rounded-xl hover:bg-slate-50">
                <i class="fa-solid fa-graduation-cap mr-1 text-[11px]"></i> Beasiswa
            </a>
            <a href="#" 
               class="text-xs font-bold text-slate-500 hover:text-[#1a3d6e] transition-all px-3 py-2 rounded-xl hover:bg-slate-50">
                <i class="fa-regular fa-circle-question mr-1 text-[11px]"></i> Bantuan
            </a>
        </nav>

        <!-- Right Side Icons & Avatar -->
        <div class="flex items-center gap-4">
            <!-- Notifications -->
            <button class="relative text-slate-400 hover:text-slate-600 cursor-pointer">
                <i class="fa-regular fa-bell text-lg"></i>
                <span class="absolute -top-0.5 -right-0.5 h-2 w-2 rounded-full bg-[#1D9E75]"></span>
            </button>

            <!-- Settings -->
            <button class="text-slate-400 hover:text-slate-600 cursor-pointer">
                <i class="fa-solid fa-gear text-lg"></i>
            </button>

            <!-- Profile Info & Logout -->
            <div class="flex items-center gap-2.5 border-l border-slate-200 pl-4">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-500 font-semibold mt-0.5">NISN: {{ Auth::user()->nisn ?? '-' }}</p>
                </div>
                
                <div class="relative group">
                    <button class="h-9 w-9 rounded-full bg-[#1a3d6e] flex items-center justify-center text-white font-bold text-sm border-2 border-white shadow-md cursor-pointer">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </button>
                    <!-- Dropdown for Logout -->
                    <div class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 p-2">
                        <div class="px-3 py-2 border-b border-slate-100 sm:hidden">
                            <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-500 font-semibold">NISN: {{ Auth::user()->nisn ?? '-' }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 px-3 hover:bg-rose-50 hover:text-rose-600 text-xs font-bold text-slate-500 rounded-lg transition-colors flex items-center gap-2 cursor-pointer">
                                <i class="fa-solid fa-right-from-bracket"></i> Keluar / Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Slot Content -->
    <main class="flex-1 max-w-7xl mx-auto px-6 sm:px-8 py-8 w-full">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-xs text-slate-500 font-semibold">&copy; 2026 Pejuang Sukses. All rights reserved.</p>
        <div class="flex gap-5 text-[11px] font-bold text-slate-400">
            <a href="#" class="hover:text-slate-600">Kebijakan Privasi</a>
            <span class="text-slate-200">|</span>
            <a href="#" class="hover:text-slate-600">Syarat & Ketentuan</a>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
