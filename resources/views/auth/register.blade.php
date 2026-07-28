<x-guest-layout>
    <div class="w-full max-w-xl mx-auto my-auto py-6">
        <div class="bg-slate-900/80 backdrop-blur-2xl border border-slate-800/90 shadow-2xl rounded-3xl p-8 sm:p-10 relative overflow-hidden">
            <!-- Top Accent Gradient Line -->
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-500"></div>

            <!-- Header -->
            <div class="text-center sm:text-left space-y-2 mb-8">
                <div class="flex items-center justify-center sm:justify-start gap-2.5 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/30">
                        <i class="fas fa-user-plus text-lg text-white"></i>
                    </div>
                    <span class="text-xl font-black text-white">
                        Supply<span class="text-indigo-400">Risk</span>
                    </span>
                </div>

                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    Buat Akun Baru 🚀
                </h2>
                <p class="text-slate-400 text-sm">
                    Bergabunglah untuk mengakses analitik risiko rantai pasok global secara langsung.
                </p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm flex items-start gap-3 backdrop-blur-md">
                    <i class="fas fa-exclamation-triangle text-rose-400 text-base flex-shrink-0 mt-0.5"></i>
                    <div class="space-y-1">
                        <p class="font-semibold text-rose-200">Gagal Mendaftar:</p>
                        <ul class="list-disc list-inside text-xs text-rose-300/90 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name Input -->
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                        <i class="fas fa-user text-indigo-400 mr-1.5"></i> Nama Lengkap
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-id-card text-slate-500"></i>
                        </div>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            autocomplete="name" 
                            placeholder="John Doe"
                            class="w-full pl-10 pr-4 py-3 bg-slate-950/70 border {{ $errors->has('name') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-800' }} rounded-xl text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                        />
                    </div>
                </div>

                <!-- Email Address Input -->
                <div class="space-y-2">
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                        <i class="fas fa-envelope text-indigo-400 mr-1.5"></i> Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-at text-slate-500"></i>
                        </div>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="username" 
                            placeholder="nama@perusahaan.com"
                            class="w-full pl-10 pr-4 py-3 bg-slate-950/70 border {{ $errors->has('email') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-800' }} rounded-xl text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                        />
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                        <i class="fas fa-lock text-indigo-400 mr-1.5"></i> Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-key text-slate-500"></i>
                        </div>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password" 
                            placeholder="••••••••••••"
                            class="w-full pl-10 pr-4 py-3 bg-slate-950/70 border {{ $errors->has('password') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-800' }} rounded-xl text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                        />
                    </div>
                </div>

                <!-- Confirm Password Input -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                        <i class="fas fa-shield-check text-indigo-400 mr-1.5"></i> Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-check-double text-slate-500"></i>
                        </div>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password" 
                            placeholder="••••••••••••"
                            class="w-full pl-10 pr-4 py-3 bg-slate-950/70 border {{ $errors->has('password_confirmation') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-800' }} rounded-xl text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                        />
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3.5 px-6 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-indigo-600 via-indigo-500 to-purple-600 hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2.5 group cursor-pointer"
                >
                    <span>Daftar Akun</span>
                    <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <!-- Footer: Login Prompt -->
            <div class="mt-8 pt-6 border-t border-slate-800/80 text-center">
                <p class="text-xs text-slate-400">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="text-indigo-400 font-bold hover:text-indigo-300 hover:underline transition-colors ml-1">
                        Masuk di Sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
