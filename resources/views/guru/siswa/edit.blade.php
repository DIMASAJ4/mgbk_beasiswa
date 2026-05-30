<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Navigation back --}}
        <div>
            <a href="{{ route('guru.siswa.index') }}" class="text-[#1D9E75] hover:text-[#1a3d6e] text-xs font-bold flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Siswa
            </a>
        </div>

        {{-- Form Container --}}
        <div class="bg-white rounded-3xl p-8 relative overflow-hidden border border-slate-100 shadow-xl shadow-slate-100/10">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1a3d6e]/5 to-[#1D9E75]/5 pointer-events-none"></div>

            <div class="relative z-10 mb-8 border-b border-slate-100 pb-6">
                <h2 class="heading-font text-2xl font-extrabold text-[#1a3d6e] tracking-tight">Edit Profil Akademik Siswa</h2>
                <p class="text-slate-500 text-xs mt-1.5">Perbarui rincian akademik, ekonomi, dan minat karir siswa binaan Anda.</p>
            </div>

            <form action="{{ route('guru.siswa.update', $siswa->id) }}" method="POST" class="relative z-10 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Siswa</label>
                        <input type="text" id="name" name="name" required value="{{ old('name', $siswa->name) }}" placeholder="Contoh: Ahmad Fauzi"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('name') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- NISN (Disabled) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-450 uppercase tracking-wider mb-2">NISN (Tidak dapat diubah)</label>
                        <input type="text" disabled value="{{ $siswa->nisn }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-400 shadow-sm">
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <label for="kelas" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kelas</label>
                        <input type="text" id="kelas" name="kelas" required value="{{ old('kelas', $siswa->kelas) }}" placeholder="Contoh: XII IPA 1"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('kelas') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label for="no_hp" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Handphone</label>
                        <input type="text" id="no_hp" name="no_hp" required value="{{ old('no_hp', $siswa->no_hp) }}" placeholder="Contoh: 0812345"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('no_hp') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nilai Rata-rata --}}
                    <div>
                        <label for="nilai_rata" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nilai Rata-Rata Rapor</label>
                        <input type="number" step="0.01" min="0" max="100" id="nilai_rata" name="nilai_rata" required value="{{ old('nilai_rata', $siswa->dataSiswa->nilai_rata ?? '') }}" placeholder="0 - 100"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('nilai_rata') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kondisi Ekonomi --}}
                    <div>
                        <label for="kondisi_ekonomi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kondisi Ekonomi</label>
                        <select id="kondisi_ekonomi" name="kondisi_ekonomi" required
                                class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-750 shadow-sm">
                            <option value="mampu" {{ old('kondisi_ekonomi', $siswa->dataSiswa->kondisi_ekonomi ?? '') === 'mampu' ? 'selected' : '' }}>Mampu</option>
                            <option value="kurang_mampu" {{ old('kondisi_ekonomi', $siswa->dataSiswa->kondisi_ekonomi ?? '') === 'kurang_mampu' ? 'selected' : '' }}>Kurang Mampu</option>
                            <option value="tidak_mampu" {{ old('kondisi_ekonomi', $siswa->dataSiswa->kondisi_ekonomi ?? '') === 'tidak_mampu' ? 'selected' : '' }}>Tidak Mampu</option>
                        </select>
                    </div>
                </div>

                {{-- Minat Jurusan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Minat Bidang Keilmuan / Jurusan</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @php
                            $savedInterests = old('minat_jurusan', $siswa->dataSiswa->minat_jurusan ?? []);
                            $savedInterestsArray = is_array($savedInterests) ? $savedInterests : json_decode($savedInterests, true) ?? [];
                        @endphp
                        @foreach (['IPA', 'IPS', 'Teknik', 'Kedokteran', 'Hukum', 'Bisnis', 'Seni'] as $jurusan)
                        <label class="relative flex items-center gap-2.5 p-3 rounded-xl bg-white border border-slate-150 hover:border-[#1D9E75]/30 cursor-pointer select-none transition-all group shadow-sm">
                            <input type="checkbox" name="minat_jurusan[]" value="{{ $jurusan }}" 
                                   {{ in_array($jurusan, $savedInterestsArray) ? 'checked' : '' }}
                                   class="h-4 w-4 rounded border-slate-350 text-[#1D9E75] focus:ring-[#1D9E75] focus:ring-offset-0 bg-white cursor-pointer">
                            <span class="text-xs text-slate-500 group-hover:text-slate-800 transition-colors font-bold">{{ $jurusan }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Prestasi --}}
                <div>
                    <label for="prestasi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Prestasi Akademik / Non-Akademik</label>
                    <textarea id="prestasi" name="prestasi" rows="4" placeholder="Tuliskan detail prestasi siswa..."
                              class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">{{ old('prestasi', $siswa->dataSiswa->prestasi) }}</textarea>
                </div>

                {{-- Form Actions --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('guru.siswa.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 hover:border-slate-350 bg-white text-slate-550 text-xs font-bold transition-all cursor-pointer">
                        Batalkan
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all shadow-lg shadow-[#1D9E75]/10 cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Perbarui Data Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
