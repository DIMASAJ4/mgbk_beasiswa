<x-app-layout>
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="heading-font text-3xl font-extrabold text-[#1a3d6e] tracking-tight">Data Siswa Binaan</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-semibold mt-1">
                    Sekolah: <span class="text-[#1D9E75] font-bold">{{ Auth::user()->sekolah ?? 'SMA Negeri 1 Jakarta' }}</span>
                </p>
            </div>
            
            <div>
                <a href="{{ route('guru.siswa.create') }}" class="px-5 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all flex items-center gap-2 shadow-md shadow-[#1D9E75]/10 cursor-pointer">
                    <i class="fa-solid fa-user-plus text-[10px]"></i> Input Siswa Baru
                </a>
            </div>
        </div>

        {{-- Success Banner Alert --}}
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-semibold flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-base text-[#1D9E75]"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Table Grid Wrapper --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6">
            
            {{-- Filter Bar Form --}}
            <form method="GET" action="{{ route('guru.siswa.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 mb-6">
                <!-- Search bar -->
                <div class="sm:col-span-6 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NISN, atau kelas..." 
                           class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 shadow-sm transition-all">
                </div>

                <!-- Recommendation Status Filter -->
                <div class="sm:col-span-4">
                    <select name="status_rekomendasi" class="w-full px-3 py-2.5 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 shadow-sm">
                        <option value="">Semua Status Rekomendasi</option>
                        <option value="rekomendasi" {{ request('status_rekomendasi') === 'rekomendasi' ? 'selected' : '' }}>Sudah Direkomendasikan</option>
                        <option value="belum" {{ request('status_rekomendasi') === 'belum' ? 'selected' : '' }}>Belum Direkomendasikan</option>
                    </select>
                </div>

                <!-- Action Button -->
                <div class="sm:col-span-2 flex gap-2">
                    <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#1a3d6e] hover:bg-[#153158] text-white text-xs font-bold transition-all shadow-sm cursor-pointer flex items-center justify-center gap-1.5">
                        Cari
                    </button>
                    @if(request()->anyFilled(['search', 'status_rekomendasi']))
                        <a href="{{ route('guru.siswa.index') }}" class="py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-500 hover:text-slate-750 transition-colors shadow-sm flex items-center justify-center">
                            <i class="fa-solid fa-rotate-left text-[11px]"></i>
                        </a>
                    @endif
                </div>
            </form>

            {{-- Table Grid --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                            <th class="pb-3 pr-4 text-center w-12">No</th>
                            <th class="pb-3 px-4">Nama Siswa</th>
                            <th class="pb-3 px-4">NISN</th>
                            <th class="pb-3 px-4 text-center">Nilai Rapor</th>
                            <th class="pb-3 px-4">Minat Jurusan</th>
                            <th class="pb-3 px-4">Rekomendasi</th>
                            <th class="pb-3 pl-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-xs">
                        @forelse ($siswas as $index => $s)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <!-- No -->
                            <td class="py-4 pr-4 text-center text-slate-455 font-bold">
                                {{ $siswas->firstItem() + $index }}
                            </td>
                            
                            <!-- Student Info -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-full bg-[#1a3d6e]/10 border border-[#1a3d6e]/20 flex items-center justify-center text-[#1a3d6e] font-black text-sm shadow-sm">
                                        {{ substr($s->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-[#1a3d6e] group-hover:text-[#1D9E75] transition-colors leading-snug">
                                            {{ $s->name }}
                                        </div>
                                        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">
                                            Kelas: {{ $s->kelas ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- NISN -->
                            <td class="py-4 px-4 font-bold text-slate-600">
                                {{ $s->nisn ?? '-' }}
                            </td>

                            <!-- GPA -->
                            <td class="py-4 px-4 text-center font-extrabold text-slate-700">
                                {{ $s->dataSiswa ? number_format($s->dataSiswa->nilai_rata, 2) : '0.00' }}
                            </td>

                            <!-- Interests -->
                            <td class="py-4 px-4 font-semibold text-slate-500">
                                @if($s->dataSiswa && is_array($s->dataSiswa->minat_jurusan) && count($s->dataSiswa->minat_jurusan) > 0)
                                    {{ implode(', ', $s->dataSiswa->minat_jurusan) }}
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Recommendation Status Badge -->
                            <td class="py-4 px-4">
                                @if($s->dataSiswa && $s->dataSiswa->rekomendasis->count() > 0)
                                    <x-badge variant="terverifikasi" value="Direkomendasikan" />
                                @else
                                    <x-badge variant="menunggu" value="Belum Diproses" />
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-4 pl-4 text-right shrink-0">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('guru.siswa.proses', $s->id) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-250 hover:bg-amber-500 hover:text-white hover:border-transparent text-amber-700 text-[10px] font-bold transition-all cursor-pointer shadow-sm">
                                        <i class="fa-solid fa-graduation-cap mr-1"></i> Proses Rekomendasi
                                    </a>
                                    <a href="{{ route('guru.siswa.edit', $s->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors text-base cursor-pointer">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('guru.siswa.destroy', $s->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ $s->name }}?')" 
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 transition-colors cursor-pointer bg-transparent border-0 p-0 text-base">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-455 font-medium">
                                <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 text-xl mx-auto mb-3">
                                    <i class="fa-regular fa-folder-open"></i>
                                </div>
                                Belum ada siswa binaan terdaftar untuk kriteria Anda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-6 pt-6 border-t border-slate-100">
                {{ $siswas->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
