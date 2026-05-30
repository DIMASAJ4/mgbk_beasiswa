<nav x-data="{ open: false, dropdownOpen: false }" class="sticky top-0 w-full z-40 bg-slate-950/85 backdrop-blur-md border-b border-slate-900 transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo1.png') }}" alt="Logo Pejuang Sukses" class="h-10 w-10 object-contain rounded-xl">
                    <span class="heading-font text-lg font-extrabold tracking-wider bg-gradient-to-r from-white to-indigo-300 bg-clip-text text-transparent">
                        PEJUANG <span class="text-indigo-400">SUKSES</span>
                    </span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:gap-6 text-sm font-semibold">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'text-white bg-slate-900/60 border border-slate-800' : 'text-slate-400 hover:text-white' }}">
                        <i class="fa-solid fa-chart-line mr-2"></i>Dashboard
                    </a>
                    
                    <!-- Admin Only: User & Role Management -->
                    @role('Admin')
                    <a href="{{ route('admin.roles') }}" class="px-3 py-2 rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.roles') ? 'text-white bg-slate-900/60 border border-slate-800' : 'text-slate-400 hover:text-white' }}">
                        <i class="fa-solid fa-user-shield mr-2"></i>Manajemen Peran
                    </a>
                    @endrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 relative">
                <div @click.away="dropdownOpen = false" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="inline-flex items-center px-4 py-2 border border-slate-800 rounded-xl text-sm font-semibold text-slate-300 hover:text-white bg-slate-900/40 hover:bg-slate-900/80 transition-all duration-150 focus:outline-none cursor-pointer">
                        <div class="h-6 w-6 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-xs font-bold mr-2.5">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>{{ Auth::user()->name }}</div>
                        <i class="fa-solid fa-chevron-down text-slate-500 text-[10px] ml-2.5 transition-transform duration-150" :class="dropdownOpen ? 'rotate-180' : ''"></i>
                    </button>

                    <!-- Dropdown Options -->
                    <div x-show="dropdownOpen" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="transform opacity-0 scale-95" 
                         x-transition:enter-end="transform opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="transform opacity-100 scale-100" 
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2.5 w-48 rounded-xl bg-slate-900/90 backdrop-blur-lg border border-slate-800 shadow-2xl p-2 z-50"
                         style="display: none;">
                        
                        <!-- Role Badge inside -->
                        <div class="px-3 py-2 border-b border-slate-800 mb-1">
                            <span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold block">Hak Akses</span>
                            <span class="text-xs font-bold text-indigo-400 block mt-0.5">{{ Auth::user()->roles->pluck('name')->first() ?? 'Tidak ada peran' }}</span>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-slate-300 hover:text-white hover:bg-slate-800/50 rounded-lg transition-colors">
                            <i class="fa-regular fa-user text-slate-500 w-4"></i>Profil Saya
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs font-semibold text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 rounded-lg transition-colors text-left cursor-pointer">
                                <i class="fa-solid fa-right-from-bracket w-4"></i>Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-xl border border-slate-800 text-slate-400 hover:text-white bg-slate-900/30 hover:bg-slate-900/60 focus:outline-none transition duration-150 cursor-pointer">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Drawer -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-950/95 border-b border-slate-900 px-6 py-4 space-y-4">
        <div class="space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('dashboard') ? 'text-white bg-slate-900' : 'text-slate-400' }}">
                <i class="fa-solid fa-chart-line mr-2"></i>Dashboard
            </a>
            
            @role('Admin')
            <a href="{{ route('admin.roles') }}" class="block px-4 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.roles') ? 'text-white bg-slate-900' : 'text-slate-400' }}">
                <i class="fa-solid fa-user-shield mr-2"></i>Manajemen Peran
            </a>
            @endrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 border-t border-slate-900">
            <div class="px-4 mb-3 flex items-center gap-3">
                <div class="h-9 w-9 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-bold text-sm text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded-xl text-xs font-bold text-slate-400 hover:text-white">
                    <i class="fa-regular fa-user mr-2"></i>Profil Saya
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 rounded-xl text-xs font-bold text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
