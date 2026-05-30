<x-app-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div>
                <h1 class="heading-font text-2xl font-bold text-slate-800">Rekomendasi Beasiswa</h1>
                <p class="text-xs text-slate-500 mt-1">Kelola rekomendasi beasiswa langsung dari Admin ke Siswa pilihan.</p>
            </div>
            <div>
                <a href="{{ route('admin.rekomendasi.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#1D9E75] hover:bg-[#15803d] text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md shadow-[#1D9E75]/10 hover:shadow-lg hover:-translate-y-0.5 cursor-pointer">
                    <i class="fa-solid fa-plus text-xs"></i> Rekomendasikan Beasiswa
                </a>
            </div>
        </div>

        <!-- Alert Notification -->
        @if (session('success'))
            <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs font-semibold">
                <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs font-semibold">
                <i class="fa-solid fa-circle-xmark text-base text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Filter & Search Section -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.rekomendasi.index') }}" method="GET" class="w-full sm:w-80 relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama siswa atau beasiswa..." class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-[#1D9E75] focus:border-[#1D9E75] focus:outline-none transition-all placeholder:text-slate-400">
                @if($search)
                    <a href="{{ route('admin.rekomendasi.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-circle-xmark text-xs"></i>
                    </a>
                @endif
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-left">
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider text-center w-[60px]">No</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider">Siswa</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider">Sekolah</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider">Beasiswa</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider">Kampus</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider">Tanggal Rekomendasi</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider text-center">Pilihan Siswa</th>
                            <th class="py-4 px-6 text-slate-500 font-bold text-[11px] uppercase tracking-wider text-center w-[80px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 text-xs">
                        @forelse ($rekomendasis as $index => $rek)
                            <tr class="hover:bg-slate-50/55 transition-all">
                                <td class="py-4 px-6 text-center text-slate-400 font-semibold">
                                    {{ $rekomendasis->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-800">
                                    {{ $rek->dataSiswa->user->name ?? 'N/A' }}
                                    <div class="text-[10px] text-slate-400 font-medium mt-0.5">NISN: {{ $rek->dataSiswa->user->nisn ?? '-' }}</div>
                                </td>
                                <td class="py-4 px-6 text-slate-500 font-medium">
                                    {{ $rek->dataSiswa->user->sekolah ?? 'SMA Negeri Padangsidimpuan' }}
                                </td>
                                <td class="py-4 px-6 font-semibold text-slate-800">
                                    {{ $rek->beasiswa->nama_beasiswa ?? 'N/A' }}
                                    <div class="text-[10px] text-slate-400 font-semibold mt-0.5">Kecocokan: <span class="text-[#1D9E75]">{{ $rek->persentase_kecocokan }}%</span></div>
                                </td>
                                <td class="py-4 px-6 text-slate-500 font-medium">
                                    {{ $rek->beasiswa->kampusMitra->nama_kampus ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-6 text-slate-500 font-medium">
                                    {{ $rek->created_at ? $rek->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if ($rek->dipilih_siswa)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                                            <i class="fa-solid fa-circle-check text-[8px]"></i> Sudah Dipilih
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                            <i class="fa-regular fa-clock text-[8px]"></i> Belum Dipilih
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if (!$rek->dipilih_siswa)
                                        <form action="{{ route('admin.rekomendasi.destroy', $rek->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus rekomendasi ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-50 border border-rose-100 hover:bg-rose-100 hover:border-rose-200 text-rose-600 rounded-xl cursor-pointer transition-all shadow-sm">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button disabled title="Rekomendasi yang sudah dipilih tidak bisa dihapus" class="p-2 bg-slate-50 border border-slate-100 text-slate-300 rounded-xl cursor-not-allowed">
                                            <i class="fa-solid fa-lock text-sm"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center">
                                    <div class="max-w-[240px] mx-auto space-y-3">
                                        <div class="h-12 w-12 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto border border-slate-100 text-lg">
                                            <i class="fa-regular fa-folder-open"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800">Tidak ada rekomendasi</h4>
                                            <p class="text-xs text-slate-400 mt-1">
                                                {{ $search ? 'Hasil pencarian tidak ditemukan.' : 'Silakan klik tombol di atas untuk merekomendasikan beasiswa.' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Section -->
            @if ($rekomendasis->hasPages())
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $rekomendasis->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
