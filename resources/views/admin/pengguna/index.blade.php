<x-app-layout>
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="heading-font text-3xl font-extrabold text-[#1a3d6e] tracking-tight">Kelola Pengguna</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-semibold mt-1">Daftar wewenang serta hak akses untuk pembimbing Guru BK dan akun Siswa.</p>
            </div>
            
            <div>
                @if($tab === 'siswa')
                    <a href="{{ route('admin.pengguna.create.siswa') }}" class="px-5 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all flex items-center gap-2 shadow-md shadow-[#1D9E75]/10 cursor-pointer">
                        <i class="fa-solid fa-user-plus text-[10px]"></i> Tambah Akun Siswa
                    </a>
                @else
                    <a href="{{ route('admin.pengguna.create.guru') }}" class="px-5 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all flex items-center gap-2 shadow-md shadow-[#1D9E75]/10 cursor-pointer">
                        <i class="fa-solid fa-user-plus text-[10px]"></i> Tambah Akun Guru BK
                    </a>
                @endif
            </div>
        </div>

        {{-- Success Banner Alert --}}
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-semibold flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-base text-[#1D9E75]"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Main Table Container --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6">
            
            {{-- Tabs Selection --}}
            <div class="flex gap-6 border-b border-slate-100 mb-6">
                <a href="{{ route('admin.pengguna.index', ['tab' => 'guru']) }}" 
                   class="pb-3 text-sm font-bold border-b-2 px-2 transition-all {{ $tab === 'guru' ? 'border-[#1D9E75] text-[#1D9E75]' : 'border-transparent text-slate-400 hover:text-[#1a3d6e]' }}">
                    <i class="fa-solid fa-chalkboard-user mr-1.5 text-xs"></i> Guru BK Portal
                </a>
                <a href="{{ route('admin.pengguna.index', ['tab' => 'siswa']) }}" 
                   class="pb-3 text-sm font-bold border-b-2 px-2 transition-all {{ $tab === 'siswa' ? 'border-[#1D9E75] text-[#1D9E75]' : 'border-transparent text-slate-400 hover:text-[#1a3d6e]' }}">
                    <i class="fa-solid fa-user-graduate mr-1.5 text-xs"></i> Siswa Portal
                </a>
            </div>

            {{-- Filter & Search Form --}}
            <form method="GET" action="{{ route('admin.pengguna.index') }}" class="flex items-center gap-4 mb-6">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <!-- Search bar -->
                <div class="relative w-80">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau identitas..." 
                           class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 shadow-sm transition-all">
                </div>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-[#1a3d6e] hover:bg-[#153158] text-white text-xs font-bold transition-all shadow-sm cursor-pointer">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.pengguna.index', ['tab' => $tab]) }}" class="px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-550 text-xs font-bold transition-colors shadow-sm">
                        Reset
                    </a>
                @endif
            </form>

            {{-- Table Content --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    
                    {{-- Guru BK Tab Table Header --}}
                    @if($tab === 'guru')
                        <thead>
                            <tr class="border-b border-slate-100 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                                <th class="pb-3 pr-4 text-center w-12">No</th>
                                <th class="pb-3 px-4">Nama Pengajar</th>
                                <th class="pb-3 px-4">NIP</th>
                                <th class="pb-3 px-4">Sekolah Induk</th>
                                <th class="pb-3 px-4 text-center">Jumlah Siswa Binaan</th>
                                <th class="pb-3 pl-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-xs">
                            @forelse ($users as $index => $u)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="py-4 pr-4 text-center text-slate-450 font-bold">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-extrabold text-[#1a3d6e] group-hover:text-[#1D9E75] transition-colors leading-snug">
                                        {{ $u->name }}
                                    </div>
                                    <div class="text-[9px] text-slate-400 font-bold mt-0.5">{{ $u->email }}</div>
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-600">
                                    {{ $u->nip ?? '-' }}
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-500">
                                    {{ $u->sekolah ?? '-' }}
                                </td>
                                <td class="py-4 px-4 text-center font-bold text-[#1D9E75]">
                                    {{ $u->jumlah_siswa }} Siswa
                                </td>
                                <td class="py-4 pl-4 text-right shrink-0">
                                    <div class="flex items-center justify-end gap-3.5">
                                        <form action="{{ route('admin.pengguna.reset', $u->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin me-reset kata sandi akun {{ $u->name }} ke default password?')" 
                                              class="inline-block">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 hover:border-blue-200 text-blue-600 text-[10px] font-bold transition-all cursor-pointer">
                                                <i class="fa-solid fa-key mr-1"></i> Reset Sandi
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.pengguna.destroy', $u->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}?')" 
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
                                <td colspan="6" class="py-12 text-center text-slate-455 font-medium">
                                    <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 text-xl mx-auto mb-3">
                                        <i class="fa-regular fa-folder-open"></i>
                                    </div>
                                    Belum ada data pengajar Guru BK yang cocok dengan pencarian Anda.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    
                    {{-- Siswa Tab Table Header --}}
                    @else
                        <thead>
                            <tr class="border-b border-slate-100 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                                <th class="pb-3 pr-4 text-center w-12">No</th>
                                <th class="pb-3 px-4">Nama Siswa</th>
                                <th class="pb-3 px-4">NISN</th>
                                <th class="pb-3 px-4">Sekolah</th>
                                <th class="pb-3 px-4">Kelas</th>
                                <th class="pb-3 px-4">Status Profil</th>
                                <th class="pb-3 pl-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-xs">
                            @forelse ($users as $index => $u)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="py-4 pr-4 text-center text-slate-455 font-bold">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-extrabold text-[#1a3d6e] group-hover:text-[#1D9E75] transition-colors leading-snug">
                                        {{ $u->name }}
                                    </div>
                                    <div class="text-[9px] text-slate-400 font-bold mt-0.5">{{ $u->email }}</div>
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-600">
                                    {{ $u->nisn ?? '-' }}
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-500">
                                    {{ $u->sekolah ?? '-' }}
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-500">
                                    {{ $u->kelas ?? '-' }}
                                </td>
                                <td class="py-4 px-4">
                                    @if($u->dataSiswa && $u->dataSiswa->is_verified)
                                        <x-badge variant="terverifikasi" value="Terverifikasi" />
                                    @else
                                        <x-badge variant="menunggu" value="Belum Terverifikasi" />
                                    @endif
                                </td>
                                <td class="py-4 pl-4 text-right shrink-0">
                                    <div class="flex items-center justify-end gap-3.5">
                                        <form action="{{ route('admin.pengguna.reset', $u->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin me-reset kata sandi akun {{ $u->name }} ke default password?')" 
                                              class="inline-block">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 hover:border-blue-200 text-blue-600 text-[10px] font-bold transition-all cursor-pointer">
                                                <i class="fa-solid fa-key mr-1"></i> Reset Sandi
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.pengguna.destroy', $u->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}?')" 
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
                                    Belum ada data siswa yang cocok dengan pencarian Anda.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    @endif
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-6 pt-6 border-t border-slate-100">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
