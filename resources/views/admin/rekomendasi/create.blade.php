<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div>
                <h1 class="heading-font text-xl font-bold text-slate-800">Rekomendasikan Beasiswa ke Siswa</h1>
                <p class="text-xs text-slate-500 mt-1">Gunakan kecocokan otomatis profil siswa untuk merekomendasikan beasiswa terbaik.</p>
            </div>
            <a href="{{ route('admin.rekomendasi.index') }}" class="py-2 px-4 border border-slate-200 hover:border-slate-300 text-slate-600 rounded-xl text-xs font-bold transition-all bg-white hover:bg-slate-50 cursor-pointer">
                <i class="fa-solid fa-arrow-left mr-1"></i> Batal
            </a>
        </div>

        <form action="{{ route('admin.rekomendasi.store') }}" method="POST" id="rekomendasi-form" class="space-y-6">
            @csrf

            <!-- STEP 1: PILIH SISWA -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span class="flex items-center justify-center h-6 w-6 rounded-full bg-[#1D9E75]/10 text-[#1D9E75] text-[11px] font-bold">1</span>
                    <h3 class="text-sm font-bold text-slate-800">Pilih Siswa Peminat</h3>
                </div>

                <div class="space-y-3">
                    <label for="user_id" class="text-xs font-semibold text-slate-600">Nama Siswa / NISN</label>
                    <select name="user_id" id="user_id" class="w-full p-2.5 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-[#1D9E75] focus:border-[#1D9E75] focus:outline-none transition-all">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}">{{ $siswa->name }} (NISN: {{ $siswa->nisn ?? '-' }}) - {{ $siswa->sekolah ?? 'SMA Negeri' }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Info Card Siswa (AJAX) -->
                <div id="siswa-info-card" class="hidden bg-slate-50/50 p-5 rounded-2xl border border-slate-100 space-y-4">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-slate-800">Profil & Data Akademik Siswa</h4>
                        <span class="px-2 py-0.5 text-[9px] font-bold bg-[#1a3d6e]/10 text-[#1a3d6e] rounded border border-[#1a3d6e]/10">Verifikasi Sukses</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                        <div class="space-y-1">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Nama Lengkap</span>
                            <p class="text-xs font-bold text-slate-700" id="info-nama">-</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Asal Sekolah & Kelas</span>
                            <p class="text-xs font-bold text-slate-700" id="info-sekolah-kelas">-</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Nilai Rata-rata</span>
                            <p class="text-xs font-bold text-[#1D9E75] flex items-center gap-1">
                                <i class="fa-solid fa-star text-[10px]"></i> <span id="info-nilai">-</span>
                            </p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Kondisi Ekonomi</span>
                            <p class="text-xs font-bold text-slate-700" id="info-ekonomi">-</p>
                        </div>
                        <div class="col-span-1 sm:col-span-2 space-y-1">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Minat Jurusan</span>
                            <p class="text-xs font-bold text-slate-700" id="info-minat">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 2: PILIH BEASISWA -->
            <div id="step-2-card" class="hidden bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span class="flex items-center justify-center h-6 w-6 rounded-full bg-[#1D9E75]/10 text-[#1D9E75] text-[11px] font-bold">2</span>
                    <h3 class="text-sm font-bold text-slate-800">Pilih Beasiswa Terbaik</h3>
                </div>

                <div class="text-xs text-slate-500 mb-2">Beasiswa diurutkan berdasarkan tingkat kecocokan profil siswa.</div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="beasiswa-cards-container">
                    <!-- Cards will be populated dynamically via Javascript AJAX -->
                </div>
            </div>

            <!-- Sticky Bottom Bar -->
            <div class="flex items-center justify-end gap-3 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                <a href="{{ route('admin.rekomendasi.index') }}" class="py-2.5 px-5 border border-slate-200 text-slate-500 hover:text-slate-700 rounded-xl text-xs font-bold transition-all bg-white hover:bg-slate-50 cursor-pointer">
                    Batal
                </a>
                <button type="submit" id="submit-btn" disabled class="py-2.5 px-6 bg-[#1D9E75] hover:bg-[#15803d] text-white disabled:bg-slate-200 disabled:text-slate-400 disabled:cursor-not-allowed rounded-xl text-xs font-bold transition-all shadow-md shadow-[#1D9E75]/10 hover:shadow-lg hover:-translate-y-0.5 cursor-pointer">
                    Kirim Rekomendasi <i class="fa-solid fa-paper-plane text-[10px] ml-1"></i>
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const userSelect = document.getElementById('user_id');
                const infoCard = document.getElementById('siswa-info-card');
                const step2Card = document.getElementById('step-2-card');
                const cardsContainer = document.getElementById('beasiswa-cards-container');
                const submitBtn = document.getElementById('submit-btn');

                userSelect.addEventListener('change', function() {
                    const siswaId = this.value;

                    if (!siswaId) {
                        infoCard.classList.add('hidden');
                        step2Card.classList.add('hidden');
                        submitBtn.disabled = true;
                        return;
                    }

                    // Show loader state
                    cardsContainer.innerHTML = `
                        <div class="col-span-full py-8 text-center text-slate-400">
                            <i class="fa-solid fa-spinner fa-spin text-lg mr-2"></i> Mengkalkulasi kecocokan beasiswa...
                        </div>
                    `;
                    infoCard.classList.remove('hidden');
                    step2Card.classList.remove('hidden');

                    fetch(`/admin/rekomendasi/siswa/${siswaId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Profil siswa belum terverifikasi atau tidak lengkap.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Populate Siswa Info Card
                            document.getElementById('info-nama').innerText = data.user.name;
                            document.getElementById('info-sekolah-kelas').innerText = `${data.user.sekolah} (${data.user.kelas})`;
                            document.getElementById('info-nilai').innerText = `${data.user.nilai_rata} / 100`;
                            document.getElementById('info-ekonomi').innerText = data.user.kondisi_ekonomi;
                            document.getElementById('info-minat').innerText = data.user.minat_jurusan || 'Tidak ada minat terdaftar';

                            // Populate Scholarship Cards
                            cardsContainer.innerHTML = '';
                            if (data.beasiswas.length === 0) {
                                cardsContainer.innerHTML = `
                                    <div class="col-span-full text-center py-6 text-slate-400">
                                        Tidak ada beasiswa aktif yang tersedia.
                                    </div>
                                `;
                                return;
                            }

                            data.beasiswas.forEach(b => {
                                const isBest = b.match_score >= 85;
                                const isWarning = b.match_score < 60;
                                let matchColor = 'bg-[#1D9E75]';
                                if (isWarning) matchColor = 'bg-rose-500';
                                else if (b.match_score < 80) matchColor = 'bg-amber-500';

                                const disabledAttr = b.sudah_direkomendasikan ? 'disabled' : '';
                                const opacityClass = b.sudah_direkomendasikan ? 'opacity-65 border-dashed bg-slate-50' : 'hover:border-[#1D9E75]/30 hover:shadow-md';

                                cardsContainer.innerHTML += `
                                    <label class="block relative p-4 rounded-xl border border-slate-200 transition-all ${opacityClass} cursor-pointer">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="space-y-1 pr-6">
                                                <h4 class="text-xs font-bold text-slate-800 line-clamp-1">${b.nama_beasiswa}</h4>
                                                <p class="text-[10px] text-slate-400 font-bold">${b.kampus_nama}</p>
                                            </div>
                                            <input type="radio" name="beasiswa_id" value="${b.id}" ${disabledAttr} class="absolute top-4 right-4 h-4 w-4 text-[#1D9E75] focus:ring-[#1D9E75] border-slate-300">
                                        </div>

                                        <div class="mt-4 space-y-2">
                                            <!-- Match compatibility percentage -->
                                            <div class="flex items-center justify-between text-[10px] font-bold">
                                                <span class="text-slate-400">Kecocokan Profil</span>
                                                <span class="text-slate-700">${b.match_score}%</span>
                                            </div>
                                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                                <div class="${matchColor} h-full rounded-full" style="width: ${b.match_score}%"></div>
                                            </div>

                                            <div class="flex items-center justify-between pt-2 text-[10px]">
                                                <span class="px-2 py-0.5 rounded font-bold bg-slate-100 text-slate-600">${b.jenis_formatted}</span>
                                                <span class="text-slate-400 font-medium">Sisa Deadline: <strong class="text-slate-600">${b.deadline}</strong></span>
                                            </div>
                                        </div>

                                        ${b.sudah_direkomendasikan ? `
                                            <div class="absolute top-2 right-2 flex gap-1">
                                                <span class="px-1.5 py-0.5 rounded text-[8px] font-bold bg-rose-50 border border-rose-100 text-rose-600">Sudah Direkomendasikan</span>
                                            </div>
                                        ` : ''}
                                    </label>
                                `;
                            });

                            // Add Event Listener to Radios to enable the Submit Button
                            const radios = document.querySelectorAll('input[name="beasiswa_id"]');
                            radios.forEach(radio => {
                                radio.addEventListener('change', function() {
                                    submitBtn.disabled = false;
                                });
                            });
                        })
                        .catch(err => {
                            cardsContainer.innerHTML = `
                                <div class="col-span-full py-8 text-center text-rose-500 text-xs font-semibold">
                                    <i class="fa-solid fa-circle-exmark mr-1"></i> ${err.message}
                                </div>
                            `;
                            infoCard.classList.add('hidden');
                            submitBtn.disabled = true;
                        });
                });
            });
        </script>
    @endpush
</x-app-layout>
