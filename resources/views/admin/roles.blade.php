<x-app-layout>
    <div class="space-y-8">
        {{-- Flash Alert Banners --}}
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-semibold flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-base text-[#1D9E75]"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-semibold flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-base"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid lg:grid-cols-12 gap-8">
            <!-- Left: Users List and Role Changer -->
            <div class="lg:col-span-8">
                <x-table title="Daftar Pengguna Sistem" subtitle="Atur hak akses dan wewenang pengguna portal MGBK Beasiswa.">
                    <x-slot name="action">
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-500">
                            {{ count($users) }} Pengguna Terdaftar
                        </span>
                    </x-slot>

                    <x-slot name="thead">
                        <th class="pb-3 pr-4">Pengguna</th>
                        <th class="pb-3 px-4">Peran Saat Ini</th>
                        <th class="pb-3 pl-4 text-right">Ubah Peran</th>
                    </x-slot>

                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- User Bio -->
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-[#1a3d6e]/10 text-[#1a3d6e] flex items-center justify-center font-black">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-[#1a3d6e] text-sm">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-400 font-medium">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Current Role Badge -->
                            <td class="py-4 px-4">
                                @php
                                    $roleName = $user->roles->pluck('name')->first() ?? 'Siswa';
                                @endphp
                                
                                @if ($roleName === 'Admin')
                                    <span class="px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-100 text-indigo-700 text-[10px] font-bold uppercase tracking-wider">
                                        Admin
                                    </span>
                                @elseif ($roleName === 'Guru BK')
                                    <span class="px-2.5 py-1 rounded-lg bg-[#e8f4f0] border border-[#1D9E75]/20 text-[#1D9E75] text-[10px] font-bold uppercase tracking-wider">
                                        Guru BK
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 text-[10px] font-bold uppercase tracking-wider">
                                        Siswa
                                    </span>
                                @endif
                            </td>

                            <!-- Action: Quick form to change role -->
                            <td class="py-4 pl-4 text-right">
                                <form method="POST" action="{{ route('admin.roles.assign') }}" class="inline-flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    
                                    <select name="role_name" class="py-1.5 pl-3 pr-8 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 font-semibold cursor-pointer shadow-sm">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ $roleName === $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all shadow-md shadow-[#1D9E75]/10 cursor-pointer">
                                        Simpan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </div>

            <!-- Right: Role Description and Guide -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <h4 class="text-base font-bold text-[#1a3d6e] heading-font mb-4">Panduan Hak Akses</h4>
                    <p class="text-xs text-slate-400 font-semibold leading-relaxed mb-6">Berikut deskripsi kewenangan masing-masing peran di portal.</p>
                    
                    <div class="space-y-4">
                        <!-- Admin Info -->
                        <div class="p-3.5 rounded-xl bg-indigo-50/50 border border-indigo-100/50">
                            <span class="text-[10px] text-indigo-600 font-bold uppercase tracking-wider">Admin</span>
                            <p class="text-[11px] text-slate-500 font-semibold leading-normal mt-1">Mengelola seluruh sistem, menerbitkan program beasiswa, dan menetapkan wewenang user.</p>
                        </div>

                        <!-- Guru BK Info -->
                        <div class="p-3.5 rounded-xl bg-[#e8f4f0]/50 border border-[#1D9E75]/25">
                            <span class="text-[10px] text-[#1D9E75] font-bold uppercase tracking-wider">Guru BK</span>
                            <p class="text-[11px] text-slate-500 font-semibold leading-normal mt-1">Membimbing siswa, memverifikasi kelayakan raport akademik, dan menerbitkan rekomendasi beasiswa resmi.</p>
                        </div>

                        <!-- Siswa Info -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Siswa</span>
                            <p class="text-[11px] text-slate-500 font-semibold leading-normal mt-1">Melakukan pendaftaran program beasiswa, melengkapi profil akademik, dan mengunggah berkas portofolio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
