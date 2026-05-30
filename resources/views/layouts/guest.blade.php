<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pejuang Sukses') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

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
            .glassmorphism {
                background: rgba(15, 23, 42, 0.65);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
            .glow-blob {
                filter: blur(100px);
                opacity: 0.35;
            }
        </style>
    </head>
    <body class="bg-slate-950 text-slate-100 min-h-screen overflow-x-hidden relative flex flex-col justify-center items-center py-12 px-6">
        
        <!-- Background Blobs -->
        <div class="absolute top-[10%] left-[10%] w-[350px] h-[350px] rounded-full bg-indigo-600 glow-blob -z-10"></div>
        <div class="absolute bottom-[10%] right-[10%] w-[350px] h-[350px] rounded-full bg-purple-600 glow-blob -z-10"></div>

        <div class="mb-8 flex flex-col items-center">
            <a href="/" class="flex items-center gap-3 hover:scale-105 transition-transform duration-200">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo Pejuang Sukses" class="h-14 w-14 object-contain">
            </a>
            <h2 class="heading-font text-2xl font-extrabold tracking-wider bg-gradient-to-r from-white via-slate-100 to-indigo-300 bg-clip-text text-transparent mt-4">
                PEJUANG <span class="text-indigo-400">SUKSES</span>
            </h2>
            <p class="text-slate-500 text-xs mt-1 font-medium uppercase tracking-widest">Portal Pendaftaran Premium</p>
        </div>

        <!-- Glassmorphism Card Container -->
        <div class="w-full sm:max-w-md glassmorphism rounded-2xl p-8 shadow-2xl relative overflow-hidden">
            <!-- Decorative Accent line -->
            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
            
            {{ $slot }}
        </div>
    </body>
</html>
