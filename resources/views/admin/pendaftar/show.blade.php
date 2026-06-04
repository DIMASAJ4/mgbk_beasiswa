<x-app-layout>
    <div class="space-y-6">
        <!-- Top Navigation / Breadcrumbs & Action Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                    <a href="{{ route('admin.pendaftar.index') }}" class="hover:text-slate-600">Pendaftar</a>
                    <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    <span class="text-slate-700">Daftar Peminat</span>
                </div>
                <h1 class="heading-font text-xl font-bold text-slate-800">{{ $beasiswa->nama_beasiswa }}</h1>
                <p class="text-xs text-slate-500">Daftar lengkap siswa peminat yang mengonfirmasi pilihan beasiswa ini.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('admin.pendaftar.excel', $beasiswa->id) }}" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md shadow-emerald-600/10 cursor-pointer">
                    <i class="fa-solid fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('admin.pendaftar.pdf', $beasiswa->id) }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-rose-600 hover:bg-rose-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md shadow-rose-600/10 cursor-pointer">
                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('admin.pendaftar.index') }}" class="inline-flex items-center justify-center gap-2 border border-slate-200 hover:border-slate-300 text-slate-500 bg-white hover:bg-slate-50 px-4 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Scholarship details header card -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-1.5">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Kampus Mitra</span>
                <p class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                    <i class="fa-solid fa-university text-[#1a3d6e]"></i> {{ $beasiswa->kampusMitra->nama_kampus ?? 'N/A' }}
                </p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-1.5">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Jenis Pembiayaan</span>
                <p class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                    <i class="fa-solid fa-wallet text-[#1D9E75]"></i> {{ ucwords(str_replace('_', ' ', $beasiswa->jenis)) }}
                </p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-1.5">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Deadline Beasiswa</span>
                <p class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                    <i class="fa-regular fa-calendar-check text-rose-500"></i> {{ $beasiswa->deadline ? $beasiswa->deadline->format('d M Y') : '-' }}
                </p>
            </div>
            <div class="bg-[#1D9E75]/5 p-5 rounded-2xl border border-[#1D9E75]/10 shadow-sm space-y-1.5">
                <span class="text-[10px] text-[#1D9E75] font-bold uppercase tracking-wider">Pendaftar / Kuota</span>
                <p class="text-sm font-extrabold text-[#1a3d6e] flex items-center gap-1.5">
                    <i class="fa-solid fa-users"></i> {{ count($pendaftars) }} / {{ $beasiswa->kuota }} Pendaftar
                </p>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <!-- Search block -->
            <div class="p-5 border-b border-slate-100 bg-slate-50/20 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h3 class="text-xs font-bold text-slate-700">Daftar Peminat Terdaftar</h3>
                <form action="{{ route('admin.pendaftar.show', $beasiswa->id) }}" method="GET" class="w-full sm:w-72 relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama siswa..." class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-[#1D9E75] focus:border-[#1D9E75] focus:outline-none transition-all placeholder:text-slate-400">
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-left">
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider text-center w-[60px]">No</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider">Nama Siswa</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider">NISN</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider">Sekolah / Kelas</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider text-center">Nilai Rata</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider">Ekonomi</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider text-center">Rekomendasi Oleh</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider">Tanggal Dipilih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 text-xs">
                        @forelse ($pendaftars as $index => $p)
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="py-4 px-6 text-center text-slate-400 font-semibold">{{ $index + 1 }}</td>
                                <td class="py-4 px-6 font-bold text-slate-800">{{ $p->dataSiswa->user->name ?? 'N/A' }}</td>
                                <td class="py-4 px-6 text-slate-500 font-medium">{{ $p->dataSiswa->user->nisn ?? '-' }}</td>
                                <td class="py-4 px-6 text-slate-500 font-medium">
                                    {{ $p->dataSiswa->user->sekolah ?? 'SMA Negeri' }}
                                    <div class="text-[10px] text-slate-400 font-medium mt-0.5">Kelas: {{ $p->dataSiswa->user->kelas ?? '-' }}</div>
                                </td>
                                <td class="py-4 px-6 text-center font-bold text-[#1D9E75]">{{ number_format($p->dataSiswa->nilai_rata, 2) }}</td>
                                <td class="py-4 px-6 text-slate-500 font-semibold">
                                    {{ ucwords(str_replace('_', ' ', $p->dataSiswa->kondisi_ekonomi)) }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($p->direkomendasikan_oleh === 'admin')
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-[#1a3d6e]/10 text-[#1a3d6e] border border-[#1a3d6e]/20">
                                            Admin
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-[#1D9E75]/10 text-[#1D9E75] border border-[#1D9E75]/20">
                                            Guru BK
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-slate-500 font-semibold">
                                    {{ $p->dipilih_at ? (($p->dipilih_at instanceof \DateTimeInterface) ? $p->dipilih_at->format('d M Y') : \Carbon\Carbon::parse($p->dipilih_at)->format('d M Y')) : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-16 text-center">
                                    <div class="max-w-[280px] mx-auto space-y-3">
                                        <div class="h-12 w-12 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto border border-slate-100 text-lg">
                                            <i class="fa-regular fa-face-frown"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800">Belum ada pendaftar</h4>
                                            <p class="text-xs text-slate-400 mt-1">Belum ada siswa yang memilih beasiswa ini sebagai pilihan utama mereka.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
