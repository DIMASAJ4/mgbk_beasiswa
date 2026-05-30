<x-guest-layout>
    <div class="mb-6">
        <h3 class="heading-font text-xl font-bold text-white">Daftar Akun Baru</h3>
        <p class="text-slate-400 text-xs mt-1">Lengkapi formulir di bawah ini untuk bergabung dengan Portal Beasiswa.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-regular fa-user"></i>
                </div>
                <input id="name" 
                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border border-slate-800 focus:border-indigo-500/80 focus:ring-2 focus:ring-indigo-500/10 rounded-xl text-sm text-slate-100 placeholder-slate-500 transition-all duration-200" 
                       type="text" 
                       name="name" 
                       :value="old('name')" 
                       placeholder="Nama lengkap Anda"
                       required 
                       autofocus 
                       autocomplete="name" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-rose-500" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <input id="email" 
                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border border-slate-800 focus:border-indigo-500/80 focus:ring-2 focus:ring-indigo-500/10 rounded-xl text-sm text-slate-100 placeholder-slate-500 transition-all duration-200" 
                       type="email" 
                       name="email" 
                       :value="old('email')" 
                       placeholder="nama@email.com"
                       required 
                       autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Kata Sandi</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <input id="password" 
                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border border-slate-800 focus:border-indigo-500/80 focus:ring-2 focus:ring-indigo-500/10 rounded-xl text-sm text-slate-100 placeholder-slate-500 transition-all duration-200" 
                       type="password" 
                       name="password" 
                       placeholder="Minimal 8 karakter"
                       required 
                       autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Konfirmasi Kata Sandi</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <input id="password_confirmation" 
                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border border-slate-800 focus:border-indigo-500/80 focus:ring-2 focus:ring-indigo-500/10 rounded-xl text-sm text-slate-100 placeholder-slate-500 transition-all duration-200" 
                       type="password" 
                       name="password_confirmation" 
                       placeholder="Ulangi kata sandi"
                       required 
                       autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-rose-500" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold text-sm transition-all duration-200 shadow-md shadow-indigo-600/10 hover:shadow-indigo-600/20 hover:-translate-y-0.5">
                Daftar Akun <i class="fa-solid fa-user-plus ml-2"></i>
            </button>
        </div>
    </form>

    <!-- Login CTA -->
    <div class="mt-8 pt-6 border-t border-slate-900 text-center">
        <p class="text-xs text-slate-400">Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-bold transition-colors ml-1">Masuk Sekarang</a>
        </p>
    </div>
</x-guest-layout>
