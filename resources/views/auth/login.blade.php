<x-guest-layout>
    <!-- Custom Autofill & High Contrast Dark Theme Styles -->
    <style>
        .login-card-glass {
            background-color: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7) !important;
        }
        .login-input-dark {
            background-color: #090d16 !important;
            color: #ffffff !important;
            border: 1px solid #334155 !important;
        }
        .login-input-dark:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25) !important;
        }
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #090d16 inset !important;
            -webkit-text-fill-color: #ffffff !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <div class="w-full max-w-6xl mx-auto my-auto py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Left Hero Section: Platform Showcase (Visible on Large Screens) -->
            <div class="lg:col-span-7 space-y-8 pr-0 lg:pr-6 hidden lg:block">
                <!-- Status Badge -->
                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-slate-900 border border-indigo-500/30 text-xs font-bold text-indigo-300 shadow-lg" style="background-color: #0f172a;">
                    <span class="flex h-2.5 w-2.5 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    GLOBAL RISK MONITORING PLATFORM &bull; SYSTEM ONLINE
                </div>

                <!-- Main Branding Heading -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 border border-indigo-400/30" style="background-color: #4f46e5;">
                            <i class="fas fa-shield-alt text-2xl text-white"></i>
                        </div>
                        <span class="text-2xl font-black tracking-tight text-white">
                            Supply<span class="text-indigo-400" style="color: #818cf8;">Risk</span>
                        </span>
                    </div>
                    
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Intelijen Risiko <br/>
                        <span class="text-indigo-400" style="color: #818cf8;">
                            Rantai Pasok Global
                        </span>
                    </h1>

                    <p class="text-slate-300 text-base lg:text-lg leading-relaxed max-w-xl" style="color: #cbd5e1;">
                        Platform analitis waktu-nyata yang mengintegrasikan data iklim, berita global, indikator makroekonomi, dan rute pelabuhan maritim untuk mitigasi risiko proaktif.
                    </p>
                </div>

                <!-- Feature Grid Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800" style="background-color: #0f172a; border-color: #1e293b;">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center mb-3">
                            <i class="fas fa-globe-americas text-lg" style="color: #818cf8;"></i>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Geospatial Risk Sentinel</h4>
                        <p class="text-xs text-slate-400 leading-relaxed" style="color: #94a3b8;">Pemantauan 120+ negara & pelabuhan maritim utama secara langsung.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800" style="background-color: #0f172a; border-color: #1e293b;">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center mb-3">
                            <i class="fas fa-calculator text-lg" style="color: #c084fc;"></i>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">AI Weighted Risk Engine</h4>
                        <p class="text-xs text-slate-400 leading-relaxed" style="color: #94a3b8;">Skor prediktif otomatis gabungan inflasi, cuaca, & sentimen berita.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800" style="background-color: #0f172a; border-color: #1e293b;">
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center mb-3">
                            <i class="fas fa-satellite-dish text-lg" style="color: #22d3ee;"></i>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Multi-API Ingestion</h4>
                        <p class="text-xs text-slate-400 leading-relaxed" style="color: #94a3b8;">Sinkronisasi otomatis World Bank, OpenWeather & News API.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800" style="background-color: #0f172a; border-color: #1e293b;">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-3">
                            <i class="fas fa-bolt text-lg" style="color: #34d399;"></i>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Early Warning Alerts</h4>
                        <p class="text-xs text-slate-400 leading-relaxed" style="color: #94a3b8;">Peringatan otomatis dampak gangguan logistik & nilai tukar.</p>
                    </div>
                </div>

                <!-- Footer Quick Metric Bar -->
                <div class="flex items-center gap-6 pt-2 border-t border-slate-800 text-xs text-slate-400 font-medium" style="border-color: #1e293b; color: #94a3b8;">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-emerald-400"></i>
                        <span>Operational SLA 99.9%</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-lock text-indigo-400"></i>
                        <span>Encrypted Session</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-network-wired text-cyan-400"></i>
                        <span>Multi-Region Sync</span>
                    </div>
                </div>
            </div>

            <!-- Right Form Section: Glassmorphic Login Card -->
            <div class="lg:col-span-5 w-full">
                <div class="login-card-glass shadow-2xl rounded-3xl p-8 sm:p-10 relative overflow-hidden">
                    <!-- Top Accent Gradient Line -->
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-500" style="background: linear-gradient(90deg, #6366f1, #a855f7, #06b6d4);"></div>

                    <!-- Header Mobile Brand & Title -->
                    <div class="text-center sm:text-left space-y-2 mb-8">
                        <div class="flex items-center justify-center sm:justify-start gap-2.5 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/30" style="background-color: #4f46e5;">
                                <i class="fas fa-shield-alt text-lg text-white"></i>
                            </div>
                            <span class="text-xl font-black text-white">
                                Supply<span class="text-indigo-400" style="color: #818cf8;">Risk</span>
                            </span>
                        </div>

                        <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                            Selamat Datang 👋
                        </h2>
                        <p class="text-slate-400 text-sm" style="color: #94a3b8;">
                            Masukkan akun Anda untuk mengakses Dashboard Intelijen Risk.
                        </p>
                    </div>

                    <!-- Session Status Notification -->
                    @if (session('status'))
                        <div class="mb-6 p-4 rounded-xl text-sm flex items-center gap-3" style="background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #6ee7b7;">
                            <i class="fas fa-check-circle text-emerald-400 text-base flex-shrink-0"></i>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    <!-- Validation Errors Overview (if multiple) -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-xl text-sm flex items-start gap-3" style="background-color: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.3); color: #fca5a5;">
                            <i class="fas fa-exclamation-triangle text-rose-400 text-base flex-shrink-0 mt-0.5"></i>
                            <div class="space-y-1">
                                <p class="font-semibold" style="color: #fecdd3;">Gagal Masuk:</p>
                                <ul class="list-disc list-inside text-xs space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email Address Input -->
                        <div class="space-y-2">
                            <label for="email" class="block text-xs font-semibold uppercase tracking-wider" style="color: #cbd5e1;">
                                <i class="fas fa-envelope text-indigo-400 mr-1.5" style="color: #818cf8;"></i> ALAMAT EMAIL
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none" style="color: #64748b;">
                                    <i class="fas fa-at"></i>
                                </div>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autofocus 
                                    autocomplete="username" 
                                    placeholder="nama@perusahaan.com"
                                    class="login-input-dark w-full pl-10 pr-4 py-3 rounded-xl text-sm focus:outline-none transition-all duration-200"
                                />
                            </div>
                            @if ($errors->has('email'))
                                <p class="text-xs text-rose-400 mt-1.5 flex items-center gap-1" style="color: #fb7185;">
                                    <i class="fas fa-circle-exclamation"></i> {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <!-- Password Input -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-xs font-semibold uppercase tracking-wider" style="color: #cbd5e1;">
                                    <i class="fas fa-lock text-indigo-400 mr-1.5" style="color: #818cf8;"></i> KATA SANDI
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs font-medium hover:underline" style="color: #818cf8;">
                                        Lupa kata sandi?
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none" style="color: #64748b;">
                                    <i class="fas fa-key"></i>
                                </div>
                                <input 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    required 
                                    autocomplete="current-password" 
                                    placeholder="••••••••••••"
                                    class="login-input-dark w-full pl-10 pr-11 py-3 rounded-xl text-sm focus:outline-none transition-all duration-200"
                                />
                                <button 
                                    type="button" 
                                    onclick="togglePasswordVisibility()" 
                                    tabindex="-1"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center transition-colors focus:outline-none" style="color: #94a3b8;"
                                >
                                    <i id="eyeIcon" class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                            @if ($errors->has('password'))
                                <p class="text-xs text-rose-400 mt-1.5 flex items-center gap-1" style="color: #fb7185;">
                                    <i class="fas fa-circle-exclamation"></i> {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="flex items-center justify-between pt-1">
                            <label for="remember_me" class="inline-flex items-center gap-2.5 cursor-pointer group">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    name="remember" 
                                    class="w-4 h-4 rounded cursor-pointer"
                                    style="accent-color: #6366f1;"
                                >
                                <span class="text-xs font-medium" style="color: #cbd5e1;">
                                    Ingat Saya di perangkat ini
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit" 
                            id="submitBtn"
                            class="w-full py-3.5 px-6 rounded-xl font-bold text-sm text-white shadow-lg transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2.5 cursor-pointer"
                            style="background: linear-gradient(90deg, #4f46e5 0%, #6366f1 50%, #8b5cf6 100%); color: #ffffff !important;"
                        >
                            <span class="text-white font-bold">Masuk ke Platform</span>
                            <i class="fas fa-arrow-right text-xs text-white"></i>
                        </button>
                    </form>

                    <!-- Quick Demo Credentials Box -->
                    <div class="mt-6 p-3 rounded-xl border text-xs" style="background-color: rgba(30, 41, 59, 0.7); border-color: #334155; color: #cbd5e1;">
                        <p class="font-bold mb-1 text-amber-400" style="color: #fbbf24;"><i class="fas fa-info-circle mr-1"></i> Akun Pengujian (Demo):</p>
                        <div class="flex justify-between items-center text-[11px] mb-1">
                            <span>🛡️ <strong>Admin:</strong> admin@gmail.com</span>
                            <span class="text-slate-400">Pass: password</span>
                        </div>
                        <div class="flex justify-between items-center text-[11px]">
                            <span>👤 <strong>User:</strong> user@gmail.com</span>
                            <span class="text-slate-400">Pass: password</span>
                        </div>
                    </div>

                    <!-- Footer: Register Prompt -->
                    @if (Route::has('register'))
                        <div class="mt-6 pt-4 border-t text-center" style="border-color: #1e293b;">
                            <p class="text-xs" style="color: #94a3b8;">
                                Belum memiliki akun? 
                                <a href="{{ route('register') }}" class="font-bold hover:underline ml-1 inline-flex items-center gap-1" style="color: #818cf8;">
                                    Daftar Akun Baru <i class="fas fa-chevron-right text-[10px]"></i>
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Password Visibility Toggle Script -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>
