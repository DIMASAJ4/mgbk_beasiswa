<x-app-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div>
                <h1 class="heading-font text-2xl font-bold text-slate-800">Kelola Pendaftar Beasiswa</h1>
                <p class="text-xs text-slate-500 mt-1">Pantau dan kelola daftar siswa peminat beasiswa yang telah dikonfirmasi.</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <form action="{{ route('admin.pendaftar.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <div class="w-full sm:w-64 space-y-1">
                    <label for="kampus_id" class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kampus Mitra</label>
                    <select name="kampus_id" id="kampus_id" onchange="this.form.submit()" class="w-full p-2 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-[#1D9E75] focus:border-[#1D9E75] focus:outline-none transition-all">
                        <option value="">Semua Kampus Mitra</option>
                        @foreach($campuses as $campus)
                            <option value="{{ $campus->id }}" {{ $kampusId == $campus->id ? 'selected' : '' }}>
                                {{ $campus->nama_kampus }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if($kampusId)
                    <div class="pt-5">
                        <a href="{{ route('admin.pendaftar.index') }}" class="text-xs text-rose-600 hover:text-rose-800 font-bold flex items-center gap-1">
                            <i class="fa-solid fa-circle-xmark"></i> Bersihkan Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Scholarship Applicant Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($beasiswas as $beasiswa)
                @php
                    $percentage = $beasiswa->kuota > 0 ? ($beasiswa->pendaftar_count / $beasiswa->kuota) * 100 : 0;
                    $percentage = min(100, round($percentage));
                    $isDanger = $percentage >= 80;
                    $barColor = $isDanger ? 'bg-rose-500' : 'bg-[#1D9E75]';
                @endphp
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md hover:-translate-y-0.5 transition-all">
                    <div>
                        <!-- Thumbnail Header -->
                        <div class="relative h-40 bg-slate-100 overflow-hidden">
                            @if($beasiswa->thumbnail)
                                <img src="{{ Storage::url($beasiswa->thumbnail) }}" alt="{{ $beasiswa->nama_beasiswa }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-tr from-[#1a3d6e]/5 to-[#1D9E75]/5 text-[#1D9E75]">
                                    <i class="fa-solid fa-graduation-cap text-3xl"></i>
                                    <span class="text-[9px] font-bold text-slate-400 mt-2">MGBK BEASISWA</span>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="px-2 py-1 rounded text-[8px] font-bold bg-[#1a3d6e] text-white uppercase tracking-wider shadow-sm">
                                    {{ ucwords(str_replace('_', ' ', $beasiswa->jenis)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 space-y-4">
                            <div class="space-y-1">
                                <h3 class="text-xs font-bold text-slate-800 line-clamp-1" title="{{ $beasiswa->nama_beasiswa }}">
                                    {{ $beasiswa->nama_beasiswa }}
                                </h3>
                                <p class="text-[10px] text-slate-400 font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-university text-[9px]"></i> {{ $beasiswa->kampusMitra->nama_kampus ?? 'N/A' }}
                                </p>
                            </div>

                            <!-- Progress & Stats -->
                            <div class="space-y-2 pt-2 border-t border-slate-50">
                                <div class="flex items-center justify-between text-[10px] font-bold">
                                    <span class="text-slate-400">Kuota Terisi</span>
                                    <span class="{{ $isDanger ? 'text-rose-600' : 'text-slate-700' }}">
                                        {{ $beasiswa->pendaftar_count }} / {{ $beasiswa->kuota }} Kuota
                                    </span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="{{ $barColor }} h-full rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                                </div>
                                @if($isDanger)
                                    <div class="flex items-center gap-1 text-[9px] text-rose-500 font-semibold pt-1">
                                        <i class="fa-solid fa-circle-exclamation text-[8px]"></i> Kuota beasiswa sudah hampir penuh (>80%)!
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="p-5 bg-slate-50/50 border-t border-slate-50">
                        <a href="{{ route('admin.pendaftar.show', $beasiswa->id) }}" class="w-full inline-flex items-center justify-center gap-2 bg-[#1a3d6e] hover:bg-[#122b4f] text-white py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer shadow-sm">
                            Lihat Pendaftar <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-100 shadow-sm">
                    <div class="max-w-[240px] mx-auto space-y-3">
                        <div class="h-12 w-12 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto border border-slate-100 text-lg">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Tidak ada beasiswa aktif</h4>
                            <p class="text-xs text-slate-400 mt-1">Silakan tambahkan atau ubah status beasiswa menjadi aktif terlebih dahulu.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
