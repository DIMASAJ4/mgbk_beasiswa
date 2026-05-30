<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Navigation back --}}
        <div>
            <a href="{{ route('admin.beasiswa.index') }}" class="text-[#1D9E75] hover:text-[#1a3d6e] text-xs font-bold flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Beasiswa
            </a>
        </div>

        {{-- Form Container --}}
        <div class="bg-white rounded-3xl p-8 relative overflow-hidden border border-slate-100 shadow-xl shadow-slate-100/10">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1a3d6e]/5 to-[#1D9E75]/5 pointer-events-none"></div>

            <div class="relative z-10 mb-8 border-b border-slate-100 pb-6">
                <h2 class="heading-font text-2xl font-extrabold text-[#1a3d6e] tracking-tight">Edit Program Beasiswa</h2>
                <p class="text-slate-500 text-xs mt-1.5">Perbarui rincian program beasiswa yang terdaftar di portal MGBK Beasiswa.</p>
            </div>

            <form action="{{ route('admin.beasiswa.update', $beasiswa->id) }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Beasiswa --}}
                    <div class="md:col-span-2">
                        <label for="nama_beasiswa" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Program Beasiswa</label>
                        <input type="text" id="nama_beasiswa" name="nama_beasiswa" required value="{{ old('nama_beasiswa', $beasiswa->nama_beasiswa) }}" placeholder="Contoh: Beasiswa Unggulan UGM"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('nama_beasiswa') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kampus Mitra --}}
                    <div>
                        <label for="kampus_mitra_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kampus Mitra</label>
                        <select id="kampus_mitra_id" name="kampus_mitra_id" required
                                class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 shadow-sm">
                            @foreach ($kampusMitras as $kampus)
                                <option value="{{ $kampus->id }}" {{ old('kampus_mitra_id', $beasiswa->kampus_mitra_id) == $kampus->id ? 'selected' : '' }}>
                                    {{ $kampus->nama_kampus }}
                                </option>
                            @endforeach
                        </select>
                        @error('kampus_mitra_id') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jenis Beasiswa --}}
                    <div>
                        <label for="jenis" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Beasiswa</label>
                        <select id="jenis" name="jenis" required
                                class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 shadow-sm">
                            <option value="full_funding" {{ old('jenis', $beasiswa->jenis) === 'full_funding' ? 'selected' : '' }}>Full Funding (Pendanaan Penuh)</option>
                            <option value="partial_funding" {{ old('jenis', $beasiswa->jenis) === 'partial_funding' ? 'selected' : '' }}>Partial Funding (Sebagian)</option>
                            <option value="akomodasi" {{ old('jenis', $beasiswa->jenis) === 'akomodasi' ? 'selected' : '' }}>Akomodasi (Tempat Tinggal)</option>
                        </select>
                        @error('jenis') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kuota --}}
                    <div>
                        <label for="kuota" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kuota Penerima (Siswa)</label>
                        <input type="number" min="1" id="kuota" name="kuota" required value="{{ old('kuota', $beasiswa->kuota) }}" placeholder="Contoh: 10"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">
                        @error('kuota') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deadline --}}
                    <div>
                        <label for="deadline" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Batas Akhir Pendaftaran</label>
                        <input type="date" id="deadline" name="deadline" required value="{{ old('deadline', $beasiswa->deadline->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 transition-all shadow-sm">
                        @error('deadline') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Thumbnail --}}
                    <div class="md:col-span-2">
                        <label for="thumbnail" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gambar / Thumbnail Beasiswa (Opsional)</label>
                        @if ($beasiswa->thumbnail)
                            <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 border border-slate-200 rounded-xl max-w-sm">
                                <div class="h-14 w-20 rounded bg-slate-200 overflow-hidden flex items-center justify-center shrink-0 border border-slate-300">
                                    <img src="{{ asset('storage/' . $beasiswa->thumbnail) }}" alt="" class="h-full w-full object-cover">
                                </div>
                                <div class="text-[10px] text-slate-500">
                                    <span class="font-bold block text-slate-750">Gambar Saat Ini</span>
                                    <span class="block mt-0.5">{{ basename($beasiswa->thumbnail) }}</span>
                                </div>
                            </div>
                        @endif
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                               class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-500 transition-all shadow-sm">
                        @error('thumbnail') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Beasiswa</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required placeholder="Tuliskan ringkasan cakupan program beasiswa..."
                                  class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 transition-all shadow-sm">{{ old('deskripsi', $beasiswa->deskripsi) }}</textarea>
                        @error('deskripsi') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Persyaratan (Dynamic Inputs) --}}
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Persyaratan Khusus (Dinamis)</label>
                    <div id="requirements-container" class="space-y-3">
                        @php
                            $currentRequirements = old('persyaratan', is_array($beasiswa->persyaratan) ? $beasiswa->persyaratan : json_decode($beasiswa->persyaratan, true) ?? []);
                        @endphp
                        
                        @forelse($currentRequirements as $req)
                        <div class="flex gap-2 requirement-row">
                            <input type="text" name="persyaratan[]" required value="{{ $req }}" placeholder="Contoh: Nilai rata-rata min 8.0" 
                                   class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 shadow-sm">
                            <button type="button" class="remove-requirement px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 hover:bg-rose-50 hover:text-rose-600 transition-colors text-slate-400 text-xs font-bold">
                                <i class="fa-solid fa-trash text-center"></i>
                            </button>
                        </div>
                        @empty
                        <div class="flex gap-2 requirement-row">
                            <input type="text" name="persyaratan[]" required placeholder="Contoh: Nilai rata-rata min 8.0" 
                                   class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 shadow-sm">
                            <button type="button" class="remove-requirement px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 hover:bg-rose-50 hover:text-rose-600 transition-colors text-slate-400 text-xs font-bold">
                                <i class="fa-solid fa-trash text-center"></i>
                            </button>
                        </div>
                        @endforelse
                    </div>
                    <button type="button" id="add-requirement" class="px-3.5 py-2 mt-2 rounded-xl bg-[#e8f4f0] hover:bg-[#1D9E75]/25 text-[#1D9E75] border border-[#1D9E75]/10 text-xs font-extrabold transition-all flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-plus text-[10px]"></i> Tambah Baris Persyaratan
                    </button>
                    @error('persyaratan') <p class="text-rose-600 text-[10px] mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                {{-- Status --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Status Rilis</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-200 hover:border-[#1D9E75] cursor-pointer select-none transition-all group shadow-sm">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="status" value="aktif" {{ old('status', $beasiswa->status) === 'aktif' ? 'checked' : '' }} class="h-4.5 w-4.5 text-[#1D9E75] focus:ring-[#1D9E75] focus:ring-offset-0 border-slate-350 bg-white cursor-pointer">
                                <div class="text-left">
                                    <span class="text-xs text-slate-800 font-bold block">Aktif</span>
                                    <span class="text-[10px] text-slate-400 font-semibold block mt-0.5">Dipublikasikan</span>
                                </div>
                            </div>
                        </label>
                        <label class="relative flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-200 hover:border-amber-500 cursor-pointer select-none transition-all group shadow-sm">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="status" value="draft" {{ old('status', $beasiswa->status) === 'draft' ? 'checked' : '' }} class="h-4.5 w-4.5 text-amber-600 focus:ring-amber-500 focus:ring-offset-0 border-slate-350 bg-white cursor-pointer">
                                <div class="text-left">
                                    <span class="text-xs text-slate-800 font-bold block">Draft</span>
                                    <span class="text-[10px] text-slate-400 font-semibold block mt-0.5">Arsip internal</span>
                                </div>
                            </div>
                        </label>
                        <label class="relative flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-200 hover:border-rose-500 cursor-pointer select-none transition-all group shadow-sm">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="status" value="tutup" {{ old('status', $beasiswa->status) === 'tutup' ? 'checked' : '' }} class="h-4.5 w-4.5 text-rose-600 focus:ring-rose-500 focus:ring-offset-0 border-slate-350 bg-white cursor-pointer">
                                <div class="text-left">
                                    <span class="text-xs text-slate-800 font-bold block">Tutup</span>
                                    <span class="text-[10px] text-slate-400 font-semibold block mt-0.5">Pendaftaran ditutup</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.beasiswa.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 hover:border-slate-350 bg-white text-slate-550 text-xs font-bold transition-all cursor-pointer">
                        Batalkan
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all shadow-lg shadow-[#1D9E75]/10 cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Perbarui Beasiswa
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('add-requirement').addEventListener('click', function() {
            const container = document.getElementById('requirements-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex gap-2 requirement-row';
            newRow.innerHTML = `
                <input type="text" name="persyaratan[]" required placeholder="Contoh: Nilai rata-rata min 8.0" class="w-full px-4 py-3 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 shadow-sm">
                <button type="button" class="remove-requirement px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 hover:bg-rose-50 hover:text-rose-600 transition-colors text-slate-400 text-xs font-bold">
                    <i class="fa-solid fa-trash text-center"></i>
                </button>
            `;
            container.appendChild(newRow);
        });

        document.getElementById('requirements-container').addEventListener('click', function(e) {
            if (e.target.closest('.remove-requirement')) {
                const rows = document.querySelectorAll('.requirement-row');
                if (rows.length > 1) {
                    e.target.closest('.requirement-row').remove();
                } else {
                    alert('Harus ada minimal 1 persyaratan khusus!');
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
