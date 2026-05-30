<x-app-layout>
    <div class="max-w-4xl mx-auto">
        {{-- Navigation back --}}
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-[#1D9E75] hover:text-[#1a3d6e] text-xs font-bold flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-3xl p-8 relative overflow-hidden border border-slate-100 shadow-xl shadow-slate-100/10">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1a3d6e]/5 to-[#1D9E75]/5 pointer-events-none"></div>

            <div class="relative z-10 mb-8 border-b border-slate-100 pb-6">
                <h2 class="heading-font text-2xl font-extrabold text-[#1a3d6e] tracking-tight">Input Data Profil Siswa</h2>
                <p class="text-slate-500 text-xs mt-1.5">Isi detail data akademik dan minat siswa untuk menghasilkan rekomendasi beasiswa berbasis kecocokan otomatis.</p>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-[#e8f4f0] border border-[#1D9E75]/25 text-[#1D9E75] text-xs font-semibold flex items-center gap-2.5 shadow-sm">
                <i class="fa-solid fa-circle-check text-base"></i>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-[11px] text-[#1D9E75]/80 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <form action="{{ route('guru.input-siswa.store') }}" method="POST" class="relative z-10 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Siswa</label>
                        <input type="text" id="name" name="name" required placeholder="Contoh: Ahmad Fauzi"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('name') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Email</label>
                        <input type="email" id="email" name="email" required placeholder="Contoh: ahmad@siswa.mail"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('email') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- NISN --}}
                    <div>
                        <label for="nisn" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NISN</label>
                        <input type="text" id="nisn" name="nisn" required placeholder="Contoh: 0054321678"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('nisn') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label for="no_hp" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Handphone</label>
                        <input type="text" id="no_hp" name="no_hp" required placeholder="Contoh: 081234567890"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('no_hp') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <label for="kelas" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kelas</label>
                        <input type="text" id="kelas" name="kelas" required placeholder="Contoh: XII IPA 2"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('kelas') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Sekolah --}}
                    <div>
                        <label for="sekolah" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sekolah Asal</label>
                        <input type="text" id="sekolah" name="sekolah" required value="{{ Auth::user()->sekolah ?? 'SMA Negeri 1 Jakarta' }}"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 transition-all shadow-sm">
                        @error('sekolah') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nilai Rata-rata --}}
                    <div>
                        <label for="nilai_rata" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nilai Rata-Rata Rapor</label>
                        <input type="number" step="0.01" min="0" max="100" id="nilai_rata" name="nilai_rata" required placeholder="Contoh: 88.50"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('nilai_rata') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kondisi Ekonomi --}}
                    <div>
                        <label for="kondisi_ekonomi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kondisi Ekonomi</label>
                        <select id="kondisi_ekonomi" name="kondisi_ekonomi" required
                                class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-750 transition-all shadow-sm">
                            <option value="" disabled selected>Pilih kondisi ekonomi...</option>
                            <option value="mampu">Mampu (Ekonomi Stabil)</option>
                            <option value="kurang_mampu">Kurang Mampu (Butuh Dukungan)</option>
                            <option value="tidak_mampu">Tidak Mampu (Prioritas Beasiswa)</option>
                        </select>
                        @error('kondisi_ekonomi') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Minat Jurusan (Checkboxes) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Minat Jurusan (Pilih maksimal 3)</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach (['Seni Rupa', 'Hukum', 'Teknik Informatika', 'Kedokteran', 'Psikologi', 'Manajemen'] as $jurusan)
                        <label class="relative flex items-center gap-3 p-4 rounded-2xl bg-white border border-slate-150 hover:border-[#1D9E75]/40 hover:bg-[#e8f4f0]/20 cursor-pointer select-none transition-all group shadow-sm">
                            <input type="checkbox" name="minat_jurusan[]" value="{{ $jurusan }}" class="h-4.5 w-4.5 rounded border-slate-350 text-[#1D9E75] bg-white focus:ring-[#1D9E75] focus:ring-offset-0 cursor-pointer">
                            <span class="text-xs text-slate-500 group-hover:text-slate-800 transition-colors font-bold">{{ $jurusan }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('minat_jurusan') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                {{-- Prestasi --}}
                <div>
                    <label for="prestasi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Prestasi Akademik / Non-Akademik</label>
                    <textarea id="prestasi" name="prestasi" rows="4" placeholder="Sebutkan prestasi (misal: Juara 1 Lomba Debat Nasional, Sertifikat Olimpiade Matematika, dll.)"
                              class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm"></textarea>
                    @error('prestasi') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard') }}" class="px-5 py-3 rounded-xl border border-slate-200 hover:border-slate-350 bg-white text-slate-550 text-xs font-bold transition-all cursor-pointer">
                        Batalkan
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all shadow-lg shadow-[#1D9E75]/10 cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Simpan Data Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
