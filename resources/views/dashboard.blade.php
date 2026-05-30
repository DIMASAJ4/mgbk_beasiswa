<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-white heading-font tracking-tight">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>
                <p class="text-xs text-slate-400 mt-1">Hari ini {{ now()->translatedFormat('l, d F Y') }} | Jam {{ now()->translatedFormat('H:i') }} WIB</p>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="px-3.5 py-1.5 rounded-xl bg-slate-900 border border-slate-800 text-xs font-bold text-slate-300 flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sesi Aktif
                </span>
                
                <span class="px-3.5 py-1.5 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-xs font-extrabold text-indigo-400">
                    <i class="fa-solid fa-user-shield mr-1.5"></i>{{ Auth::user()->roles->pluck('name')->first() ?? 'Siswa' }}
                </span>
            </div>
        </div>
    </x-slot>

    <!-- Role-Based View: ADMIN -->
    @role('Admin')
    <div class="space-y-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stat 1 -->
            <div class="glassmorphism p-6 rounded-2xl relative overflow-hidden">
                <div class="absolute -right-3 -bottom-3 text-slate-800/10 text-7xl"><i class="fa-solid fa-users"></i></div>
                <span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Total Siswa</span>
                <h3 class="text-3xl font-extrabold text-white heading-font mt-2">1,248</h3>
                <div class="flex items-center gap-1.5 text-xs text-emerald-400 mt-3 font-semibold">
                    <i class="fa-solid fa-arrow-trend-up"></i> +12% minggu ini
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="glassmorphism p-6 rounded-2xl relative overflow-hidden">
                <div class="absolute -right-3 -bottom-3 text-slate-800/10 text-7xl"><i class="fa-solid fa-envelope-open-text"></i></div>
                <span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Aplikasi Masuk</span>
                <h3 class="text-3xl font-extrabold text-white heading-font mt-2">342</h3>
                <div class="flex items-center gap-1.5 text-xs text-indigo-400 mt-3 font-semibold">
                    <i class="fa-solid fa-clock"></i> 48 menunggu verifikasi
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="glassmorphism p-6 rounded-2xl relative overflow-hidden">
                <div class="absolute -right-3 -bottom-3 text-slate-800/10 text-7xl"><i class="fa-solid fa-award"></i></div>
                <span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Beasiswa Aktif</span>
                <h3 class="text-3xl font-extrabold text-white heading-font mt-2">6</h3>
                <div class="flex items-center gap-1.5 text-xs text-purple-400 mt-3 font-semibold">
                    <i class="fa-solid fa-circle-check"></i> 2 Program Unggulan
                </div>
            </div>

            <!-- Stat 4 -->
            <div class="glassmorphism p-6 rounded-2xl relative overflow-hidden">
                <div class="absolute -right-3 -bottom-3 text-slate-800/10 text-7xl"><i class="fa-solid fa-vault"></i></div>
                <span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Anggaran Disalurkan</span>
                <h3 class="text-3xl font-extrabold text-white heading-font mt-2">Rp 2.4 M</h3>
                <div class="flex items-center gap-1.5 text-xs text-pink-400 mt-3 font-semibold">
                    <i class="fa-solid fa-shield"></i> Tersertifikasi BPK
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-8">
            <!-- Left: Table of Recent Applicants -->
            <div class="lg:col-span-8 glassmorphism rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="text-base font-bold text-white heading-font">Aplikasi Beasiswa Terbaru</h4>
                    <span class="text-xs text-indigo-400 font-semibold hover:underline cursor-pointer">Lihat semua</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-slate-900 text-slate-500 font-bold text-xs uppercase tracking-wider">
                                <th class="pb-3">Siswa</th>
                                <th class="pb-3">Program</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-900/40">
                            <tr>
                                <td class="py-3.5 flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-pink-500/10 text-pink-400 flex items-center justify-center text-xs font-bold">AM</div>
                                    <div>
                                        <div class="font-bold text-white">Ananda Mahendra</div>
                                        <div class="text-[10px] text-slate-500">NISN: 007248192</div>
                                    </div>
                                </td>
                                <td class="py-3.5 text-slate-300">Beasiswa Unggulan S1</td>
                                <td class="py-3.5">
                                    <span class="px-2.5 py-1 rounded-lg bg-yellow-500/10 border border-yellow-500/20 text-yellow-500 text-[10px] font-bold uppercase tracking-wider">
                                        Proses
                                    </span>
                                </td>
                                <td class="py-3.5">
                                    <button class="px-3 py-1 rounded bg-slate-900 border border-slate-800 hover:border-slate-700 text-xs font-bold text-indigo-400 cursor-pointer">Verifikasi</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3.5 flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center text-xs font-bold">BS</div>
                                    <div>
                                        <div class="font-bold text-white">Budi Santoso</div>
                                        <div class="text-[10px] text-slate-500">NISN: 008129847</div>
                                    </div>
                                </td>
                                <td class="py-3.5 text-slate-300">Beasiswa Bidikmisi MGBK</td>
                                <td class="py-3.5">
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase tracking-wider">
                                        Disetujui
                                    </span>
                                </td>
                                <td class="py-3.5">
                                    <button class="px-3 py-1 rounded bg-slate-900 border border-slate-800 hover:border-slate-700 text-xs font-bold text-slate-400 cursor-pointer">Rincian</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right: Admin Shortcuts -->
            <div class="lg:col-span-4 space-y-6">
                <div class="glassmorphism rounded-2xl p-6">
                    <h4 class="text-base font-bold text-white heading-font mb-6">Pintasan Cepat</h4>
                    <div class="space-y-3">
                        <a href="{{ route('admin.roles') }}" class="flex items-center justify-between p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 hover:border-indigo-500/30 hover:bg-slate-900 transition-all duration-200 group">
                            <span class="text-xs font-bold text-slate-300 group-hover:text-white flex items-center gap-3">
                                <i class="fa-solid fa-user-shield text-indigo-400"></i> Manajemen Peran & User
                            </span>
                            <i class="fa-solid fa-arrow-right text-slate-600 group-hover:text-indigo-400 transition-colors"></i>
                        </a>

                        <button class="w-full flex items-center justify-between p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 hover:border-indigo-500/30 hover:bg-slate-900 transition-all duration-200 group text-left cursor-pointer">
                            <span class="text-xs font-bold text-slate-300 group-hover:text-white flex items-center gap-3">
                                <i class="fa-solid fa-circle-plus text-purple-400"></i> Buat Program Beasiswa
                            </span>
                            <i class="fa-solid fa-arrow-right text-slate-600 group-hover:text-purple-400 transition-colors"></i>
                        </button>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="p-6 rounded-2xl bg-gradient-to-tr from-indigo-900/40 to-purple-900/40 border border-indigo-800/20">
                    <h5 class="text-xs font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-lightbulb text-yellow-400"></i> Tips Administrator
                    </h5>
                    <p class="text-[11px] text-slate-400 leading-relaxed mt-2">
                        Gunakan menu **Manajemen Peran** untuk menetapkan otorisasi pengguna lain (misalnya mendaftarkan akun verifikator beasiswa).
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endrole

    <!-- Role-Based View: VERIFIKATOR -->
    @role('Verifikator')
    <div class="space-y-8">
        <!-- Reviewer Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="glassmorphism p-6 rounded-2xl">
                <span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Telah Diverifikasi</span>
                <h3 class="text-3xl font-extrabold text-white heading-font mt-2">124</h3>
            </div>
            <div class="glassmorphism p-6 rounded-2xl">
                <span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Menunggu Peninjauan</span>
                <h3 class="text-3xl font-extrabold text-white heading-font mt-2">18</h3>
            </div>
            <div class="glassmorphism p-6 rounded-2xl">
                <span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Rasio Kelulusan Berkas</span>
                <h3 class="text-3xl font-extrabold text-white heading-font mt-2">68%</h3>
            </div>
        </div>

        <div class="glassmorphism rounded-2xl p-6">
            <h4 class="text-base font-bold text-white heading-font mb-6">Daftar Berkas Menunggu Verifikasi</h4>
            <div class="space-y-4">
                <!-- Applicant 1 -->
                <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:border-slate-700 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center font-bold">CF</div>
                        <div>
                            <div class="font-bold text-white text-sm">Citra Firdaus</div>
                            <div class="text-[10px] text-slate-400 mt-0.5">Sekolah: SMAN 1 Jakarta | Nilai Rapor: 92.4</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button class="flex-1 sm:flex-none px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition-colors cursor-pointer">
                            <i class="fa-solid fa-check mr-1.5"></i>Setujui
                        </button>
                        <button class="flex-1 sm:flex-none px-3.5 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold transition-colors cursor-pointer">
                            <i class="fa-solid fa-xmark mr-1.5"></i>Tolak
                        </button>
                        <button class="flex-1 sm:flex-none px-3.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-colors border border-slate-700 cursor-pointer">
                            Tinjau Berkas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    <!-- Role-Based View: SISWA -->
    @role('Siswa')
    <div class="space-y-8">
        <!-- Interactive Progress Stepper -->
        <div class="glassmorphism rounded-2xl p-6 lg:p-8">
            <h4 class="text-base font-bold text-white heading-font mb-8">Status Pengajuan Beasiswa Anda</h4>
            
            <div class="grid md:grid-cols-3 gap-6 relative">
                <!-- Step 1 -->
                <div class="p-4 rounded-xl bg-indigo-500/5 border border-indigo-500/20 relative">
                    <div class="absolute top-4 right-4 h-6 w-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <span class="text-[9px] text-indigo-400 font-bold uppercase tracking-wider">Tahap 1</span>
                    <h5 class="text-sm font-bold text-white mt-1">Registrasi Akun</h5>
                    <p class="text-[11px] text-slate-400 mt-1.5">Akun Anda telah terdaftar dan diverifikasi.</p>
                </div>

                <!-- Step 2 -->
                <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 relative">
                    <div class="absolute top-4 right-4 h-6 w-6 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-spinner animate-spin"></i>
                    </div>
                    <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Tahap 2</span>
                    <h5 class="text-sm font-bold text-white mt-1">Unggah Berkas Pendukung</h5>
                    <p class="text-[11px] text-slate-400 mt-1.5">Harap melengkapi berkas biodata, sertifikat, dan rapor.</p>
                </div>

                <!-- Step 3 -->
                <div class="p-4 rounded-xl bg-slate-900/20 border border-slate-900 text-slate-500">
                    <span class="text-[9px] text-slate-600 font-bold uppercase tracking-wider">Tahap 3</span>
                    <h5 class="text-sm font-bold text-slate-500 mt-1">Verifikasi & Pengumuman</h5>
                    <p class="text-[11px] text-slate-600 mt-1.5">Proses penilaian dokumen oleh tim seleksi MGBK.</p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-8">
            <!-- Left: Document Upload Zone (Mock) -->
            <div class="lg:col-span-7 glassmorphism rounded-2xl p-6">
                <h4 class="text-base font-bold text-white heading-font mb-4">Unggah Berkas Pendaftaran</h4>
                <p class="text-xs text-slate-400 leading-relaxed mb-6">Berkas wajib diunggah dalam format PDF dengan ukuran maksimal 2MB per file.</p>
                
                <div class="space-y-4">
                    <!-- File Row 1 -->
                    <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800 flex justify-between items-center hover:border-indigo-500/30 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center"><i class="fa-solid fa-file-invoice"></i></div>
                            <div>
                                <h5 class="text-xs font-bold text-white">Transkrip Nilai Rapor (Semester 1-5)</h5>
                                <span class="text-[10px] text-rose-400 font-semibold mt-0.5 block">Wajib *</span>
                            </div>
                        </div>
                        <button class="px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition-colors cursor-pointer">
                            Unggah
                        </button>
                    </div>

                    <!-- File Row 2 -->
                    <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800 flex justify-between items-center hover:border-indigo-500/30 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-purple-500/10 text-purple-400 flex items-center justify-center"><i class="fa-solid fa-award"></i></div>
                            <div>
                                <h5 class="text-xs font-bold text-white">Sertifikat Prestasi (Akademik/Non-Akademik)</h5>
                                <span class="text-[10px] text-slate-500 font-medium mt-0.5 block">Opsional</span>
                            </div>
                        </div>
                        <button class="px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition-colors cursor-pointer">
                            Unggah
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Available Scholarships list -->
            <div class="lg:col-span-5 glassmorphism rounded-2xl p-6">
                <h4 class="text-base font-bold text-white heading-font mb-6">Program Beasiswa Tersedia</h4>
                
                <div class="space-y-4">
                    <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 hover:border-slate-700 transition-colors relative">
                        <div class="flex items-start justify-between">
                            <h5 class="text-xs font-bold text-white leading-tight">Beasiswa Prestasi S1 Unggulan</h5>
                            <span class="px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[8px] font-bold uppercase tracking-wider">Terbuka</span>
                        </div>
                        <p class="text-[10px] text-slate-400 leading-normal mt-2">Dukungan biaya kuliah penuh dan uang saku per bulan untuk 20 siswa terpilih.</p>
                        <button class="w-full mt-4 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold transition-colors cursor-pointer">Daftar Program</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole
</x-app-layout>
