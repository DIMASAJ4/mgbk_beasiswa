<x-app-layout>
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="heading-font text-3xl font-extrabold text-[#1a3d6e] tracking-tight">Kelola Data Beasiswa</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-semibold mt-1">Daftar lengkap program beasiswa aktif dan draft dari seluruh mitra perguruan tinggi.</p>
            </div>
            
            <div>
                <a href="{{ route('admin.beasiswa.create') }}" class="px-5 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all flex items-center gap-2 shadow-md shadow-[#1D9E75]/10 cursor-pointer">
                    <i class="fa-solid fa-plus text-[10px]"></i> Tambah Beasiswa
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

        {{-- Filters & Table Card --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6">
            
            {{-- Filter Bar Form --}}
            <form method="GET" action="{{ route('admin.beasiswa.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 mb-6">
                <!-- Search bar -->
                <div class="sm:col-span-5 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama beasiswa..." 
                           class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 shadow-sm transition-all">
                </div>

                <!-- Campus Filter -->
                <div class="sm:col-span-3">
                    <select name="kampus_id" class="w-full px-3 py-2.5 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 shadow-sm">
                        <option value="">Semua Kampus Mitra</option>
                        @foreach ($kampusMitras as $kampus)
                            <option value="{{ $kampus->id }}" {{ request('kampus_id') == $kampus->id ? 'selected' : '' }}>
                                {{ $kampus->nama_kampus }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="sm:col-span-2">
                    <select name="status" class="w-full px-3 py-2.5 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 shadow-sm">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="tutup" {{ request('status') === 'tutup' ? 'selected' : '' }}>Tutup</option>
                    </select>
                </div>

                <!-- Submit / Reset Buttons -->
                <div class="sm:col-span-2 flex gap-2">
                    <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#1a3d6e] hover:bg-[#153158] text-white text-xs font-bold transition-all shadow-sm cursor-pointer flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-filter text-[10px]"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search', 'kampus_id', 'status']))
                        <a href="{{ route('admin.beasiswa.index') }}" class="py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-colors shadow-sm flex items-center justify-center">
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
                            <th class="pb-3 px-4">Nama Beasiswa</th>
                            <th class="pb-3 px-4">Kampus Mitra</th>
                            <th class="pb-3 px-4 text-center">Kuota</th>
                            <th class="pb-3 px-4">Batas Akhir</th>
                            <th class="pb-3 px-4">Status</th>
                            <th class="pb-3 pl-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-xs">
                        @forelse ($beasiswas as $index => $b)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <!-- No -->
                            <td class="py-4 pr-4 text-center text-slate-450 font-bold">
                                {{ $beasiswas->firstItem() + $index }}
                            </td>
                            
                            <!-- Scholarship Name -->
                            <td class="py-4 px-4">
                                <div class="font-extrabold text-[#1a3d6e] group-hover:text-[#1D9E75] transition-colors leading-snug">
                                    {{ $b->nama_beasiswa }}
                                </div>
                                <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">
                                    {{ str_replace('_', ' ', $b->jenis) }}
                                </div>
                            </td>

                            <!-- Campus -->
                            <td class="py-4 px-4 font-bold text-slate-650">
                                {{ $b->kampusMitra->nama_kampus }}
                            </td>

                            <!-- Quota -->
                            <td class="py-4 px-4 text-center font-bold text-slate-500">
                                {{ $b->kuota }} Siswa
                            </td>

                            <!-- Deadline -->
                            <td class="py-4 px-4 font-semibold text-slate-500">
                                <span class="{{ $b->deadline->isPast() ? 'text-rose-500 font-bold' : '' }}">
                                    {{ $b->deadline->format('d M Y') }}
                                </span>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-4">
                                <x-badge :variant="$b->status" />
                            </td>

                            <!-- Actions -->
                            <td class="py-4 pl-4 text-right text-base shrink-0">
                                <div class="flex items-center justify-end gap-2.5">
                                    <a href="{{ route('admin.beasiswa.edit', $b->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors cursor-pointer">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.beasiswa.destroy', $b->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus beasiswa {{ $b->nama_beasiswa }}? Tindakan ini tidak dapat dibatalkan.')" 
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 transition-colors cursor-pointer bg-transparent border-0 p-0">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-450 font-medium">
                                <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 text-xl mx-auto mb-3">
                                    <i class="fa-regular fa-folder-open"></i>
                                </div>
                                Belum ada data beasiswa yang cocok dengan kriteria pencarian Anda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-6 pt-6 border-t border-slate-100">
                {{ $beasiswas->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
