<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MGBK Beasiswa') }}</title>

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
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            transition: all 150ms ease;
        }
    </style>
</head>
<body class="bg-[#f0f2f5] text-slate-800 min-h-screen flex h-full">

    <!-- Sidebar -->
    <aside class="w-[220px] min-h-screen bg-white border-r border-slate-200 flex flex-col justify-between shrink-0 fixed top-0 left-0 h-full z-30">
        <div>
            <!-- Sidebar Brand Logo -->
            <div class="px-6 py-6 border-b border-slate-100 flex items-center gap-2.5">
                <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-[#1a3d6e] to-[#1D9E75] flex items-center justify-center text-white">
                    <i class="fa-solid fa-graduation-cap text-lg"></i>
                </div>
                <div>
                    <h1 class="heading-font text-sm font-extrabold text-[#1a3d6e] leading-tight">MGBK Beasiswa</h1>
                    <p class="text-[10px] text-[#1D9E75] font-bold tracking-wider uppercase">Portal Guru & Admin</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5">
                <a href="{{ route('dashboard') }}" 
                   class="sidebar-link {{ request()->routeIs('dashboard') || request()->routeIs('guru.dashboard') || request()->routeIs('admin.dashboard') ? 'bg-[#1D9E75] text-white shadow-md shadow-[#1D9E75]/10' : 'text-slate-500 hover:bg-[#e8f4f0] hover:text-[#1a3d6e]' }}">
                    <i class="fa-solid fa-chart-pie w-4 text-center"></i> Dashboard
                </a>

                @role('Admin')
                    <a href="{{ route('admin.kampus.index') }}" 
                       class="sidebar-link {{ request()->routeIs('admin.kampus.*') ? 'bg-[#1D9E75] text-white shadow-md shadow-[#1D9E75]/10' : 'text-slate-500 hover:bg-[#e8f4f0] hover:text-[#1a3d6e]' }}">
                        <i class="fa-solid fa-university w-4 text-center"></i> Kampus Mitra
                    </a>
                    <a href="{{ route('admin.beasiswa.index') }}" 
                       class="sidebar-link {{ request()->routeIs('admin.beasiswa.*') ? 'bg-[#1D9E75] text-white shadow-md shadow-[#1D9E75]/10' : 'text-slate-500 hover:bg-[#e8f4f0] hover:text-[#1a3d6e]' }}">
                        <i class="fa-solid fa-graduation-cap w-4 text-center"></i> Data Beasiswa
                    </a>
                    <a href="{{ route('admin.rekomendasi.index') }}" 
                       class="sidebar-link {{ request()->routeIs('admin.rekomendasi.*') ? 'bg-[#1D9E75] text-white shadow-md shadow-[#1D9E75]/10' : 'text-slate-500 hover:bg-[#e8f4f0] hover:text-[#1a3d6e]' }}">
                        <i class="fa-solid fa-paper-plane w-4 text-center"></i> Rekomendasi
                    </a>
                    <a href="{{ route('admin.pendaftar.index') }}" 
                       class="sidebar-link {{ request()->routeIs('admin.pendaftar.*') ? 'bg-[#1D9E75] text-white shadow-md shadow-[#1D9E75]/10' : 'text-slate-500 hover:bg-[#e8f4f0] hover:text-[#1a3d6e]' }}">
                        <i class="fa-solid fa-user-graduate w-4 text-center"></i> Pendaftar
                    </a>
                    <a href="{{ route('admin.pengguna.index') }}" 
                       class="sidebar-link {{ request()->routeIs('admin.pengguna.*') ? 'bg-[#1D9E75] text-white shadow-md shadow-[#1D9E75]/10' : 'text-slate-500 hover:bg-[#e8f4f0] hover:text-[#1a3d6e]' }}">
                        <i class="fa-solid fa-users w-4 text-center"></i> Pengguna
                    </a>
                    <a href="{{ route('admin.laporan') }}" 
                       class="sidebar-link {{ request()->routeIs('admin.laporan') ? 'bg-[#1D9E75] text-white shadow-md shadow-[#1D9E75]/10' : 'text-slate-500 hover:bg-[#e8f4f0] hover:text-[#1a3d6e]' }}">
                        <i class="fa-regular fa-file-lines w-4 text-center"></i> Laporan
                    </a>
                @endrole

                @role('Guru BK')
                    <a href="{{ route('guru.siswa.index') }}" 
                       class="sidebar-link {{ request()->routeIs('guru.siswa.index') || request()->routeIs('guru.siswa.edit') ? 'bg-[#1D9E75] text-white shadow-md shadow-[#1D9E75]/10' : 'text-slate-500 hover:bg-[#e8f4f0] hover:text-[#1a3d6e]' }}">
                        <i class="fa-solid fa-users w-4 text-center"></i> Data Siswa
                    </a>
                    <a href="{{ route('guru.siswa.create') }}" 
                       class="sidebar-link {{ request()->routeIs('guru.siswa.create') || request()->routeIs('guru.siswa.proses') ? 'bg-[#1D9E75] text-white shadow-md shadow-[#1D9E75]/10' : 'text-slate-500 hover:bg-[#e8f4f0] hover:text-[#1a3d6e]' }}">
                        <i class="fa-solid fa-user-plus w-4 text-center"></i> Input Profil Siswa
                    </a>
                @endrole
            </nav>
        </div>

        <!-- Sidebar Footer & User Profile Info -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-9 w-9 rounded-full bg-[#1a3d6e]/10 border border-[#1a3d6e]/20 flex items-center justify-center text-[#1a3d6e] font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-slate-800 truncate leading-snug">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-500 font-semibold truncate leading-none mt-0.5">
                        @if(Auth::user()->nip)
                            NIP. {{ Auth::user()->nip }}
                        @else
                            {{ Auth::user()->hasRole('Admin') ? 'Administrator' : 'Guru BK' }}
                        @endif
                    </p>
                </div>
            </div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2 px-3 rounded-xl border border-slate-200 hover:border-rose-200 bg-white text-slate-500 hover:text-rose-600 text-xs font-bold flex items-center justify-center gap-2 transition-all cursor-pointer shadow-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="ml-[220px] flex-1 flex flex-col min-h-screen">
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-100 sticky top-0 z-20 flex items-center justify-between px-8">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-600">Portal</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-slate-700 font-bold">
                    @if(request()->routeIs('dashboard'))
                        Dashboard
                    @elseif(request()->routeIs('admin.roles'))
                        Manajemen Pengguna
                    @elseif(request()->routeIs('admin.laporan'))
                        Laporan Rekomendasi
                    @elseif(request()->routeIs('guru.input-siswa'))
                        Input Profil Siswa
                    @else
                        Halaman
                    @endif
                </span>
            </nav>

            <!-- Notifications & Profile Avatar -->
            <div class="flex items-center gap-4">
                <button class="relative text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-regular fa-bell text-lg"></i>
                    <span class="absolute -top-0.5 -right-0.5 h-2 w-2 rounded-full bg-[#1D9E75]"></span>
                </button>
                <div class="h-9 w-9 rounded-full bg-[#1a3d6e] flex items-center justify-center text-white font-bold text-sm border-2 border-white shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Slot Content -->
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-150 py-5 px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-slate-500 font-semibold">&copy; 2024 MGBK Indonesia. All rights reserved.</p>
            <div class="flex gap-5 text-[11px] font-bold text-slate-400">
                <a href="#" class="hover:text-slate-600">Kebijakan Privasi</a>
                <span class="text-slate-200">|</span>
                <a href="#" class="hover:text-slate-600">Syarat & Ketentuan</a>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
