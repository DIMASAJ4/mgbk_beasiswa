<x-app-layout>
    <div class="space-y-8">
        {{-- Header & Intro --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="heading-font text-3xl font-extrabold text-[#1a3d6e] tracking-tight">Ringkasan Sistem</h1>
                <p class="text-slate-500 text-sm mt-1">Selamat datang kembali! Berikut adalah data operasional portal beasiswa MGBK saat ini.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#e8f4f0] border border-[#1D9E75]/20 text-[#1D9E75] text-xs font-semibold">
                    <i class="fa-solid fa-clock"></i>
                    {{ now()->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                </span>
                <a href="{{ route('admin.laporan') }}" class="px-4 py-2 rounded-xl border border-slate-200 hover:border-slate-350 bg-white text-slate-700 text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-file-pdf text-rose-500"></i> Laporan Lengkap
                </a>
            </div>
        </div>

        {{-- Statistics Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card icon="fa-solid fa-graduation-cap" label="Total Beasiswa" value="{{ $totalBeasiswa }}" trend="+12% Bulan ini" :trendUp="true" />
            <x-stat-card icon="fa-solid fa-university" label="Kampus Mitra" value="{{ $totalKampus }}" trend="Aktif & Terdaftar" :trendUp="true" />
            <x-stat-card icon="fa-solid fa-chalkboard-user" label="Guru BK" value="{{ $totalGuru }}" trend="Pembimbing Terverifikasi" :trendUp="true" />
            <x-stat-card icon="fa-solid fa-user-graduate" label="Total Siswa" value="{{ $totalSiswa }}" trend="+43 Siswa baru" :trendUp="true" />
        </div>

        {{-- Main Sections: Table and Activities --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left column: Recent Scholarships Table --}}
            <div class="lg:col-span-2">
                <x-table title="Beasiswa Terbaru" subtitle="Program beasiswa terbaru yang didaftarkan oleh kampus mitra.">
                    <x-slot name="action">
                        <button class="px-3.5 py-1.5 rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-600 text-xs font-bold transition-all shadow-sm">
                            Lihat Semua
                        </button>
                    </x-slot>
                    
                    <x-slot name="thead">
                        <th class="pb-3 pr-4">Beasiswa</th>
                        <th class="pb-3 px-4">Kampus</th>
                        <th class="pb-3 px-4">Status</th>
                        <th class="pb-3 pl-4">Batas Akhir</th>
                    </x-slot>

                    @foreach ($recentBeasiswas as $b)
                    <tr class="text-xs group hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 pr-4">
                            <div class="font-extrabold text-[#1a3d6e] group-hover:text-[#1D9E75] transition-colors">{{ $b->nama_beasiswa }}</div>
                            <div class="text-[9px] text-slate-400 font-bold mt-0.5 uppercase tracking-wider">
                                {{ str_replace('_', ' ', $b->jenis) }}
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-600 font-bold">
                            {{ $b->kampusMitra->nama_kampus }}
                        </td>
                        <td class="py-4 px-4">
                            <x-badge :variant="$b->status" />
                        </td>
                        <td class="py-4 pl-4 text-slate-500 font-bold">
                            {{ $b->deadline->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </x-table>
            </div>

            {{-- Right column: Recent Activities --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="heading-font text-lg font-bold text-slate-800">Aktivitas Terkini</h3>
                            <p class="text-slate-400 text-xs mt-0.5">Operasi sistem otomatis dan admin.</p>
                        </div>
                        <span class="h-2 w-2 rounded-full bg-[#1D9E75] animate-ping"></span>
                    </div>

                    <div class="space-y-6">
                        @foreach ($activities as $act)
                        <div class="flex items-start gap-4">
                            <div class="h-9 w-9 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 border border-slate-100 text-[#1a3d6e]">
                                <i class="fa-solid {{ $act['icon'] ?? 'fa-circle' }} text-sm"></i>
                            </div>
                            <div class="space-y-0.5">
                                <p class="text-xs font-semibold text-slate-800 leading-snug">{{ $act['title'] }}</p>
                                <span class="text-[10px] text-slate-400 font-semibold block">{{ $act['time'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Action Panel card --}}
                <div class="mt-8 p-4 rounded-xl bg-gradient-to-tr from-[#1a3d6e] to-[#142f56] text-white relative overflow-hidden shadow-lg shadow-[#1a3d6e]/10">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full bg-white/5"></div>
                    <h4 class="heading-font font-bold text-sm">Butuh Bantuan?</h4>
                    <p class="text-[11px] text-blue-100 mt-1 leading-relaxed">Hubungi support pusat MGBK Indonesia jika ada kendala.</p>
                    <a href="mailto:support@mgbk.id" class="inline-block mt-3 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/15 text-[10px] font-bold transition-all">
                        Kirim Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
