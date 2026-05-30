<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MGBK Beasiswa | Portal Beasiswa Konseling Premium</title>

        <!-- Fonts & Icons -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            .heading-font {
                font-family: 'Outfit', sans-serif;
            }
            .glassmorphism {
                background: rgba(15, 23, 42, 0.65);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
            .glass-nav {
                background: rgba(10, 15, 30, 0.7);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            }
            .glow-blob {
                filter: blur(120px);
                opacity: 0.45;
                animation: pulse 10s infinite alternate;
            }
            @keyframes pulse {
                0% { transform: scale(1) translate(0px, 0px); }
                50% { transform: scale(1.1) translate(20px, -20px); }
                100% { transform: scale(0.9) translate(-10px, 10px); }
            }
        </style>
    </head>
    <body class="bg-slate-950 text-slate-100 min-h-screen overflow-x-hidden relative selection:bg-indigo-500 selection:text-white">
        
        <!-- Glowing Background Blobs -->
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-purple-600 glow-blob -z-10"></div>
        <div class="absolute top-[20%] right-[-10%] w-[600px] h-[600px] rounded-full bg-blue-600 glow-blob -z-10 animation-delay-2000"></div>
        <div class="absolute bottom-[-10%] left-[15%] w-[550px] h-[550px] rounded-full bg-emerald-600 glow-blob -z-10 animation-delay-4000"></div>

        <!-- Navigation Bar -->
        <nav class="sticky top-0 w-full z-50 glass-nav transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="heading-font text-xl font-extrabold tracking-wider bg-gradient-to-r from-white via-slate-100 to-indigo-300 bg-clip-text text-transparent">
                        MGBK <span class="text-indigo-400">BEASISWA</span>
                    </span>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                    <a href="#tentang" class="hover:text-indigo-400 transition-colors duration-200">Tentang</a>
                    <a href="#fitur" class="hover:text-indigo-400 transition-colors duration-200">Fitur</a>
                    <a href="#alur" class="hover:text-indigo-400 transition-colors duration-200">Alur Pendaftaran</a>
                    <a href="#kontak" class="hover:text-indigo-400 transition-colors duration-200">Kontak</a>
                </div>

                <!-- CTA Actions -->
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold transition-all duration-200 shadow-md shadow-indigo-600/10 hover:shadow-indigo-600/20 hover:-translate-y-0.5">
                                <i class="fa-solid fa-gauge mr-2"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors duration-200 px-4 py-2">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-sm font-semibold transition-all duration-200 shadow-md shadow-indigo-500/20 hover:shadow-indigo-500/30 hover:-translate-y-0.5">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-6 pt-16 pb-24 grid md:grid-cols-12 gap-12 items-center">
            <!-- Hero Text -->
            <div class="md:col-span-7 flex flex-col items-start text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-6">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Portal Beasiswa MGBK v1.0
                </div>

                <h1 class="heading-font text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-none mb-6">
                    Raih Masa Depanmu <br>
                    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                        Bersama Beasiswa MGBK
                    </span>
                </h1>

                <p class="text-slate-400 text-base sm:text-lg max-w-xl leading-relaxed mb-8">
                    Portal resmi Musyawarah Guru Bimbingan Konseling (MGBK) untuk pendaftaran, seleksi, dan penyaluran beasiswa bagi siswa-siswi berprestasi. Transparan, terpercaya, dan inklusif.
                </p>

                <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto text-center px-8 py-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold transition-all duration-200 shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/30 hover:-translate-y-1">
                        Mulai Pendaftaran <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#alur" class="w-full sm:w-auto text-center px-8 py-4 rounded-xl bg-slate-900/60 hover:bg-slate-900 border border-slate-800 text-slate-300 hover:text-white font-semibold transition-all duration-200">
                        Pelajari Alur
                    </a>
                </div>

                <!-- Simple Stats -->
                <div class="grid grid-cols-3 gap-8 mt-12 pt-8 border-t border-slate-900 w-full max-w-lg">
                    <div>
                        <div class="heading-font text-3xl font-extrabold text-white">50+</div>
                        <div class="text-xs text-slate-500 mt-1 font-medium uppercase tracking-wider">Mitra Universitas</div>
                    </div>
                    <div>
                        <div class="heading-font text-3xl font-extrabold text-white">Rp 2M+</div>
                        <div class="text-xs text-slate-500 mt-1 font-medium uppercase tracking-wider">Dana Disalurkan</div>
                    </div>
                    <div>
                        <div class="heading-font text-3xl font-extrabold text-white">1,200+</div>
                        <div class="text-xs text-slate-500 mt-1 font-medium uppercase tracking-wider">Siswa Terbantu</div>
                    </div>
                </div>
            </div>

            <!-- Visual Preview Card (Glassmorphism Dashboard preview) -->
            <div class="md:col-span-5 relative w-full flex justify-center">
                <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-500 opacity-20 blur-xl"></div>
                <div class="w-full max-w-sm glassmorphism rounded-2xl p-6 shadow-2xl relative">
                    <!-- Card Top Header -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white leading-tight">Beasiswa Prestasi</h4>
                                <span class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase">Tahun Akademik 2026/2027</span>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase tracking-wider">
                            Aktif
                        </span>
                    </div>

                    <!-- Steps Timeline -->
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="h-6 w-6 rounded-full bg-indigo-500 flex items-center justify-center text-xs text-white shadow-md shadow-indigo-500/20 shrink-0 mt-0.5">
                                <i class="fa-solid fa-check text-[10px]"></i>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-white">Pendaftaran Akun</h5>
                                <p class="text-[10px] text-slate-400 mt-1">Siswa melakukan registrasi mandiri di sistem.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="h-6 w-6 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs text-indigo-400 shrink-0 mt-0.5">
                                <i class="fa-solid fa-file-invoice text-[10px]"></i>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-slate-300">Pengunggahan Dokumen</h5>
                                <p class="text-[10px] text-slate-500 mt-1">Unggah rapor, sertifikat prestasi, dan surat rekomendasi BK.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="h-6 w-6 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs text-indigo-400 shrink-0 mt-0.5">
                                <i class="fa-solid fa-user-tie text-[10px]"></i>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-slate-300">Seleksi & Verifikasi</h5>
                                <p class="text-[10px] text-slate-500 mt-1">Verifikasi dokumen oleh tim verifikator ahli MGBK.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Notification mockup inside -->
                    <div class="mt-8 p-3.5 rounded-xl bg-slate-900/50 border border-slate-800 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400 text-sm shrink-0">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-[11px] font-bold text-white flex justify-between">
                                <span>Beasiswa Prestasi MGBK</span>
                                <span class="text-slate-500 font-semibold text-[9px]">Baru</span>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-0.5">Pendaftaran resmi dibuka mulai hari ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="fitur" class="py-20 bg-slate-900/30 border-y border-slate-900">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <span class="text-indigo-400 text-xs font-bold uppercase tracking-widest">Keunggulan Portal</span>
                    <h2 class="heading-font text-3xl sm:text-4xl font-extrabold text-white mt-2">Mengapa Memilih Portal Kami?</h2>
                    <p class="text-slate-400 mt-4 text-sm sm:text-base">Sistem beasiswa yang dirancang khusus untuk memastikan akurasi, objektivitas, dan kemudahan dalam setiap tahap.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="glassmorphism p-8 rounded-2xl hover:border-indigo-500/40 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="h-12 w-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 text-xl mb-6 group-hover:scale-110 transition-transform duration-200">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="heading-font text-lg font-bold text-white mb-3">Keamanan Data Terjamin</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Seluruh informasi pribadi, rapor, dan sertifikat prestasi dilindungi dengan standar keamanan mutakhir.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="glassmorphism p-8 rounded-2xl hover:border-indigo-500/40 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="h-12 w-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-400 text-xl mb-6 group-hover:scale-110 transition-transform duration-200">
                            <i class="fa-solid fa-users-viewfinder"></i>
                        </div>
                        <h3 class="heading-font text-lg font-bold text-white mb-3">Verifikasi Objektif</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Tim verifikator MGBK yang kompeten melakukan peninjauan secara transparan tanpa intervensi pihak luar.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="glassmorphism p-8 rounded-2xl hover:border-indigo-500/40 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="h-12 w-12 rounded-xl bg-pink-500/10 flex items-center justify-center text-pink-400 text-xl mb-6 group-hover:scale-110 transition-transform duration-200">
                            <i class="fa-solid fa-square-poll-horizontal"></i>
                        </div>
                        <h3 class="heading-font text-lg font-bold text-white mb-3">Pemantauan Real-Time</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Siswa dapat memantau status aplikasi beasiswa mereka secara langsung dari dashboard interaktif.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Flow Section -->
        <section id="alur" class="py-24 max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-indigo-400 text-xs font-bold uppercase tracking-widest">Alur Pendaftaran</span>
                <h2 class="heading-font text-3xl sm:text-4xl font-extrabold text-white mt-2">Langkah Mudah Mengajukan Beasiswa</h2>
                <p class="text-slate-400 mt-4 text-sm sm:text-base">Ikuti langkah-langkah di bawah ini untuk memulai perjalanan akademik impian Anda.</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8 relative">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center">
                    <div class="h-14 w-14 rounded-full bg-slate-900 border-2 border-indigo-500 flex items-center justify-center text-xl text-white font-extrabold mb-4 shadow-lg shadow-indigo-500/10">
                        1
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">Registrasi Akun</h4>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-[200px]">Buat akun siswa menggunakan NISN dan email aktif Anda.</p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center">
                    <div class="h-14 w-14 rounded-full bg-slate-900 border-2 border-slate-800 flex items-center justify-center text-xl text-slate-400 font-extrabold mb-4">
                        2
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">Lengkapi Biodata</h4>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-[200px]">Lengkapi data diri, nilai rapor semester 1-5, dan daftar prestasi.</p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center">
                    <div class="h-14 w-14 rounded-full bg-slate-900 border-2 border-slate-800 flex items-center justify-center text-xl text-slate-400 font-extrabold mb-4">
                        3
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">Unggah Berkas</h4>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-[200px]">Unggah berkas pendaftaran dan Surat Rekomendasi Guru BK MGBK.</p>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center text-center">
                    <div class="h-14 w-14 rounded-full bg-slate-900 border-2 border-slate-800 flex items-center justify-center text-xl text-slate-400 font-extrabold mb-4">
                        4
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">Tunggu Hasil</h4>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-[200px]">Hasil seleksi berkas dan wawancara akan diumumkan langsung di dashboard Anda.</p>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="max-w-7xl mx-auto px-6 pb-24">
            <div class="relative rounded-3xl overflow-hidden glassmorphism p-12 md:p-20 text-center shadow-2xl">
                <!-- Inner Blob -->
                <div class="absolute -top-1/2 left-1/2 -translate-x-1/2 w-[350px] h-[350px] rounded-full bg-indigo-500 filter blur-3xl opacity-15 -z-10"></div>

                <h2 class="heading-font text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-4">
                    Mulai Langkah Suksesmu Hari Ini!
                </h2>
                <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed mb-8">
                    Jangan lewatkan kesempatan emas untuk mengenyam pendidikan tinggi dengan dukungan dana penuh dari program Beasiswa MGBK.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-white hover:bg-slate-100 text-slate-950 font-bold transition-all duration-200 hover:-translate-y-0.5">
                        Daftar Akun Baru
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-slate-900 border border-slate-800 hover:border-slate-700 text-white font-bold transition-all duration-200">
                        Masuk Ke Portal <i class="fa-solid fa-right-to-bracket ml-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-slate-900 bg-slate-950 py-12">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
                <!-- Branding -->
                <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="heading-font font-bold text-sm text-white uppercase tracking-wider">
                        Portal MGBK Beasiswa © 2026
                    </span>
                </div>

                <!-- Links -->
                <div class="flex gap-8 text-xs font-semibold text-slate-500">
                    <a href="#" class="hover:text-slate-300 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-slate-300 transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-slate-300 transition-colors">Bantuan</a>
                </div>
            </div>
        </footer>
    </body>
</html>
