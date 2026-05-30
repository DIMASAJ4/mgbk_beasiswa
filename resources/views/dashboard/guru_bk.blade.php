<x-app-layout>
    {{-- Hero Banner --}}
    <div class="rounded-2xl overflow-hidden relative mb-8 bg-[#1a3d6e] text-white p-8 min-h-[160px] flex flex-col justify-center shadow-lg shadow-[#1a3d6e]/5">
        {{-- Subtle Background Overlay --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-72 h-72 rounded-full bg-[#1D9E75]/10 -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
            <div class="absolute bottom-0 left-1/3 w-48 h-48 rounded-full bg-blue-500/10 translate-y-1/2 blur-2xl"></div>
        </div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white text-xs font-semibold mb-3">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Bimbingan Konseling Portal
                </span>
                <h1 class="heading-font text-3xl font-extrabold text-white mb-1">
                    Selamat Datang, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="text-blue-100 text-sm font-medium">
                    Guru BK &bull; {{ Auth::user()->sekolah ?? 'SMA Negeri 1 Jakarta' }}
                </p>
            </div>
            <div>
                <a href="{{ route('guru.siswa.create') }}" class="px-5 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-sm font-bold flex items-center justify-center gap-2 transition-all shadow-lg shadow-[#1D9E75]/10 cursor-pointer">
                    <i class="fa-solid fa-user-plus"></i> Input Profil Siswa
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card icon="fa-solid fa-users" label="Siswa Dibimbing" value="{{ $totalSiswaDibimbing }}" trend="Siswa terdaftar di sekolah Anda" :trendUp="true" />
        <x-stat-card icon="fa-solid fa-paper-plane" label="Rekomendasi Dikirim" value="{{ $rekomendasiDikirim }}" trend="Total rekomendasi yang dikirim" :trendUp="true" />
        <x-stat-card icon="fa-solid fa-graduation-cap" label="Beasiswa Tersedia" value="{{ $beasiswaTersedia }}" trend="Program beasiswa aktif saat ini" :trendUp="true" />
        
        {{-- Siswa Belum Diproses (Highlight red if > 0) --}}
        @if($siswaBelumDiproses > 0)
            <div class="bg-rose-50 border border-rose-200 rounded-2xl p-6 hover:shadow-md transition-shadow duration-200 group flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold text-rose-500 uppercase tracking-wider">Siswa Belum Diproses</p>
                        <h3 class="heading-font text-3xl font-extrabold text-rose-700 mt-2">{{ $siswaBelumDiproses }}</h3>
                    </div>
                    <div class="h-12 w-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl group-hover:bg-rose-650 group-hover:text-white transition-all duration-200">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 mt-4 text-[11px] font-bold text-rose-600">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Tindakan verifikasi diperlukan!</span>
                </div>
            </div>
        @else
            <x-stat-card icon="fa-solid fa-circle-check" label="Siswa Belum Diproses" value="0" trend="Semua siswa sudah diproses" :trendUp="true" />
        @endif
    </div>

    {{-- Main Contents Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- Left Column (8 cols) --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- Daftar Siswa Terbaru Table --}}
            <x-table title="Daftar Siswa Terbaru" subtitle="Daftar siswa baru yang didaftarkan di sekolah Anda.">
                <x-slot name="thead">
                    <th class="pb-3 pr-4">Nama Siswa</th>
                    <th class="pb-3 px-4">Sekolah</th>
                    <th class="pb-3 px-4">Status Rekomendasi</th>
                    <th class="pb-3 pl-4 text-right">Aksi</th>
                </x-slot>

                @forelse($recentSiswa as $s)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="py-4 pr-4">
                        <div class="flex items-center gap-3">
                            <div class="h-8.5 w-8.5 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center font-bold shadow-sm">
                                {{ substr($s->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-extrabold text-[#1a3d6e] group-hover:text-[#1D9E75] transition-colors leading-snug">{{ $s->name }}</div>
                                <div class="text-[9px] text-slate-400 font-bold uppercase mt-0.5">NISN: {{ $s->nisn ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 font-bold text-slate-500">
                        {{ $s->sekolah }}
                    </td>
                    <td class="py-4 px-4">
                        @if($s->dataSiswa && $s->dataSiswa->rekomendasis->count() > 0)
                            <x-badge variant="terverifikasi" value="Direkomendasikan" />
                        @else
                            <x-badge variant="menunggu" value="Belum Diproses" />
                        @endif
                    </td>
                    <td class="py-4 pl-4 text-right">
                        <a href="{{ route('guru.siswa.proses', $s->id) }}" class="px-3.5 py-1.5 rounded-xl bg-amber-50 border border-amber-250 hover:bg-amber-500 hover:text-white hover:border-transparent text-amber-700 text-[10px] font-bold transition-all shadow-sm cursor-pointer">
                            Proses
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 text-center text-slate-455 font-medium">
                        <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 text-xl mx-auto mb-3">
                            <i class="fa-regular fa-folder-open"></i>
                        </div>
                        Belum ada siswa terdaftar di sekolah Anda.
                    </td>
                </tr>
                @endforelse
            </x-table>

            {{-- Beasiswa Aktif Terbaru Section --}}
            <div class="space-y-4">
                <h3 class="heading-font text-lg font-extrabold text-[#1a3d6e]">Beasiswa Aktif Terbaru</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($activeBeasiswas as $b)
                    <div class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            {{-- Thumbnail area --}}
                            <div class="h-28 w-full rounded-xl bg-gradient-to-br from-[#1a3d6e]/5 to-[#1D9E75]/5 border border-slate-100 flex items-center justify-center text-[#1a3d6e] text-3xl mb-4 relative overflow-hidden">
                                <i class="fa-solid fa-graduation-cap text-[#1a3d6e]/20 text-5xl absolute"></i>
                                @if($b->deadline->diffInDays(now()) <= 14)
                                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100 shadow-sm">
                                        Segera Berakhir
                                    </span>
                                @else
                                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider bg-[#e8f4f0] text-[#1D9E75] border border-[#1D9E75]/15 shadow-sm">
                                        Terbuka
                                    </span>
                                @endif
                            </div>

                            <h4 class="font-extrabold text-[#1a3d6e] text-xs leading-snug line-clamp-2 mb-1">{{ $b->nama_beasiswa }}</h4>
                            <p class="text-slate-450 text-[9px] font-bold uppercase tracking-wider mb-3">{{ $b->kampusMitra->nama_kampus }}</p>
                        </div>

                        <div class="border-t border-slate-50 pt-3 mt-2 flex items-center justify-between">
                            <span class="text-[9px] text-slate-400 font-bold block">Tutup: {{ $b->deadline->format('d M Y') }}</span>
                            <button onclick="alert('Rincian Beasiswa: {{ $b->nama_beasiswa }}')" class="text-[10px] font-bold text-[#1D9E75] hover:text-[#1a3d6e] transition-colors cursor-pointer">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Right Column (Sidebar - 4 cols) --}}
        <div class="lg:col-span-4 space-y-6">
            
            {{-- Quick action links --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="heading-font text-base font-extrabold text-[#1a3d6e] mb-4">Aksi Pembimbing</h3>
                <div class="space-y-3">
                    <a href="{{ route('guru.siswa.create') }}" class="w-full py-3 px-4 rounded-xl bg-[#1a3d6e] hover:bg-[#153158] text-white text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer shadow-sm shadow-[#1a3d6e]/10">
                        <i class="fa-solid fa-user-plus"></i> Input Profil Siswa Baru
                    </a>
                    <a href="{{ route('guru.siswa.index') }}" class="w-full py-3 px-4 rounded-xl bg-white border border-slate-200 hover:border-slate-350 text-slate-700 text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                        <i class="fa-solid fa-users"></i> Lihat Seluruh Siswa
                    </a>
                </div>
            </div>

            {{-- Beasiswa Populer Card --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="heading-font text-base font-extrabold text-[#1a3d6e] mb-4">Beasiswa Populer</h3>
                
                <div class="space-y-4">
                    @foreach ($popularBeasiswas as $b)
                    <div class="flex items-start gap-3.5">
                        <div class="h-8.5 w-8.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0 text-[#1a3d6e]">
                            <i class="fa-solid fa-university text-sm"></i>
                        </div>
                        <div class="space-y-0.5 min-w-0">
                            <h4 class="text-xs font-bold text-slate-800 leading-snug truncate">{{ $b->nama_beasiswa }}</h4>
                            <span class="text-[9px] text-[#1D9E75] font-semibold block">{{ $b->kampusMitra->nama_kampus }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
