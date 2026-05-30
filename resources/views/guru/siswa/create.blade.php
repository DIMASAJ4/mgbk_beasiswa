<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8">
        
        {{-- Navigation back --}}
        <div>
            <a href="{{ route('guru.siswa.index') }}" class="text-[#1D9E75] hover:text-[#1a3d6e] text-xs font-bold flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Siswa
            </a>
        </div>

        {{-- Main Form Container --}}
        <div class="bg-white rounded-3xl p-8 relative overflow-hidden border border-slate-100 shadow-xl shadow-slate-100/10">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1a3d6e]/5 to-[#1D9E75]/5 pointer-events-none"></div>

            <div class="relative z-10 mb-8 border-b border-slate-100 pb-6">
                <h2 class="heading-font text-2xl font-extrabold text-[#1a3d6e] tracking-tight">Input Profil & Evaluasi Rekomendasi</h2>
                <p class="text-slate-500 text-xs mt-1.5">Masukkan data akademik dan sosial ekonomi siswa binaan untuk memicu perhitungan kecocokan beasiswa otomatis.</p>
            </div>

            @if(session('success') && !isset($recommendations))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-semibold flex items-center gap-2.5 shadow-sm">
                <i class="fa-solid fa-circle-check text-base text-[#1D9E75]"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('guru.siswa.create.store') }}" method="POST" class="relative z-10 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Left Column: Personal Data --}}
                    <div class="space-y-5">
                        <h3 class="heading-font text-sm font-extrabold text-[#1a3d6e] uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">A. Informasi Pribadi</h3>
                        
                        {{-- Nama Lengkap --}}
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Siswa</label>
                            <input type="text" id="name" name="name" required value="{{ old('name', $student->name ?? '') }}" placeholder="Contoh: Ahmad Fauzi"
                                   {{ isset($student) ? 'disabled' : '' }}
                                   class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-750 placeholder-slate-400 transition-all shadow-sm disabled:bg-slate-50 disabled:text-slate-400">
                        </div>

                        {{-- Email (Only for registration) --}}
                        @if(!isset($student))
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Email Siswa</label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="Contoh: ahmad@siswa.mail"
                                   class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-750 placeholder-slate-400 transition-all shadow-sm">
                            @error('email') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>
                        @endif

                        {{-- NISN --}}
                        <div>
                            <label for="nisn" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NISN</label>
                            <input type="text" id="nisn" name="nisn" required value="{{ old('nisn', $student->nisn ?? '') }}" placeholder="Contoh: 0054321678"
                                   {{ isset($student) ? 'disabled' : '' }}
                                   class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-750 placeholder-slate-400 transition-all shadow-sm disabled:bg-slate-50 disabled:text-slate-400">
                            @error('nisn') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        {{-- Asal Sekolah --}}
                        <div>
                            <label for="sekolah" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Asal Sekolah</label>
                            <input type="text" id="sekolah" name="sekolah" disabled value="{{ Auth::user()->sekolah ?? 'SMA Negeri 1 Jakarta' }}"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-400 shadow-sm">
                        </div>

                        {{-- Kelas & No HP --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="kelas" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kelas</label>
                                <input type="text" id="kelas" name="kelas" required value="{{ old('kelas', $student->kelas ?? '') }}" placeholder="Contoh: XII MIPA 1"
                                       {{ isset($student) ? 'disabled' : '' }}
                                       class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-750 placeholder-slate-400 transition-all shadow-sm disabled:bg-slate-50 disabled:text-slate-400">
                            </div>
                            <div>
                                <label for="no_hp" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. HP</label>
                                <input type="text" id="no_hp" name="no_hp" required value="{{ old('no_hp', $student->no_hp ?? '') }}" placeholder="Contoh: 0812345"
                                       {{ isset($student) ? 'disabled' : '' }}
                                       class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-750 placeholder-slate-400 transition-all shadow-sm disabled:bg-slate-50 disabled:text-slate-400">
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Academic & Interests --}}
                    <div class="space-y-5">
                        <h3 class="heading-font text-sm font-extrabold text-[#1a3d6e] uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">B. Detail Nilai & Minat</h3>
                        
                        {{-- Nilai Rata-rata & Kondisi Ekonomi --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="nilai_rata" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nilai Rata-Rata Rapor</label>
                                <input type="number" step="0.01" min="0" max="100" id="nilai_rata" name="nilai_rata" required value="{{ old('nilai_rata', $profile->nilai_rata ?? '') }}" placeholder="0 - 100"
                                       {{ isset($student) ? 'disabled' : '' }}
                                       class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-750 placeholder-slate-400 transition-all shadow-sm disabled:bg-slate-50 disabled:text-slate-400">
                                @error('nilai_rata') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="kondisi_ekonomi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kondisi Ekonomi</label>
                                <select id="kondisi_ekonomi" name="kondisi_ekonomi" required
                                        {{ isset($student) ? 'disabled' : '' }}
                                        class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-750 shadow-sm disabled:bg-slate-50 disabled:text-slate-400">
                                    <option value="" disabled selected>Pilih...</option>
                                    <option value="mampu" {{ old('kondisi_ekonomi', $profile->kondisi_ekonomi ?? '') === 'mampu' ? 'selected' : '' }}>Mampu</option>
                                    <option value="kurang_mampu" {{ old('kondisi_ekonomi', $profile->kondisi_ekonomi ?? '') === 'kurang_mampu' ? 'selected' : '' }}>Kurang Mampu</option>
                                    <option value="tidak_mampu" {{ old('kondisi_ekonomi', $profile->kondisi_ekonomi ?? '') === 'tidak_mampu' ? 'selected' : '' }}>Tidak Mampu</option>
                                </select>
                            </div>
                        </div>

                        {{-- Minat Jurusan Checkboxes --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Minat Bidang Keilmuan / Jurusan</label>
                            <div class="grid grid-cols-2 gap-2.5">
                                @php
                                    $savedInterests = old('minat_jurusan', $profile->minat_jurusan ?? []);
                                    $savedInterestsArray = is_array($savedInterests) ? $savedInterests : json_decode($savedInterests, true) ?? [];
                                @endphp
                                @foreach (['IPA', 'IPS', 'Teknik', 'Kedokteran', 'Hukum', 'Bisnis', 'Seni'] as $jurusan)
                                <label class="relative flex items-center gap-2.5 p-3 rounded-xl bg-white border border-slate-150 hover:border-[#1D9E75]/30 cursor-pointer select-none transition-all group shadow-sm">
                                    <input type="checkbox" name="minat_jurusan[]" value="{{ $jurusan }}" 
                                           {{ in_array($jurusan, $savedInterestsArray) ? 'checked' : '' }}
                                           {{ isset($student) ? 'disabled' : '' }}
                                           class="h-4 w-4 rounded border-slate-350 text-[#1D9E75] focus:ring-[#1D9E75] focus:ring-offset-0 bg-white cursor-pointer disabled:bg-slate-50">
                                    <span class="text-xs text-slate-500 group-hover:text-slate-800 transition-colors font-bold">{{ $jurusan }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Prestasi --}}
                        <div>
                            <label for="prestasi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Prestasi Akademik / Non-Akademik</label>
                            <textarea id="prestasi" name="prestasi" rows="2" placeholder="Sertifikat Olimpiade, Juara Lomba Esai, dll..."
                                      {{ isset($student) ? 'disabled' : '' }}
                                      class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm disabled:bg-slate-50 disabled:text-slate-400">{{ old('prestasi', $profile->prestasi ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Proses Button (Only shown if we are creating a new student or checking results) --}}
                @if(!isset($recommendations))
                <div class="pt-6 border-t border-slate-100">
                    <button type="submit" class="w-full py-4 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-sm transition-all shadow-md shadow-amber-500/10 flex items-center justify-center gap-2 cursor-pointer uppercase tracking-wider">
                        <i class="fa-solid fa-graduation-cap text-base"></i> Proses Evaluasi Rekomendasi
                    </button>
                </div>
                @endif
            </form>
        </div>

        {{-- Results Section (Appears after submission or when editing process) --}}
        @if(isset($recommendations))
        <div class="space-y-6">
            <div class="border-b border-slate-200 pb-3">
                <h3 class="heading-font text-xl font-extrabold text-[#1a3d6e]">Hasil Kompatibilitas Beasiswa</h3>
                <p class="text-slate-500 text-xs mt-0.5">Daftar rekomendasi beasiswa yang diurutkan berdasarkan kecocokan profil siswa.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @forelse ($recommendations as $item)
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-md hover:shadow-lg transition-all flex flex-col justify-between">
                    <div>
                        {{-- Match header --}}
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-2.5 py-0.5 rounded text-[8px] font-extrabold uppercase tracking-wider bg-[#e8f4f0] text-[#1D9E75] border border-[#1D9E75]/15">
                                {{ str_replace('_', ' ', $item['beasiswa']->jenis) }}
                            </span>
                            <span class="text-sm font-black text-[#1D9E75]">{{ $item['match_score'] }}% Cocok</span>
                        </div>

                        {{-- Progress bar --}}
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden mb-5">
                            <div class="h-full bg-[#1D9E75] rounded-full transition-all duration-300" style="width: {{ $item['match_score'] }}%"></div>
                        </div>

                        {{-- Scholarship info --}}
                        <div class="mb-5">
                            <h4 class="font-extrabold text-[#1a3d6e] text-sm leading-tight mb-1">{{ $item['beasiswa']->nama_beasiswa }}</h4>
                            <p class="text-slate-450 text-[10px] font-bold uppercase tracking-wider">{{ $item['beasiswa']->kampusMitra->nama_kampus }}</p>
                        </div>

                        {{-- Met vs Unmet requirements checklist --}}
                        <div class="space-y-2 border-t border-slate-50 pt-4 mb-6">
                            <p class="text-[9px] text-slate-450 font-black uppercase tracking-wider mb-2">Kelayakan Kriteria</p>
                            
                            {{-- Met requirements --}}
                            @foreach ($item['met_requirements'] as $req)
                            <div class="flex items-start gap-2 text-[10px] text-slate-600 leading-tight">
                                <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 shrink-0"></i>
                                <span class="font-medium">{{ $req }}</span>
                            </div>
                            @endforeach

                            {{-- Unmet requirements --}}
                            @foreach ($item['unmet_requirements'] as $req)
                            <div class="flex items-start gap-2 text-[10px] text-slate-400 leading-tight">
                                <i class="fa-solid fa-circle-xmark text-slate-300 mt-0.5 shrink-0"></i>
                                <span class="font-medium line-through decoration-slate-300">{{ $req }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Form: Kirim ke Siswa --}}
                    <form action="{{ route('guru.siswa.proses.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="data_siswa_id" value="{{ $profile->id }}">
                        <input type="hidden" name="beasiswa_id" value="{{ $item['beasiswa']->id }}">
                        <input type="hidden" name="match_score" value="{{ $item['match_score'] }}">
                        
                        <button type="submit" class="w-full py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all shadow-md shadow-[#1D9E75]/10 flex items-center justify-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-paper-plane text-[10px]"></i> Kirim Rekomendasi ke Siswa
                        </button>
                    </form>
                </div>
                @empty
                <div class="md:col-span-2 bg-white rounded-2xl border border-slate-100 p-8 text-center">
                    <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 text-xl mx-auto mb-3">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>
                    Belum ada program beasiswa aktif untuk dievaluasi.
                </div>
                @endforelse
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
