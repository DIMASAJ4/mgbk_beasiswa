<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MGBK Beasiswa') }} - Masuk</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .heading-font {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-[#f0f2f5] text-slate-800 min-h-screen flex flex-col md:flex-row h-full">

    {{-- Left Panel: Dark Blue Sidebar (#1a3d6e) --}}
    <div class="w-full md:w-1/2 lg:w-5/12 bg-[#1a3d6e] p-10 md:p-16 flex flex-col justify-between text-white relative overflow-hidden shrink-0 shadow-2xl">
        {{-- Ambient Blobs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-[#1D9E75]/10 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full bg-blue-900/40 blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <!-- Brand Logo -->
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white">
                    <i class="fa-solid fa-graduation-cap text-xl"></i>
                </div>
                <div>
                    <h2 class="heading-font text-base font-extrabold text-white leading-tight">MGBK Beasiswa</h2>
                    <p class="text-[10px] text-blue-200 font-bold uppercase tracking-wider">Musyawarah Guru BK</p>
                </div>
            </div>
        </div>

        <!-- Headline & Description -->
        <div class="relative z-10 my-10 md:my-0">
            <h1 class="heading-font text-3xl sm:text-4xl md:text-3xl lg:text-4xl font-extrabold text-white leading-tight tracking-tight">
                Wujudkan Masa Depan Gemilang Melalui Pendidikan.
            </h1>
            <p class="text-blue-100/80 text-xs sm:text-sm font-medium mt-4 leading-relaxed max-w-md">
                Aplikasi pendaftaran, pencocokan cerdas, dan rekomendasi beasiswa MGBK berbasis kompetensi akademik serta minat karir siswa.
            </p>

            {{-- Tablet Mockup --}}
            <div class="hidden lg:block relative mt-12 w-full max-w-sm mx-auto aspect-[4/3] bg-slate-900 border-4 border-slate-950 p-2.5 rounded-3xl shadow-2xl overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-tr from-[#1a3d6e]/20 to-white/5 pointer-events-none"></div>
                <!-- Tablet Screen Display -->
                <div class="h-full bg-[#f0f2f5] rounded-2xl p-4 flex flex-col justify-between text-slate-800 text-[10px] select-none font-semibold">
                    <div class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2">
                        <span class="font-bold text-[#1a3d6e]">Siswa Dashboard</span>
                        <div class="flex gap-1">
                            <span class="h-1.5 w-1.5 rounded-full bg-slate-350"></span>
                            <span class="h-1.5 w-1.5 rounded-full bg-slate-350"></span>
                        </div>
                    </div>
                    
                    <div class="flex-1 flex flex-col justify-between gap-2.5">
                        <!-- Mini stat cards inside tablet -->
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-white border border-slate-100 rounded-xl p-2 shadow-sm">
                                <span class="text-slate-400 block text-[7px] uppercase tracking-wide">Kecocokan</span>
                                <span class="font-black text-[#1D9E75] text-xs mt-0.5 block">95% Cocok</span>
                            </div>
                            <div class="bg-white border border-slate-100 rounded-xl p-2 shadow-sm">
                                <span class="text-slate-400 block text-[7px] uppercase tracking-wide">Beasiswa Aktif</span>
                                <span class="font-black text-[#1a3d6e] text-xs mt-0.5 block">15 Program</span>
                            </div>
                        </div>

                        <!-- Mini chart inside tablet -->
                        <div class="bg-white border border-slate-100 rounded-xl p-2.5 shadow-sm flex-1 flex flex-col justify-between">
                            <span class="text-slate-450 text-[7px] block uppercase tracking-wide mb-1">Akademis & Minat Rata-Rata</span>
                            <div class="flex items-end justify-between gap-1 flex-1">
                                <div class="bg-[#1a3d6e] w-full rounded-t-sm" style="height: 60%"></div>
                                <div class="bg-[#1D9E75] w-full rounded-t-sm" style="height: 85%"></div>
                                <div class="bg-[#e8f4f0] w-full rounded-t-sm border border-[#1D9E75]/20" style="height: 45%"></div>
                                <div class="bg-[#1a3d6e]/20 w-full rounded-t-sm" style="height: 70%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Panel Footer -->
        <div class="relative z-10 hidden md:block">
            <p class="text-[10px] text-blue-200/60 font-semibold uppercase tracking-wider">&copy; 2024 MGBK Beasiswa</p>
        </div>
    </div>

    {{-- Right Panel: Clean White Form --}}
    <div class="flex-1 bg-white flex flex-col justify-between p-8 sm:p-12 md:p-16 lg:p-24 shadow-inner">
        <!-- Spacer top -->
        <div class="hidden md:block"></div>

        <!-- Central Login Form Card -->
        <div class="max-w-md w-full mx-auto my-auto space-y-8">
            <div class="space-y-2">
                <h3 class="heading-font text-3xl font-extrabold text-[#1a3d6e] tracking-tight">Selamat Datang</h3>
                <p class="text-slate-500 text-xs sm:text-sm font-semibold">Silakan masukkan akun Anda untuk melanjutkan ke portal</p>
            </div>

            <!-- Validation Error Status -->
            @if ($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-xs font-semibold flex items-center gap-2.5 shadow-sm">
                    <i class="fa-solid fa-circle-exclamation text-sm shrink-0"></i>
                    <div>
                        <p class="font-bold">Gagal masuk!</p>
                        <p class="text-[11px] text-rose-600/80 mt-0.5">Email atau kata sandi yang Anda masukkan salah.</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email field -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-xs">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input id="email" 
                               class="block w-full pl-10 pr-4 py-3.5 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-400 shadow-sm transition-all" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Contoh: guru@mgbk.mail"
                               required 
                               autofocus />
                    </div>
                </div>

                <!-- Password field -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-xs">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input id="password" 
                               class="block w-full pl-10 pr-10 py-3.5 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 placeholder-slate-450 shadow-sm transition-all"
                               type="password"
                               name="password"
                               placeholder="••••••••"
                               required />
                        <!-- Password Show/Hide Toggle -->
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-450 hover:text-slate-650 text-xs cursor-pointer">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" 
                               type="checkbox" 
                               class="h-4.5 w-4.5 rounded border-slate-300 text-[#1D9E75] bg-white focus:ring-[#1D9E75] focus:ring-offset-0 cursor-pointer" 
                               name="remember">
                        <label for="remember" class="ms-2 text-xs text-slate-500 font-bold cursor-pointer select-none">Ingat saya</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="text-xs text-[#1D9E75] hover:text-[#1a3d6e] font-bold transition-colors" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white font-bold text-sm transition-all shadow-md shadow-[#1D9E75]/10 hover:shadow-[#1D9E75]/20 flex items-center justify-center gap-2 cursor-pointer">
                        Masuk ke Akun <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                    </button>
                </div>
            </form>

            <!-- Support CTA -->
            <div class="text-center pt-2">
                <a href="mailto:support@mgbk.id" class="text-[11px] text-slate-450 hover:text-[#1a3d6e] font-bold transition-all">
                    Kesulitan masuk? Hubungi Admin
                </a>
            </div>
        </div>

        <!-- Right Panel Footer -->
        <div class="text-center pt-8 border-t border-slate-100">
            <p class="text-[10px] text-slate-450 font-black tracking-wider uppercase">
                MUSYAWARAH GURU BK KOTA PADANGSIDIMPUAN
            </p>
        </div>
    </div>

    <!-- Vanilla Javascript for Toggle Password Visibility -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            // toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // toggle the eye icon
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    </script>
</body>
</html>
