<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Navigation back --}}
        <div>
            <a href="{{ route('admin.kampus.index') }}" class="text-[#1D9E75] hover:text-[#1a3d6e] text-xs font-bold flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Kampus
            </a>
        </div>

        {{-- Form Container --}}
        <div class="bg-white rounded-3xl p-8 relative overflow-hidden border border-slate-100 shadow-xl shadow-slate-100/10">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1a3d6e]/5 to-[#1D9E75]/5 pointer-events-none"></div>

            <div class="relative z-10 mb-8 border-b border-slate-100 pb-6">
                <h2 class="heading-font text-2xl font-extrabold text-[#1a3d6e] tracking-tight">Daftarkan Kampus Mitra</h2>
                <p class="text-slate-500 text-xs mt-1.5">Isi rincian lengkap mengenai universitas atau sekolah tinggi yang bekerjasama dengan MGBK.</p>
            </div>

            <form action="{{ route('admin.kampus.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Kampus --}}
                    <div>
                        <label for="nama_kampus" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Kampus</label>
                        <input type="text" id="nama_kampus" name="nama_kampus" required value="{{ old('nama_kampus') }}" placeholder="Contoh: Universitas Gadjah Mada"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('nama_kampus') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Website --}}
                    <div>
                        <label for="website" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Website Resmi</label>
                        <input type="url" id="website" name="website" value="{{ old('website') }}" placeholder="Contoh: https://ugm.ac.id"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('website') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kontak --}}
                    <div>
                        <label for="kontak" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Narahubung / Kontak</label>
                        <input type="text" id="kontak" name="kontak" required value="{{ old('kontak') }}" placeholder="Contoh: Humas (0812-3456-7890)"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('kontak') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Logo --}}
                    <div>
                        <label for="logo" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Unggah Logo Kampus</label>
                        <input type="file" id="logo" name="logo" accept="image/*"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-500 transition-all shadow-sm">
                        @error('logo') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Fisik Kampus</label>
                        <textarea id="alamat" name="alamat" rows="2" required placeholder="Tuliskan alamat lengkap kampus..."
                                  class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">{{ old('alamat') }}</textarea>
                        @error('alamat') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Profil Ringkas Kampus</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required placeholder="Tuliskan keunggulan, pencapaian, dan cakupan program akademik perguruan tinggi..."
                                  class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Status --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Status Aktivitas</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-200 hover:border-[#1D9E75] cursor-pointer select-none transition-all group shadow-sm">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="is_active" value="1" checked class="h-4.5 w-4.5 text-[#1D9E75] focus:ring-[#1D9E75] focus:ring-offset-0 border-slate-300 bg-white cursor-pointer">
                                <div class="text-left">
                                    <span class="text-xs text-slate-800 font-bold block">Aktif</span>
                                    <span class="text-[10px] text-slate-400 font-semibold block mt-0.5">Kerjasama mitra berjalan dan dapat mempublikasikan program</span>
                                </div>
                            </div>
                        </label>
                        <label class="relative flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-200 hover:border-rose-500 cursor-pointer select-none transition-all group shadow-sm">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="is_active" value="0" class="h-4.5 w-4.5 text-rose-600 focus:ring-rose-500 focus:ring-offset-0 border-slate-300 bg-white cursor-pointer">
                                <div class="text-left">
                                    <span class="text-xs text-slate-800 font-bold block">Non-Aktif</span>
                                    <span class="text-[10px] text-slate-400 font-semibold block mt-0.5">Kerjasama ditangguhkan sementara</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.kampus.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 hover:border-slate-350 bg-white text-slate-550 text-xs font-bold transition-all cursor-pointer">
                        Batalkan
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all shadow-lg shadow-[#1D9E75]/10 cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Simpan Mitra
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
