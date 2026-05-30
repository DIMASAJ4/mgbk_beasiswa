<x-siswa-layout>
    <div class="space-y-6 max-w-4xl mx-auto pb-24 relative">
        <!-- Breadcrumb & Back navigation -->
        <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-600">Dashboard</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span class="text-slate-700 font-bold">Detail Rekomendasi</span>
        </div>

        @if (session('error'))
            <div class="flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs font-semibold shadow-sm">
                <i class="fa-solid fa-circle-xmark text-base text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Beasiswa Header Info Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 rounded-full bg-[#1D9E75]/5 translate-y-[-20%] translate-x-[20%] blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row gap-6 items-start md:items-center">
                <!-- Thumbnail -->
                <div class="h-20 w-32 rounded-2xl bg-gradient-to-tr from-[#1a3d6e]/5 to-[#1D9E75]/5 border border-[#1a3d6e]/10 flex items-center justify-center text-[#1a3d6e] text-3xl shrink-0 overflow-hidden shadow-inner">
                    @if($beasiswa->thumbnail)
                        <img src="{{ Storage::url($beasiswa->thumbnail) }}" alt="{{ $beasiswa->nama_beasiswa }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-university"></i>
                    @endif
                </div>

                <!-- Info Block -->
                <div class="flex-1 space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-lg text-[9px] font-extrabold uppercase tracking-wider bg-[#e8f4f0] text-[#1D9E75] border border-[#1D9E75]/15">
                            {{ str_replace('_', ' ', strtoupper($beasiswa->jenis)) }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-lg text-[9px] font-extrabold uppercase tracking-wider bg-blue-50 text-[#1a3d6e] border border-blue-100">
                            {{ isset($rekomendasi) ? $rekomendasi->persentase_kecocokan : ($matchScore ?? 0) }}% Cocok
                        </span>
                        @if($beasiswa->status === 'aktif')
                            <span class="px-2.5 py-0.5 rounded-lg text-[9px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Aktif
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-lg text-[9px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-500 border border-slate-200">
                                Tutup
                            </span>
                        @endif
                    </div>
                    <h1 class="heading-font text-xl md:text-2xl font-black text-[#1a3d6e] leading-tight">
                        {{ $beasiswa->nama_beasiswa }}
                    </h1>
                    <p class="text-xs text-slate-400 font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-graduation-cap"></i> {{ $beasiswa->kampusMitra->nama_kampus ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Two Columns Info layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Info column (2/3 width) -->
            <div class="md:col-span-2 space-y-6">
                <!-- Section 1: Informasi Beasiswa -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                    <h3 class="heading-font text-sm font-black text-[#1a3d6e] border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-info-circle text-[#1D9E75]"></i> Deskripsi & Informasi Beasiswa
                    </h3>
                    <p class="text-xs text-slate-500 leading-relaxed whitespace-pre-line">
                        {{ $beasiswa->deskripsi }}
                    </p>

                    <div class="grid grid-cols-2 gap-4 pt-3 text-xs">
                        <div class="space-y-1 p-3 bg-slate-50/50 rounded-2xl border border-slate-100">
                            <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Kuota Beasiswa</span>
                            <p class="font-extrabold text-slate-800">{{ $beasiswa->kuota }} Kuota Penerima</p>
                        </div>
                        <div class="space-y-1 p-3 bg-slate-50/50 rounded-2xl border border-slate-100">
                            <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Kontak Kampus</span>
                            <p class="font-extrabold text-[#1a3d6e] hover:underline cursor-pointer">
                                {{ $beasiswa->kampusMitra->kontak ?? 'hubungi@kampus.ac.id' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Persyaratan Beasiswa -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                    <h3 class="heading-font text-sm font-black text-[#1a3d6e] border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-[#1D9E75]"></i> Persyaratan & Validasi Profilmu
                    </h3>
                    
                    <div class="space-y-3">
                        @if(!empty($metRequirements) || !empty($unmetRequirements))
                            <!-- Met requirements -->
                            @foreach($metRequirements as $req)
                                <div class="flex items-start gap-3 p-3 bg-emerald-50/40 rounded-xl border border-emerald-100 text-xs">
                                    <span class="h-5 w-5 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-sm text-[10px]">✓</span>
                                    <span class="text-slate-650 font-semibold">{{ $req }}</span>
                                </div>
                            @endforeach

                            <!-- Unmet requirements -->
                            @foreach($unmetRequirements as $req)
                                <div class="flex items-start gap-3 p-3 bg-rose-50/30 rounded-xl border border-rose-100 text-xs">
                                    <span class="h-5 w-5 rounded-full bg-slate-300 text-slate-600 flex items-center justify-center shrink-0 shadow-sm text-[10px]">✗</span>
                                    <span class="text-slate-400 font-medium line-through">{{ $req }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-xs text-slate-400 text-center py-4">Tidak ada persyaratan khusus terdaftar.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Sidebar Column (1/3 width) -->
            <div class="space-y-6">
                <!-- Compatibility Card -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-5">
                    <h3 class="heading-font text-sm font-black text-[#1a3d6e] border-b border-slate-100 pb-3">
                        Kecocokan Profilmu
                    </h3>

                    <!-- Large percentage display -->
                    <div class="text-center py-4 space-y-2">
                        <h2 class="heading-font text-5xl font-black text-[#1D9E75]">
                            {{ isset($rekomendasi) ? $rekomendasi->persentase_kecocokan : ($matchScore ?? 0) }}%
                        </h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Kecocokan Profil Keseluruhan</p>
                        
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden mt-3 shadow-inner">
                            <div class="bg-[#1D9E75] h-full rounded-full transition-all" style="width: {{ isset($rekomendasi) ? $rekomendasi->persentase_kecocokan : ($matchScore ?? 0) }}%"></div>
                        </div>
                    </div>

                    <!-- Breakdown elements -->
                    <div class="space-y-4 pt-3 border-t border-slate-50 text-xs">
                        <!-- Academic (40%) -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between font-bold">
                                <span class="text-slate-500">Nilai Akademik (40%)</span>
                                <span class="{{ $academicStatus === 'Memenuhi Syarat' ? 'text-emerald-600' : 'text-rose-500' }}">
                                    {{ $academicStatus }}
                                </span>
                            </div>
                            <p class="text-[10px] text-slate-400 font-medium">{{ $academicDesc }}</p>
                        </div>

                        <!-- Economy (30%) -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between font-bold">
                                <span class="text-slate-500">Kondisi Ekonomi (30%)</span>
                                <span class="{{ $economicStatus === 'Sesuai' ? 'text-emerald-600' : 'text-rose-500' }}">
                                    {{ $economicStatus }}
                                </span>
                            </div>
                            <p class="text-[10px] text-slate-400 font-medium">{{ $economicDesc }}</p>
                        </div>

                        <!-- Interest (30%) -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between font-bold">
                                <span class="text-slate-500">Minat Jurusan (30%)</span>
                                <span class="{{ $interestStatus === 'Relevan' ? 'text-emerald-600' : 'text-amber-500' }}">
                                    {{ $interestStatus }}
                                </span>
                            </div>
                            <p class="text-[10px] text-slate-400 font-medium">{{ $interestDesc }}</p>
                        </div>
                    </div>
                </div>

                <!-- Timeline / Deadline sidebar card -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3.5 text-xs">
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Timeline Pendaftaran</h4>
                    
                    @php
                        $daysLeft = $beasiswa->deadline ? now()->diffInDays($beasiswa->deadline, false) : 0;
                        $isUrgent = $daysLeft <= 7 && $daysLeft >= 0;
                    @endphp

                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <i class="fa-regular fa-calendar-alt text-[#1a3d6e] text-lg"></i>
                        <div>
                            <span class="text-[9px] text-slate-400 font-bold block uppercase">Batas Penyerahan</span>
                            <p class="font-extrabold text-slate-800">{{ $beasiswa->deadline ? $beasiswa->deadline->format('d M Y') : '-' }}</p>
                        </div>
                    </div>

                    @if($daysLeft >= 0)
                        <div class="flex items-center gap-3 p-3 {{ $isUrgent ? 'bg-rose-50 border-rose-200 text-rose-800' : 'bg-emerald-50 border-emerald-150 text-emerald-800' }} rounded-2xl border">
                            <i class="fa-regular fa-clock text-lg"></i>
                            <div>
                                <span class="text-[9px] font-bold block uppercase tracking-wide">Sisa Masa Pendaftaran</span>
                                <p class="font-extrabold text-sm">{{ $daysLeft }} Hari Lagi</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 p-3 bg-slate-100 border-slate-200 text-slate-500 rounded-2xl border">
                            <i class="fa-solid fa-lock text-lg"></i>
                            <div>
                                <span class="text-[9px] font-bold block uppercase tracking-wide">Status Pendaftaran</span>
                                <p class="font-extrabold text-sm">Sudah Berakhir</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sticky Bottom Control bar -->
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-4xl bg-white/80 backdrop-blur-md px-6 py-4 rounded-2xl border border-slate-200 shadow-xl flex items-center justify-between gap-4 z-40">
            <a href="{{ route('dashboard') }}" class="py-2.5 px-5 border border-slate-200 hover:border-slate-350 text-slate-650 rounded-xl text-xs font-bold transition-all bg-white hover:bg-slate-50 cursor-pointer">
                ← Kembali
            </a>

            @if (isset($isGeneralView) && $isGeneralView)
                <span class="text-xs font-semibold text-slate-500 flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200">
                    <i class="fa-solid fa-circle-info text-[#1a3d6e]"></i> Hubungi Guru BK / Admin untuk merekomendasikan beasiswa ini
                </span>
            @else
                @if (isset($isThisChosen) && $isThisChosen)
                    <button disabled class="py-2.5 px-6 rounded-xl bg-[#1D9E75] text-white text-xs font-extrabold shadow-md shadow-[#1D9E75]/10 flex items-center gap-1.5 cursor-not-allowed">
                        <i class="fa-solid fa-circle-check"></i> ✓ Ini Beasiswa Pilihanmu
                    </button>
                @elseif (isset($hasChosenAny) && $hasChosenAny)
                    <span class="text-xs font-semibold text-rose-500 flex items-center gap-1">
                        <i class="fa-solid fa-circle-info"></i> Kamu sudah memilih beasiswa lain
                    </span>
                @else
                    <form action="{{ route('siswa.rekomendasi.pilih') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="rekomendasi_id" value="{{ $rekomendasi->id }}">
                        <button type="submit" class="py-2.5 px-6 bg-[#1D9E75] hover:bg-[#15803d] text-white rounded-xl text-xs font-extrabold transition-all shadow-md shadow-[#1D9E75]/10 hover:shadow-lg cursor-pointer">
                            Pilih Beasiswa Ini
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</x-siswa-layout>
