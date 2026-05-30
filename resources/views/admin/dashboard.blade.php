<x-app-layout>
    <div class="space-y-8">
        {{-- Top Bar / Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="heading-font text-3xl font-extrabold text-[#1a3d6e] tracking-tight">Selamat Datang, Admin</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-semibold mt-1">
                    <i class="fa-solid fa-calendar-days text-[#1D9E75] mr-1"></i>
                    {{ now()->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                <button onclick="alert('Laporan sedang diekspor...')" class="px-4 py-2.5 rounded-xl border border-slate-250 hover:border-slate-350 bg-white text-slate-700 text-xs font-bold transition-all flex items-center gap-2 shadow-sm cursor-pointer">
                    <i class="fa-solid fa-file-export text-slate-400"></i> Export Laporan
                </button>
                <button onclick="alert('Tambah Kampus Mitra sedang dibuka...')" class="px-4 py-2.5 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all flex items-center gap-2 shadow-md shadow-[#1D9E75]/10 cursor-pointer">
                    <i class="fa-solid fa-plus"></i> Tambah Kampus Mitra
                </button>
            </div>
        </div>

        {{-- Main 2-Column Grid Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Left Column (Main Dashboard Content - 8 cols) --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- 4 Stat Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-stat-card icon="fa-solid fa-graduation-cap" label="Total Beasiswa" value="{{ $totalBeasiswa }}" trend="+12% Bulan ini" :trendUp="true" />
                    <x-stat-card icon="fa-solid fa-university" label="Total Kampus Mitra" value="{{ $totalKampus }}" trend="Institusi Terdaftar" :trendUp="true" />
                    <x-stat-card icon="fa-solid fa-chalkboard-user" label="Total Guru BK" value="{{ $totalGuru }}" trend="Pembimbing Aktif" :trendUp="true" />
                    <x-stat-card icon="fa-solid fa-user-graduate" label="Total Siswa" value="{{ $totalSiswa }}" trend="+43 Siswa Baru" :trendUp="true" />
                </div>

                {{-- Beasiswa Terbaru Table --}}
                <x-table title="Beasiswa Terbaru" subtitle="5 program beasiswa terbaru yang dirilis oleh institusi mitra.">
                    <x-slot name="action">
                        <a href="{{ route('admin.laporan') }}" class="text-xs font-extrabold text-[#1D9E75] hover:text-[#1a3d6e] transition-colors flex items-center gap-1">
                            Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </x-slot>

                    <x-slot name="thead">
                        <th class="pb-3 pr-4">Nama Beasiswa</th>
                        <th class="pb-3 px-4">Kampus</th>
                        <th class="pb-3 px-4">Kuota</th>
                        <th class="pb-3 px-4">Status</th>
                        <th class="pb-3 pl-4 text-right">Aksi</th>
                    </x-slot>

                    @forelse ($recentBeasiswas as $b)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 pr-4">
                            <div class="font-extrabold text-[#1a3d6e] leading-snug">{{ $b->nama_beasiswa }}</div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">
                                {{ str_replace('_', ' ', $b->jenis) }}
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-600 font-bold">
                            {{ $b->kampusMitra->nama_kampus }}
                        </td>
                        <td class="py-4 px-4 text-slate-500 font-bold">
                            {{ $b->kuota }} Siswa
                        </td>
                        <td class="py-4 px-4">
                            <x-badge :variant="$b->status" />
                        </td>
                        <td class="py-4 pl-4 text-right text-base">
                            <button onclick="alert('Edit Beasiswa {{ $b->nama_beasiswa }}')" class="text-slate-400 hover:text-[#1a3d6e] transition-colors cursor-pointer mr-2.5">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button onclick="confirm('Hapus Beasiswa {{ $b->nama_beasiswa }}?')" class="text-slate-400 hover:text-rose-600 transition-colors cursor-pointer">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-450 font-medium">
                            <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 text-xl mx-auto mb-3">
                                <i class="fa-regular fa-folder-open"></i>
                            </div>
                            Belum ada data beasiswa yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </x-table>

            </div>

            {{-- Right Column (Sidebar Content - 4 cols) --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Aksi Cepat Card --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <h3 class="heading-font text-base font-extrabold text-[#1a3d6e] mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <button onclick="alert('Buka Tambah Beasiswa...')" class="w-full py-3 px-4 rounded-xl bg-[#1a3d6e] hover:bg-[#153158] text-white text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer shadow-sm shadow-[#1a3d6e]/10">
                            <i class="fa-solid fa-plus"></i> Tambah Beasiswa
                        </button>
                        <button onclick="alert('Buka Tambah Kampus...')" class="w-full py-3 px-4 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer shadow-md shadow-[#1D9E75]/10">
                            <i class="fa-solid fa-circle-plus"></i> Tambah Kampus Mitra
                        </button>
                        <button onclick="alert('Buka Undang Guru BK...')" class="w-full py-3 px-4 rounded-xl bg-white border border-slate-200 hover:border-slate-350 text-slate-700 text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                            <i class="fa-solid fa-paper-plane"></i> Undang Guru BK
                        </button>
                    </div>
                </div>

                {{-- Aktivitas Terakhir Card --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="heading-font text-base font-extrabold text-[#1a3d6e]">Aktivitas Terakhir</h3>
                        <span class="h-2 w-2 rounded-full bg-[#1D9E75] animate-ping"></span>
                    </div>

                    <div class="space-y-5">
                        @foreach ($activities as $act)
                        <div class="flex items-start gap-3.5">
                            <div class="h-8.5 w-8.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0 {{ $act['color'] ?? 'text-slate-400' }}">
                                <i class="fa-solid {{ $act['icon'] ?? 'fa-circle' }} text-sm"></i>
                            </div>
                            <div class="space-y-0.5 min-w-0">
                                <p class="text-xs font-bold text-slate-800 leading-snug break-words">{{ $act['title'] }}</p>
                                <span class="text-[10px] text-slate-400 font-semibold block">{{ $act['time'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
