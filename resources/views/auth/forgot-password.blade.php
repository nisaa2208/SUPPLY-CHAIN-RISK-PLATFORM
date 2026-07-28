<x-guest-layout>
    <div class="w-full max-w-md mx-auto my-auto py-6">
        <div class="bg-slate-900/80 backdrop-blur-2xl border border-slate-800/90 shadow-2xl rounded-3xl p-8 sm:p-10 relative overflow-hidden">
            <!-- Top Accent Gradient Line -->
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-500"></div>

            <!-- Header -->
            <div class="text-center sm:text-left space-y-2 mb-6">
                <div class="flex items-center justify-center sm:justify-start gap-2.5 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/30">
                        <i class="fas fa-key text-lg text-white"></i>
                    </div>
                    <span class="text-xl font-black text-white">
                        Supply<span class="text-indigo-400">Risk</span>
                    </span>
                </div>

                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Lupa Kata Sandi? 🔑
                </h2>
                <p class="text-slate-400 text-xs leading-relaxed">
                    Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan tautan reset kata sandi.
                </p>
            </div>

            <!-- Session Status Notification -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-3 backdrop-blur-md">
                    <i class="fas fa-check-circle text-emerald-400 text-sm flex-shrink-0"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

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
                            autofocus 
                            placeholder="nama@perusahaan.com"
                            class="w-full pl-10 pr-4 py-3 bg-slate-950/70 border {{ $errors->has('email') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-800' }} rounded-xl text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                        />
                    </div>
                    @if ($errors->has('email'))
                        <p class="text-xs text-rose-400 mt-1.5 flex items-center gap-1">
                            <i class="fas fa-circle-exclamation"></i> {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3.5 px-6 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-indigo-600 via-indigo-500 to-purple-600 hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 group cursor-pointer"
                >
                    <span>Kirim Tautan Reset</span>
                    <i class="fas fa-paper-plane text-xs group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <!-- Footer: Back to Login -->
            <div class="mt-8 pt-6 border-t border-slate-800/80 text-center">
                <a href="{{ route('login') }}" class="text-xs text-slate-400 hover:text-indigo-400 transition-colors inline-flex items-center gap-1.5 font-medium">
                    <i class="fas fa-arrow-left text-[10px]"></i> Kembali ke Halaman Masuk
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
