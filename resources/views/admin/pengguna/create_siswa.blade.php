<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Navigation back --}}
        <div>
            <a href="{{ route('admin.pengguna.index', ['tab' => 'siswa']) }}" class="text-[#1D9E75] hover:text-[#1a3d6e] text-xs font-bold flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Siswa
            </a>
        </div>

        {{-- Form Container --}}
        <div class="bg-white rounded-3xl p-8 relative overflow-hidden border border-slate-100 shadow-xl shadow-slate-100/10">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1a3d6e]/5 to-[#1D9E75]/5 pointer-events-none"></div>

            <div class="relative z-10 mb-8 border-b border-slate-100 pb-6">
                <h2 class="heading-font text-2xl font-extrabold text-[#1a3d6e] tracking-tight">Daftarkan Akun Siswa</h2>
                <p class="text-slate-500 text-xs mt-1.5">Buat akun profil Siswa Binaan baru untuk portal beasiswa MGBK.</p>
            </div>

            <form action="{{ route('admin.pengguna.store.siswa') }}" method="POST" class="relative z-10 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Siswa</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="Contoh: Ahmad Fauzi"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('name') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- NISN --}}
                    <div>
                        <label for="nisn" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NISN Siswa</label>
                        <input type="text" id="nisn" name="nisn" required value="{{ old('nisn') }}" placeholder="Contoh: 0054321678"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('nisn') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Email Siswa</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="Contoh: ahmad@siswa.mail"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('email') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <label for="kelas" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kelas</label>
                        <input type="text" id="kelas" name="kelas" required value="{{ old('kelas') }}" placeholder="Contoh: XII IPA 2"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('kelas') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Sekolah --}}
                    <div>
                        <label for="sekolah" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sekolah Asal</label>
                        <select id="sekolah" name="sekolah" required
                                class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 transition-all shadow-sm">
                            <option value="" disabled selected>Pilih Sekolah Binaan...</option>
                            @foreach($sekolahs as $sekolah)
                                <option value="{{ $sekolah }}" {{ old('sekolah') == $sekolah ? 'selected' : '' }}>{{ $sekolah }}</option>
                            @endforeach
                        </select>
                        @error('sekolah') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kata Sandi Akun</label>
                        <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter..."
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('password') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.pengguna.index', ['tab' => 'siswa']) }}" class="px-5 py-3 rounded-xl border border-slate-200 hover:border-slate-350 bg-white text-slate-550 text-xs font-bold transition-all cursor-pointer">
                        Batalkan
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all shadow-lg shadow-[#1D9E75]/10 cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Daftarkan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
