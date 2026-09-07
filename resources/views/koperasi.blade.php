<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi Sekolah — SMK Negeri 1 Indralaya Selatan</title>
    <meta name="description" content="Koperasi Sekolah SMK Negeri 1 Indralaya Selatan — segera hadir, menyediakan alat tulis, seragam, dan produk hasil praktik siswa.">

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
                        forest: '#1F7A46',
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
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .dot-grid {
            background-image: radial-gradient(#1E3A5F22 1.5px, transparent 1.5px);
            background-size: 18px 18px;
        }
        a:focus-visible, button:focus-visible {
            outline: 2px solid #E8A33D;
            outline-offset: 2px;
        }
    </style>
</head>
<body class="bg-cream text-ink antialiased">

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-50 bg-cream/90 backdrop-blur border-b border-ink/10">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 flex items-center justify-between h-16 sm:h-20 gap-3">
            <a href="{{ url('/') }}" class="flex items-center gap-2 sm:gap-3 shrink-0 min-w-0">
                <span class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-ink flex items-center justify-center shrink-0">
                    <span class="font-display font-bold text-amber text-[9px] sm:text-[11px]">SMKN 1</span>
                </span>
                <span class="font-display font-semibold text-sm sm:text-lg leading-tight truncate">
                    <span class="hidden sm:inline">SMK Negeri 1 Indralaya Selatan</span>
                    <span class="sm:hidden">SMKN 1 Indralaya Sel.</span>
                </span>
            </a>

            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-full border border-ink/20 text-xs sm:text-sm font-semibold text-ink hover:border-ink hover:bg-ink hover:text-cream transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
        </nav>
    </header>

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 dot-grid opacity-60 pointer-events-none"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-10 py-16 sm:py-24 relative text-center">
            <span class="inline-flex items-center gap-2 rounded-full bg-forest text-cream text-xs font-semibold px-4 py-1.5">
                Segera Hadir
            </span>
            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-semibold text-ink mt-5 leading-tight">
                Koperasi Sekolah
            </h1>
            <p class="mt-4 text-slate text-sm sm:text-base lg:text-lg max-w-xl mx-auto leading-relaxed">
                SMK Negeri 1 Indralaya Selatan sedang menyiapkan koperasi sekolah sebagai wadah
                praktik kewirausahaan siswa sekaligus penyedia kebutuhan sehari-hari warga sekolah.
                Halaman ini akan diperbarui begitu koperasi resmi beroperasi.
            </p>
        </div>
    </section>

    {{-- KATEGORI RENCANA --}}
    <section class="bg-white border-y border-ink/10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
            <h2 class="font-display text-xl sm:text-2xl font-semibold text-ink text-center mb-10">
                Rencana Kategori Produk
            </h2>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach ([
                    ['title' => 'Alat Tulis & Kebutuhan Sekolah', 'desc' => 'Buku, pulpen, dan perlengkapan belajar harian siswa.'],
                    ['title' => 'Seragam & Atribut', 'desc' => 'Seragam sekolah, dasi, badge, dan atribut resmi lainnya.'],
                    ['title' => 'Produk Hasil Praktik Siswa', 'desc' => 'Karya dari program keahlian, seperti produk elektronik sederhana hingga hasil perikanan.'],
                    ['title' => 'Jajanan & Minuman', 'desc' => 'Kebutuhan konsumsi ringan sehari-hari di lingkungan sekolah.'],
                ] as $kategori)
                    <div class="bg-cream border border-ink/10 rounded-2xl p-5 sm:p-6">
                        <span class="inline-block w-8 h-1.5 rounded-full bg-forest mb-4"></span>
                        <h3 class="font-display font-semibold text-ink text-sm sm:text-base leading-snug">{{ $kategori['title'] }}</h3>
                        <p class="text-xs sm:text-sm text-slate mt-2 leading-relaxed">{{ $kategori['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- INFO --}}
    <section class="bg-cream">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20 text-center">
            <div class="rounded-2xl bg-ink text-cream p-6 sm:p-8">
                <p class="text-xs uppercase tracking-[0.2em] text-amber font-semibold mb-3">Info Lebih Lanjut</p>
                <p class="text-sm sm:text-base text-cream/85 leading-relaxed">
                    Lokasi, jam operasional, dan katalog produk lengkap akan diumumkan melalui
                    halaman ini dan media informasi sekolah lainnya setelah koperasi resmi beroperasi.
                </p>
            </div>

            <a href="{{ url('/') }}#kontak"
               class="mt-8 inline-flex items-center gap-2 px-6 py-3 rounded-full bg-forest text-cream text-sm font-semibold hover:bg-forest/90 transition-colors">
                Hubungi Sekolah
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-ink/10">
        <p class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-6 text-xs text-slate text-center">
            © {{ date('Y') }} SMK Negeri 1 Indralaya Selatan — Tajam, Tangguh, Terpuji. Semua hak dilindungi.
        </p>
    </footer>
</body>
</html>