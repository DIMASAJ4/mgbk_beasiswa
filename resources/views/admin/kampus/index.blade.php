<x-app-layout>
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="heading-font text-3xl font-extrabold text-[#1a3d6e] tracking-tight">Kelola Kampus Mitra</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-semibold mt-1">Daftar lengkap institusi perguruan tinggi mitra penyedia program beasiswa.</p>
            </div>
            
            <div>
                <a href="{{ route('admin.kampus.create') }}" class="px-5 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all flex items-center gap-2 shadow-md shadow-[#1D9E75]/10 cursor-pointer">
                    <i class="fa-solid fa-plus text-[10px]"></i> Tambah Kampus
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

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6">
            
            {{-- Filter Bar Form --}}
            <form method="GET" action="{{ route('admin.kampus.index') }}" class="flex items-center gap-4 mb-6">
                <!-- Search bar -->
                <div class="relative w-72">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kampus..." 
                           class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 shadow-sm transition-all">
                </div>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-[#1a3d6e] hover:bg-[#153158] text-white text-xs font-bold transition-all shadow-sm cursor-pointer">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.kampus.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-550 text-xs font-bold transition-colors shadow-sm">
                        Reset
                    </a>
                @endif
            </form>

            {{-- Table Grid --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                            <th class="pb-3 pr-4 text-center w-12">No</th>
                            <th class="pb-3 px-4">Nama Kampus</th>
                            <th class="pb-3 px-4">Website</th>
                            <th class="pb-3 px-4 text-center">Jumlah Beasiswa</th>
                            <th class="pb-3 px-4">Status</th>
                            <th class="pb-3 pl-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-xs">
                        @forelse ($kampuses as $index => $k)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <!-- No -->
                            <td class="py-4 pr-4 text-center text-slate-450 font-bold">
                                {{ $kampuses->firstItem() + $index }}
                            </td>
                            
                            <!-- Campus Logo & Name -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center shrink-0 overflow-hidden text-[#1a3d6e] text-lg font-black shadow-sm">
                                        @if($k->logo)
                                            <img src="{{ asset('storage/' . $k->logo) }}" class="h-full w-full object-cover" alt="">
                                        @else
                                            {{ substr($k->nama_kampus, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-[#1a3d6e] group-hover:text-[#1D9E75] transition-colors leading-snug">
                                            {{ $k->nama_kampus }}
                                        </div>
                                        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">
                                            {{ $k->kontak }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Website -->
                            <td class="py-4 px-4 font-bold text-[#1D9E75]">
                                @if($k->website)
                                    <a href="{{ $k->website }}" target="_blank" class="hover:underline flex items-center gap-1">
                                        <i class="fa-solid fa-earth-americas text-[10px]"></i> Kunjungi Situs
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Beasiswa Count -->
                            <td class="py-4 px-4 text-center font-bold text-slate-500">
                                {{ $k->beasiswas_count }} Program
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-4">
                                <x-badge :variant="$k->is_active ? 'aktif' : 'tutup'" :value="$k->is_active ? 'Aktif' : 'Non-Aktif'" />
                            </td>

                            <!-- Actions -->
                            <td class="py-4 pl-4 text-right text-base shrink-0">
                                <div class="flex items-center justify-end gap-2.5">
                                    <a href="{{ route('admin.kampus.edit', $k->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors cursor-pointer">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.kampus.destroy', $k->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra {{ $k->nama_kampus }}? Semua beasiswa terafiliasi akan terhapus.')" 
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
                            <td colspan="6" class="py-12 text-center text-slate-450 font-medium">
                                <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 text-xl mx-auto mb-3">
                                    <i class="fa-regular fa-folder-open"></i>
                                </div>
                                Belum ada data kampus mitra yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-6 pt-6 border-t border-slate-100">
                {{ $kampuses->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
