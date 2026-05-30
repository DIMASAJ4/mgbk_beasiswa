<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MGBK Beasiswa') }} - Admin Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .heading-font { font-family: 'Outfit', sans-serif; }
        .sidebar-link { @apply flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-400 hover:bg-slate-800/60 hover:text-white transition-all duration-150; }
        .sidebar-link.active { @apply bg-slate-800/80 text-white border border-slate-700/50; }
        .glassmorphism { background: rgba(15,23,42,0.65); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.08); }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex h-full">

    {{-- Sidebar --}}
    <aside class="w-56 min-h-screen bg-slate-950 flex flex-col shrink-0 fixed top-0 left-0 h-full z-30">
        {{-- Sidebar Header --}}
        <div class="px-5 py-6 border-b border-slate-900">
            <div class="flex items-center gap-2.5 mb-1">
                <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <p class="text-xs font-extrabold text-white leading-tight">Admin Portal</p>
                    <p class="text-[10px] text-slate-500 font-medium">Management System</p>
                </div>
            </div>
        </div>

        {{-- Nav Items --}}
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie w-4"></i> Dashboard
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-university w-4"></i> Kampus Mitra
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-graduation-cap w-4"></i> Data Beasiswa
            </a>
            <a href="{{ route('admin.roles') }}" class="sidebar-link {{ request()->routeIs('admin.roles') ? 'active' : '' }}">
                <i class="fa-solid fa-users w-4"></i> Pengguna
            </a>
            <a href="{{ route('admin.laporan') }}" class="sidebar-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                <i class="fa-regular fa-file-lines w-4"></i> Laporan
            </a>
        </nav>

        {{-- Add Scholarship CTA --}}
        <div class="p-4">
            <button class="w-full py-3 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold flex items-center justify-center gap-2 transition-all cursor-pointer shadow-lg shadow-indigo-600/10">
                <i class="fa-solid fa-plus"></i> Tambah Beasiswa
            </button>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full py-2 px-4 rounded-xl text-xs font-semibold text-slate-500 hover:text-rose-400 flex items-center gap-2 transition-colors cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="ml-56 flex-1 flex flex-col min-h-screen bg-slate-50">
        {{-- Top Bar --}}
        <header class="h-16 bg-white border-b border-slate-100 sticky top-0 z-20 flex items-center justify-between px-8">
            <nav class="flex items-center gap-1 text-xs text-slate-400">
                <span>Portal</span>
                <i class="fa-solid fa-chevron-right text-[9px] mx-1"></i>
                <span class="text-slate-700 font-semibold">Dashboard</span>
            </nav>
            <div class="flex items-center gap-4">
                <button class="relative text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-regular fa-bell text-lg"></i>
                    <span class="absolute -top-1 -right-1 h-2 w-2 rounded-full bg-rose-500"></span>
                </button>
                <button class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-solid fa-gear text-lg"></i>
                </button>
                <div class="flex items-center gap-2.5 border-l border-slate-100 pl-4">
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-slate-400 font-medium">Administrator Utama</p>
                    </div>
                    <div class="h-9 w-9 rounded-full bg-indigo-500/10 border-2 border-indigo-500/20 flex items-center justify-center text-indigo-500 font-bold text-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-white border-t border-slate-100 py-6 px-8 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-slate-700">MGBK Indonesia</p>
                <p class="text-xs text-slate-400 mt-0.5">&copy; 2024 MGBK Indonesia. All rights reserved.</p>
            </div>
            <div class="flex gap-6 text-xs font-semibold text-slate-400">
                <a href="#" class="hover:text-slate-600">Privacy Policy</a>
                <a href="#" class="hover:text-slate-600">Terms of Service</a>
                <a href="#" class="hover:text-slate-600">Contact Support</a>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
