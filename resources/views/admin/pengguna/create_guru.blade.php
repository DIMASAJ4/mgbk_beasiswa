<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Navigation back --}}
        <div>
            <a href="{{ route('admin.pengguna.index', ['tab' => 'guru']) }}" class="text-[#1D9E75] hover:text-[#1a3d6e] text-xs font-bold flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Guru BK
            </a>
        </div>

        {{-- Form Container --}}
        <div class="bg-white rounded-3xl p-8 relative overflow-hidden border border-slate-100 shadow-xl shadow-slate-100/10">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1a3d6e]/5 to-[#1D9E75]/5 pointer-events-none"></div>

            <div class="relative z-10 mb-8 border-b border-slate-100 pb-6">
                <h2 class="heading-font text-2xl font-extrabold text-[#1a3d6e] tracking-tight">Daftarkan Akun Guru BK</h2>
                <p class="text-slate-500 text-xs mt-1.5">Buat akun pengajar Bimbingan Konseling (BK) baru untuk sekolah mitra.</p>
            </div>

            <form action="{{ route('admin.pengguna.store.guru') }}" method="POST" class="relative z-10 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap Pengajar</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="Contoh: Siti Aminah, S.Pd."
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('name') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIP --}}
                    <div>
                        <label for="nip" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NIP Pengajar</label>
                        <input type="text" id="nip" name="nip" required value="{{ old('nip') }}" placeholder="Contoh: 198005122005012001"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('nip') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Email Resmi</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="Contoh: sitiaminah@mgbk.mail"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('email') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label for="no_hp" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Handphone Aktif</label>
                        <input type="text" id="no_hp" name="no_hp" required value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('no_hp') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Sekolah --}}
                    <div>
                        <label for="sekolah" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sekolah Asal Penugasan</label>
                        <input type="text" id="sekolah" name="sekolah" required value="{{ old('sekolah') }}" placeholder="Contoh: SMA Negeri 1 Jakarta"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
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
                    <a href="{{ route('admin.pengguna.index', ['tab' => 'guru']) }}" class="px-5 py-3 rounded-xl border border-slate-200 hover:border-slate-350 bg-white text-slate-550 text-xs font-bold transition-all cursor-pointer">
                        Batalkan
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all shadow-lg shadow-[#1D9E75]/10 cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Daftarkan Guru BK
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
