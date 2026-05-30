<x-siswa-layout>
    {{-- Hero Banner --}}
    <div class="rounded-3xl overflow-hidden relative mb-8 bg-[#1a3d6e] text-white p-8 sm:p-10 shadow-xl shadow-[#1a3d6e]/10">
        {{-- Subtle Background Overlay --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-80 h-80 rounded-full bg-[#1D9E75]/15 -translate-y-1/2 translate-x-1/3 blur-3xl"></div>
            <div class="absolute bottom-0 left-1/3 w-64 h-64 rounded-full bg-blue-800/20 translate-y-1/2 blur-2xl"></div>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="heading-font text-3xl font-extrabold text-white mb-2 tracking-tight">
                    Halo, {{ $user->name }}! 👋
                </h1>
                <p class="text-blue-100 text-sm font-medium flex items-center gap-3">
                    <span>Siswa {{ $user->kelas ?? 'Kelas XII' }}</span>
                    <span class="text-blue-300">•</span>
                    <span>{{ $user->sekolah ?? 'SMA Negeri 1 Jakarta' }}</span>
                </p>
                <div class="flex flex-wrap items-center gap-2.5 mt-5">
                    @if($dataSiswa)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white/10 border border-white/20 text-white text-xs font-semibold">
                            <i class="fa-solid fa-graduation-cap"></i>
                            Minat: {{ is_array($dataSiswa->minat_jurusan) ? implode(', ', $dataSiswa->minat_jurusan) : 'IPA' }}
                        </span>
                        @if($dataSiswa->is_verified)
                            <x-badge variant="terverifikasi" value="Profil Terverifikasi" class="shadow-sm shadow-emerald-600/10" />
                        @endif
                    @endif
                </div>
            </div>
            
            @if ($dataSiswa)
            <div class="bg-white/10 border border-white/20 rounded-2xl p-5 shrink-0 backdrop-blur-md">
                <p class="text-xs text-blue-200 font-bold uppercase tracking-wider">Nilai Rata-Rata</p>
                <h3 class="heading-font text-3xl font-black text-white mt-1">{{ number_format($dataSiswa->nilai_rata, 2) }}</h3>
                <span class="text-[10px] text-emerald-300 font-semibold block mt-1.5"><i class="fa-solid fa-circle-check"></i> Valid untuk Beasiswa</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Rekomendasi Beasiswa Untukmu --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="heading-font text-xl font-extrabold text-[#1a3d6e] tracking-tight">Rekomendasi Beasiswa Untukmu</h2>
                <p class="text-slate-500 text-xs mt-0.5">Rekomendasi yang disesuaikan secara khusus dengan capaian akademis dan minat Anda.</p>
            </div>
        </div>

        {{-- Banners --}}
        @if ($chosenRecommendation)
            <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs font-semibold shadow-sm">
                <i class="fa-solid fa-circle-check text-base text-[#1D9E75]"></i>
                <span>Kamu telah memilih beasiswa <strong>{{ $chosenRecommendation->beasiswa->nama_beasiswa }}</strong>. Hubungi Guru BK untuk informasi selanjutnya.</span>
            </div>
        @else
            <div class="mb-6 flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-2xl text-xs font-semibold shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-base text-amber-500"></i>
                <span>Kamu hanya dapat memilih 1 beasiswa. Pertimbangkan dengan matang sebelum memilih.</span>
            </div>
        @endif

        {{-- Alert Notification --}}
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs font-semibold shadow-sm">
                <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs font-semibold shadow-sm">
                <i class="fa-solid fa-circle-xmark text-base text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-6">
            @forelse ($recommendations as $rek)
                @php
                    $isChosen = $rek->dipilih_siswa;
                    $borderClass = $isChosen ? 'border-2 border-[#1D9E75] shadow-lg shadow-[#1D9E75]/5' : 'border border-slate-100 hover:shadow-md';
                @endphp
                <div class="bg-white rounded-2xl p-6 relative transition-all duration-200 flex flex-col justify-between {{ $borderClass }}">
                    @if ($isChosen)
                        <div class="absolute top-4 right-4 z-10">
                            <span class="px-2.5 py-1 rounded-full text-[9px] font-black bg-[#1D9E75] text-white flex items-center gap-1 shadow-sm uppercase tracking-wider">
                                <i class="fa-solid fa-check"></i> Beasiswa Pilihanmu
                            </span>
                        </div>
                    @else
                        {{-- Match % Badge --}}
                        <div class="absolute top-4 right-4 flex items-center gap-2 z-10">
                            @if ($rek->created_at && $rek->created_at->diffInDays(now()) < 3)
                                <span class="px-2 py-0.5 rounded-lg text-[9px] font-black bg-amber-500 text-white animate-pulse">
                                    BARU
                                </span>
                            @endif
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-blue-50 text-[#1a3d6e] border border-blue-100">
                                {{ $rek->persentase_kecocokan }}% Cocok
                            </span>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            @if($rek->direkomendasikan_oleh === 'admin')
                                <span class="px-2 py-0.5 rounded text-[8px] font-bold bg-blue-50 text-[#1a3d6e] border border-blue-100 uppercase tracking-wide">
                                    Dari Admin
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[8px] font-bold bg-[#e8f4f0] text-[#1D9E75] border border-[#1D9E75]/15 uppercase tracking-wide">
                                    Dari Guru BK
                                </span>
                            @endif
                        </div>

                        <div class="flex items-start gap-4 mb-4">
                            <div class="h-11 w-11 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[#1a3d6e] text-lg shrink-0">
                                <i class="fa-solid fa-university"></i>
                            </div>
                            <div class="flex-1 pr-16">
                                <h3 class="font-extrabold text-[#1a3d6e] text-sm leading-tight line-clamp-2" title="{{ $rek->beasiswa->nama_beasiswa }}">
                                    {{ $rek->beasiswa->nama_beasiswa }}
                                </h3>
                                <p class="text-slate-400 text-[10px] font-bold mt-1 uppercase tracking-wide">
                                    {{ $rek->beasiswa->kampusMitra->nama_kampus }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3.5 mt-6 pt-4 border-t border-slate-50">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <div class="flex items-center gap-1.5 {{ $rek->beasiswa->deadline && $rek->beasiswa->deadline->diffInDays(now()) <= 7 ? 'text-rose-600' : 'text-slate-400' }}">
                                <i class="fa-regular fa-calendar"></i>
                                <span>
                                    @if($rek->beasiswa->deadline->isPast())
                                        Tutup
                                    @elseif($rek->beasiswa->deadline->diffInDays(now()) <= 7)
                                        Sisa {{ $rek->beasiswa->deadline->diffForHumans(null, true) }}!
                                    @else
                                        Batas: {{ $rek->beasiswa->deadline->format('d M Y') }}
                                    @endif
                                </span>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-slate-100 text-slate-500">
                                {{ ucwords(str_replace('_', ' ', $rek->beasiswa->jenis)) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('siswa.rekomendasi.detail', $rek->id) }}" class="w-full inline-flex items-center justify-center border border-slate-250 hover:border-slate-350 hover:bg-slate-50 text-slate-650 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer">
                                Lihat Detail
                            </a>

                            @if ($isChosen)
                                <button disabled class="w-full py-2 rounded-xl bg-[#1D9E75] text-white text-xs font-bold cursor-not-allowed shadow-md shadow-[#1D9E75]/10 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-circle-check"></i> Terpilih
                                </button>
                            @elseif ($chosenRecommendation)
                                <button disabled class="w-full py-2 rounded-xl bg-slate-100 text-slate-400 border border-slate-100 text-xs font-bold cursor-not-allowed">
                                    Pilih Beasiswa
                                </button>
                            @else
                                <form action="{{ route('siswa.rekomendasi.pilih') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="rekomendasi_id" value="{{ $rek->id }}">
                                    <button type="submit" class="w-full py-2 rounded-xl bg-[#1D9E75] hover:bg-[#15803d] text-white text-xs font-bold transition-all shadow-md shadow-[#1D9E75]/10 hover:shadow-lg cursor-pointer">
                                        Pilih Beasiswa
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 bg-white rounded-2xl border border-slate-100 p-8 text-center">
                    <div class="h-14 w-14 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-300 text-2xl mx-auto mb-4">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>
                    <p class="text-slate-500 text-sm font-semibold">Belum ada rekomendasi beasiswa yang dikirim oleh Admin atau Guru BK Anda.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Semua Beasiswa Tersedia --}}
    <div id="semua">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="heading-font text-xl font-extrabold text-[#1a3d6e] tracking-tight">Semua Beasiswa Tersedia</h2>
                <p class="text-slate-500 text-xs mt-0.5">Daftar lengkap program beasiswa aktif dari kampus-kampus mitra nasional.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" id="searchBeasiswa" placeholder="Cari beasiswa..."
                           class="pl-9 pr-4 py-2.5 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 w-48 placeholder-slate-400 shadow-sm transition-all">
                </div>
                <button class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs text-slate-500 font-bold flex items-center gap-1.5 hover:border-slate-350 hover:bg-slate-50 transition-colors shadow-sm cursor-pointer">
                    <i class="fa-solid fa-filter text-slate-400"></i> Filter
                </button>
            </div>
        </div>

        <div class="space-y-4" id="beasiswaList">
            @foreach ($allBeasiswas as $b)
            <div class="bg-white rounded-2xl border border-slate-100 p-5 flex flex-col sm:flex-row items-start sm:items-center gap-5 hover:shadow-md transition-all duration-200 beasiswa-card" data-name="{{ strtolower($b->nama_beasiswa) }}">
                {{-- Thumbnail --}}
                <div class="h-20 w-32 rounded-xl bg-gradient-to-br from-[#1a3d6e]/5 to-[#1a3d6e]/15 border border-[#1a3d6e]/10 flex items-center justify-center text-[#1a3d6e]/40 text-3xl shrink-0 overflow-hidden">
                    <i class="fa-solid fa-university"></i>
                </div>

                {{-- Info --}}
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <span class="px-2.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-[#e8f4f0] text-[#1D9E75] border border-[#1D9E75]/10">
                            {{ str_replace('_', ' ', strtoupper($b->jenis)) }}
                        </span>
                        <span class="text-slate-400 text-xs font-semibold">&bull; {{ $b->kampusMitra->nama_kampus }}</span>
                    </div>
                    <h3 class="font-extrabold text-[#1a3d6e] text-base leading-tight mb-1">{{ $b->nama_beasiswa }}</h3>
                    <p class="text-slate-500 text-xs leading-relaxed line-clamp-2">{{ $b->deskripsi }}</p>
                </div>

                {{-- Action --}}
                <div class="flex flex-col items-end gap-3 shrink-0 self-start sm:self-center">
                    <div class="text-right">
                        <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Batas Akhir</span>
                        <span class="text-sm font-extrabold {{ $b->deadline->isPast() ? 'text-rose-500 line-through' : 'text-[#1a3d6e]' }}">
                            {{ $b->deadline->format('d M Y') }}
                        </span>
                    </div>
                    <a href="{{ route('siswa.beasiswa.detail', $b->id) }}" class="px-4 py-2 rounded-xl bg-white border border-slate-250 hover:bg-slate-50 hover:border-slate-350 text-slate-650 text-xs font-bold transition-all shadow-sm cursor-pointer inline-flex items-center justify-center">
                        Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('searchBeasiswa')?.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.beasiswa-card').forEach(card => {
                card.style.display = card.dataset.name?.includes(q) ? '' : 'none';
            });
        });
    </script>
    @endpush
</x-siswa-layout>
