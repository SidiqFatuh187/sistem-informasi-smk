<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — SMK Wira Cipta Karya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#16233F',
                        navy: '#1E3A5F',
                        amber: '#E8A33D',
                        cream: '#F7F6F1',
                        slate: '#4B5563',
                    },
                    fontFamily: {
                        display: ['"Space Grotesk"', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .clip-panel {
            clip-path: polygon(8% 0%, 100% 0%, 100% 92%, 92% 100%, 0% 100%, 0% 8%);
        }
        .dot-grid {
            background-image: radial-gradient(#1E3A5F22 1.5px, transparent 1.5px);
            background-size: 18px 18px;
        }
        @media (prefers-reduced-motion: no-preference) {
            .fade-in-up { animation: fadeInUp 0.7s ease-out both; }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        a:focus-visible, button:focus-visible, input:focus-visible {
            outline: 2px solid #E8A33D;
            outline-offset: 2px;
        }
    </style>
</head>
<body class="bg-cream text-ink antialiased min-h-screen">

    <div class="relative min-h-screen overflow-hidden grid lg:grid-cols-12">

        {{-- SISI KIRI — BRANDING / DEKORASI --}}
        <div class="hidden lg:flex lg:col-span-5 relative bg-ink overflow-hidden flex-col justify-between p-12">
            <div class="absolute inset-0 dot-grid opacity-10 pointer-events-none"></div>

            <a href="/" class="flex items-center gap-3 relative z-10">
                <span class="w-10 h-10 rounded-full bg-amber flex items-center justify-center">
                    <span class="font-display font-bold text-ink text-sm">WCK</span>
                </span>
                <span class="font-display font-semibold text-lg text-cream leading-tight">
                    SMK Wira Cipta Karya
                </span>
            </a>

            <div class="relative z-10 fade-in-up">
                <p class="text-sm font-semibold tracking-wide text-amber mb-4">
                    Sistem Absensi Sekolah
                </p>
                <h1 class="font-display text-3xl xl:text-4xl leading-[1.15] font-semibold text-cream max-w-sm">
                    Rekap kehadiran siswa, rapi dan real-time.
                </h1>
                <p class="mt-5 text-cream/60 text-sm max-w-xs leading-relaxed">
                    Masuk sesuai peran kamu — admin, guru/wali kelas, atau kepala sekolah — untuk
                    mengelola dan memantau absensi harian.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-6 text-cream/50 text-xs">
                <span>© {{ date('Y') }} SMK Wira Cipta Karya</span>
                <span class="w-1 h-1 rounded-full bg-cream/30"></span>
                <span>Semua hak dilindungi</span>
            </div>
        </div>

        {{-- SISI KANAN — FORM LOGIN --}}
        <div class="lg:col-span-7 flex items-center justify-center px-6 py-16 relative">
            <div class="absolute inset-0 dot-grid opacity-40 pointer-events-none lg:hidden"></div>

            <div class="w-full max-w-md relative fade-in-up">

                {{-- Logo mobile --}}
                <a href="/" class="flex lg:hidden items-center gap-3 mb-10 justify-center">
                    <span class="w-10 h-10 rounded-full bg-ink flex items-center justify-center">
                        <span class="font-display font-bold text-amber text-sm">WCK</span>
                    </span>
                    <span class="font-display font-semibold text-lg text-ink">
                        SMK Wira Cipta Karya
                    </span>
                </a>

                <div class="bg-white clip-panel border border-ink/10 shadow-lg shadow-ink/5 p-8 sm:p-10">
                    <p class="text-sm font-semibold tracking-wide text-navy mb-2">
                        Selamat datang kembali
                    </p>
                    <h2 class="font-display text-2xl sm:text-3xl font-semibold text-ink">
                        Masuk ke akun kamu
                    </h2>
                    <p class="mt-2 text-sm text-slate">
                        Untuk admin, guru/wali kelas, dan kepala sekolah.
                    </p>

                    {{-- Notifikasi status session (misal: logout berhasil) --}}
                    @if (session('status'))
                        <div class="mt-6 rounded-xl bg-navy/10 border border-navy/20 text-navy text-sm px-4 py-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Error umum (misal: kredensial salah) --}}
                    @error('email')
                        <div class="mt-6 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('login.submit') }}" class="mt-8 space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-ink mb-2">
                                Email
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="nama@smkwck.sch.id"
                                class="w-full rounded-xl border border-ink/15 bg-cream/60 px-4 py-3 text-sm text-ink placeholder:text-slate/60 focus:border-navy focus:bg-white focus:outline-none transition-colors"
                            >
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password" class="block text-sm font-semibold text-ink">
                                    Kata sandi
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-navy hover:text-ink">
                                        Lupa kata sandi?
                                    </a>
                                @endif
                            </div>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full rounded-xl border border-ink/15 bg-cream/60 px-4 py-3 text-sm text-ink placeholder:text-slate/60 focus:border-navy focus:bg-white focus:outline-none transition-colors"
                            >
                            @error('password')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Ingat saya --}}
                        <div class="flex items-center gap-2">
                            <input
                                id="remember"
                                type="checkbox"
                                name="remember"
                                class="w-4 h-4 rounded border-ink/20 text-navy focus:ring-amber"
                            >
                            <label for="remember" class="text-sm text-slate">
                                Ingat saya di perangkat ini
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center px-7 py-3.5 rounded-full bg-ink text-cream text-sm font-semibold hover:bg-navy transition-colors"
                        >
                            Masuk
                        </button>
                    </form>

                    <p class="mt-8 text-xs text-slate text-center leading-relaxed">
                        Akun dibuatkan oleh admin sekolah. Hubungi admin atau tata usaha
                        jika belum memiliki akses.
                    </p>
                </div>

                <p class="mt-6 text-center text-xs text-slate">
                    <a href="/" class="hover:text-ink">&larr; Kembali ke beranda</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>