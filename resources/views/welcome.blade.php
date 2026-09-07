<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK Negeri 1 Indralaya Selatan — Tajam, Tangguh, Terpuji</title>
    <meta name="description" content="SMK Negeri 1 Indralaya Selatan, terakreditasi A, membuka 7 program keahlian: Teknik Ketenagalistrikan, TJKT, PPLG, Teknik Elektronika, Agribisnis Perikanan, Broadcasting & Perfilman, dan Teknik Pengelasan & Fabrikasi Logam.">

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
            <a href="/" class="flex items-center gap-2 sm:gap-3 shrink-0 min-w-0">
                <span class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-ink flex items-center justify-center shrink-0">
                    <span class="font-display font-bold text-amber text-[9px] sm:text-[11px]">SMKN 1</span>
                </span>
                <span class="font-display font-semibold text-sm sm:text-lg leading-tight truncate">
                    <span class="hidden sm:inline">SMK Negeri 1 Indralaya Selatan</span>
                    <span class="sm:hidden">SMKN 1 Indralaya Sel.</span>
                </span>
            </a>

            <ul class="hidden md:flex items-center gap-6 lg:gap-8 text-sm font-medium text-slate">
                <li><a href="#tentang" class="hover:text-ink transition-colors">Tentang</a></li>
                <li><a href="#program" class="hover:text-ink transition-colors">Program Keahlian</a></li>
                <li><a href="#fasilitas" class="hover:text-ink transition-colors">Fasilitas</a></li>
                <li><a href="#kontak" class="hover:text-ink transition-colors">Kontak</a></li>
            </ul>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <a href="{{ route('login') }}"
                   class="hidden sm:inline-flex items-center px-4 lg:px-5 py-2 lg:py-2.5 rounded-full border border-ink/20 text-xs lg:text-sm font-semibold text-ink hover:border-ink hover:bg-ink hover:text-cream transition-colors">
                    Masuk
                </a>
                <a href="#spmb"
                   class="inline-flex items-center px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-full bg-amber text-ink text-xs sm:text-sm font-semibold hover:bg-ink hover:text-amber transition-colors whitespace-nowrap">
                    Daftar SPMB
                </a>
                <button id="menuBtn" aria-label="Buka menu" aria-expanded="false" class="md:hidden p-1.5 sm:p-2 text-ink shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>
            </div>
        </nav>

        <div id="mobileMenu" class="hidden md:hidden border-t border-ink/10 bg-cream px-4 sm:px-6 py-4 space-y-3 text-sm font-medium text-slate">
            <a href="#tentang" class="block py-1">Tentang</a>
            <a href="#program" class="block py-1">Program Keahlian</a>
            <a href="#fasilitas" class="block py-1">Fasilitas</a>
            <a href="#kontak" class="block py-1">Kontak</a>
            <a href="{{ route('login') }}" class="block py-2 font-semibold text-ink">Masuk</a>
        </div>
    </header>

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 dot-grid opacity-60 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-10 sm:py-16 lg:py-24 relative grid lg:grid-cols-12 gap-10 lg:gap-12 items-center">

            <div class="lg:col-span-6 fade-in-up">
                <p class="text-xs sm:text-sm font-semibold tracking-wide text-navy mb-3 sm:mb-4">
                    Terakreditasi A · Tahun Ajaran 2026/2027
                </p>
                <h1 class="font-display text-3xl sm:text-4xl md:text-5xl lg:text-[3.2rem] leading-[1.15] sm:leading-[1.1] font-semibold text-ink">
                    SMK Negeri 1 Indralaya Selatan
                </h1>
                <p class="mt-3 font-display text-lg sm:text-xl text-amber font-semibold">
                    Tajam, Tangguh, Terpuji
                </p>
                <p class="mt-5 sm:mt-6 text-slate text-sm sm:text-base lg:text-lg max-w-md leading-relaxed">
                    Tujuh program keahlian dengan praktik langsung, kerja sama industri nasional,
                    dan bekal sertifikasi kompetensi — supaya lulusan siap kerja, siap wirausaha,
                    dan siap melanjutkan pendidikan.
                </p>
                <div class="mt-7 sm:mt-8 flex flex-wrap items-center gap-3 sm:gap-4">
                    <a href="https://s.id/SPMBSMKINTAN2026" target="_blank" rel="noopener"
                       class="inline-flex items-center px-6 sm:px-7 py-3 sm:py-3.5 rounded-full bg-ink text-cream text-sm font-semibold hover:bg-navy transition-colors">
                        Daftar SPMB 2026/2027
                    </a>
                    <a href="#program" class="inline-flex items-center px-6 sm:px-7 py-3 sm:py-3.5 rounded-full border border-ink/20 text-sm font-semibold text-ink hover:border-ink transition-colors">
                        Lihat Program Keahlian
                    </a>
                </div>

                <dl class="mt-10 sm:mt-14 grid grid-cols-3 gap-3 sm:gap-6 max-w-md">
                    <div>
                        <dt class="sr-only">Program keahlian</dt>
                        <dd class="font-display text-xl sm:text-2xl font-semibold text-ink">7</dd>
                        <p class="text-[11px] sm:text-xs text-slate mt-1 leading-snug">Program keahlian</p>
                    </div>
                    <div>
                        <dt class="sr-only">Akreditasi</dt>
                        <dd class="font-display text-xl sm:text-2xl font-semibold text-ink">A</dd>
                        <p class="text-[11px] sm:text-xs text-slate mt-1 leading-snug">Akreditasi sekolah</p>
                    </div>
                    <div>
                        <dt class="sr-only">Mitra industri</dt>
                        <dd class="font-display text-xl sm:text-2xl font-semibold text-ink">8+</dd>
                        <p class="text-[11px] sm:text-xs text-slate mt-1 leading-snug">Mitra industri & MOU</p>
                    </div>
                </dl>
            </div>

            <div class="lg:col-span-6 relative fade-in-up" style="animation-delay:.15s">
                <div class="rounded-2xl sm:rounded-3xl border border-ink/10 shadow-xl shadow-ink/10 aspect-[1600/1081] w-full overflow-hidden bg-navy">
                    <img src="{{ asset('images/gedung-sekolah.jpg') }}"
                         alt="Gedung SMK Negeri 1 Indralaya Selatan"
                         class="w-full h-full object-cover">
                </div>

                <div class="mt-4 flex flex-wrap gap-3">
                    <div class="flex-1 min-w-[45%] sm:min-w-0 sm:flex-none bg-white rounded-2xl shadow-lg shadow-ink/10 px-4 sm:px-5 py-3.5 sm:py-4">
                        <p class="font-display font-semibold text-ink text-xs sm:text-sm">Akreditasi A</p>
                        <p class="text-[11px] sm:text-xs text-slate mt-1 leading-snug">Badan Akreditasi Nasional Sekolah/Madrasah</p>
                    </div>

                    <div class="flex-1 min-w-[45%] sm:min-w-0 sm:flex-none bg-amber rounded-2xl shadow-lg shadow-ink/10 px-4 sm:px-5 py-3.5 sm:py-4">
                        <p class="font-display font-semibold text-ink text-xs sm:text-sm">Kelas Industri</p>
                        <p class="text-[11px] sm:text-xs text-ink/70 mt-1 leading-snug">Program magang hingga ke Jepang</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- VISI MISI --}}
    <section id="tentang" class="bg-white border-y border-ink/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
            <div class="grid lg:grid-cols-12 gap-8 sm:gap-10 lg:gap-16">
                <div class="lg:col-span-4">
                    <h2 class="font-display text-2xl sm:text-3xl font-semibold text-ink leading-tight">
                        Visi &amp; Misi Sekolah
                    </h2>
                    <div class="mt-5 sm:mt-6 rounded-2xl bg-ink text-cream p-5 sm:p-6">
                        <p class="text-xs uppercase tracking-[0.2em] text-amber font-semibold mb-2">Visi</p>
                        <p class="text-sm leading-relaxed text-cream/90">
                            Terwujudnya lulusan beriman dan bertaqwa, berkarakter, berinovasi,
                            berwirausaha, siap kerja, unggul dalam kompetensi Nasional dan Internasional.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <p class="text-xs uppercase tracking-[0.2em] text-navy font-semibold mb-4">Misi</p>
                    <ul class="grid sm:grid-cols-2 gap-x-8 lg:gap-x-10 gap-y-4 sm:gap-y-5">
                        @foreach ([
                            'Mewujudkan generasi beriman dan bertaqwa kepada Tuhan Yang Maha Esa.',
                            'Mewujudkan peserta didik yang berkepribadian sesuai dengan Profil Pelajar Pancasila.',
                            'Membina kemandirian peserta didik melalui kewirausahaan dan teaching factory dengan pengembangan diri yang terencana dan berkesinambungan.',
                            'Mengembangkan semangat keunggulan dengan sikap kreatif, inovatif, dan disiplin.',
                            'Membangun kerjasama dengan Dunia Usaha/Dunia Industri (DUDI) secara nasional dan internasional.',
                            'Membekali siswa dengan keterampilan soft skill dan hard skill untuk bersaing di dunia kerja.',
                            'Mewujudkan lulusan yang mampu bersaing di tingkat nasional dan internasional.',
                        ] as $misi)
                            <li class="flex gap-3 text-sm text-slate leading-relaxed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-forest shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span>{{ $misi }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- PROGRAM KEAHLIAN --}}
    <section id="program" class="bg-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 sm:gap-4 mb-10 sm:mb-12">
                <h2 class="font-display text-2xl sm:text-3xl font-semibold text-ink">Program Keahlian</h2>
                <p class="text-sm text-slate max-w-sm">Tujuh jurusan dengan keterampilan dan peluang kerja
                    yang jelas sejak awal masuk.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @php
                    $programs = [
                        ['name' => 'Teknik Ketenagalistrikan', 'accent' => 'bg-red-600', 'desc' => 'Merakit, memasang, dan merawat instalasi listrik AC/DC hingga pengendali PLC.', 'prospek' => 'Industri kelistrikan, konsultan, instalatir'],
                        ['name' => 'Teknik Jaringan Komputer & Telekomunikasi', 'accent' => 'bg-emerald-600', 'desc' => 'Instalasi, administrasi server, dan perbaikan jaringan komputer.', 'prospek' => 'Teknisi jaringan, admin infrastruktur IT'],
                        ['name' => 'Pengembangan Perangkat Lunak & Gim', 'accent' => 'bg-blue-600', 'desc' => 'Pemrograman, desain web, dan pengembangan aplikasi/game.', 'prospek' => 'Programmer, web developer, IT consultant'],
                        ['name' => 'Teknik Elektronika', 'accent' => 'bg-rose-700', 'desc' => 'Kendali sistem mekatronika, mikroprosesor, dan PLC.', 'prospek' => 'Industri kontrol, manufaktur, penerbangan'],
                        ['name' => 'Agribisnis Perikanan', 'accent' => 'bg-sky-700', 'desc' => 'Budi daya, pengelolaan pakan, dan pemasaran ikan air tawar.', 'prospek' => 'Dinas perikanan, balai benih, wirausaha'],
                        ['name' => 'Broadcasting & Perfilman', 'accent' => 'bg-cyan-700', 'desc' => 'Produksi program TV, videografi, dan public speaking.', 'prospek' => 'Penyiar, editor video, TVRI/Sriwijaya TV'],
                        ['name' => 'Teknik Pengelasan & Fabrikasi Logam', 'accent' => 'bg-violet-700', 'desc' => 'Teknik las baja karbon sesuai standar SOP/WPS.', 'prospek' => 'Konstruksi baja, instalasi pemipaan, otomotif'],
                    ];
                @endphp

                @foreach ($programs as $p)
                    <div class="bg-white border border-ink/10 rounded-2xl p-5 sm:p-7 hover:shadow-md transition-shadow">
                        <span class="inline-block w-8 h-1.5 rounded-full {{ $p['accent'] }} mb-4 sm:mb-5"></span>
                        <h3 class="font-display font-semibold text-ink text-base sm:text-lg leading-snug">{{ $p['name'] }}</h3>
                        <p class="text-sm text-slate mt-2.5 sm:mt-3 leading-relaxed">{{ $p['desc'] }}</p>
                        <p class="text-xs text-navy font-semibold mt-3.5 sm:mt-4">Prospek: {{ $p['prospek'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FASILITAS & EKSTRAKURIKULER --}}
    <section id="fasilitas" class="bg-white border-y border-ink/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20 grid lg:grid-cols-2 gap-10 sm:gap-12">
            <div>
                <h2 class="font-display text-xl sm:text-2xl font-semibold text-ink mb-5 sm:mb-6">Fasilitas Sekolah</h2>
                <ul class="grid sm:grid-cols-2 gap-x-6 gap-y-2.5 sm:gap-y-3 text-sm text-slate">
                    @foreach ([
                        'Ruang Kelas Representatif', 'Ruang Bimbingan Konseling', 'Ruang Praktikum Semua Jurusan',
                        'Laboratorium Komputer', 'Perpustakaan', 'Ruang UKS', 'Gedung Pertemuan',
                        'Lapangan Olahraga', 'Mushola', 'Gazebo', 'Taman & Tempat Parkir', 'Program Magang ke Jepang',
                    ] as $fasilitas)
                        <li class="flex gap-2">
                            <span class="text-amber">•</span> {{ $fasilitas }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="font-display text-xl sm:text-2xl font-semibold text-ink mb-5 sm:mb-6">Ekstrakurikuler</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach (['Pramuka', 'Futsal', 'PMR', 'Pencak Silat', 'KIR', 'Seni Musik, Tari & Paduan Suara', 'Rohis', 'Volly', 'Paskibra'] as $eskul)
                        <span class="inline-flex items-center px-3.5 sm:px-4 py-1.5 sm:py-2 rounded-full bg-cream border border-ink/10 text-xs sm:text-sm text-ink">
                            {{ $eskul }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- MITRA INDUSTRI --}}
    <section class="bg-ink">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-10 sm:py-14">
            <p class="text-center text-xs uppercase tracking-[0.2em] sm:tracking-[0.3em] text-cream/50 font-semibold mb-6 sm:mb-8">
                Mitra Industri &amp; MOU Kerja Sama
            </p>
            <div class="bg-white rounded-2xl p-4 sm:p-6 flex justify-center overflow-x-auto">
                <img src="{{ asset('images/mitra-industri.jpg') }}" alt="Logo mitra industri dan MOU kerja sama SMKN 1 Indralaya Selatan"
                     class="max-w-full h-auto">
            </div>
        </div>
    </section>

    {{-- SPMB CTA --}}
    <section id="spmb" class="bg-amber">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-12 sm:py-16 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 sm:gap-8">
            <div class="max-w-xl">
                <h2 class="font-display text-2xl sm:text-3xl font-semibold text-ink">
                    Sistem Penerimaan Murid Baru (SPMB) 2026/2027
                </h2>
                <p class="mt-3 text-ink/80 leading-relaxed text-sm sm:text-base">
                    Pendaftaran online, tanpa perlu datang ke sekolah dulu. Isi formulir melalui
                    tautan resmi berikut.
                </p>
            </div>
            <a href="https://s.id/SPMBSMKINTAN2026" target="_blank" rel="noopener"
               class="inline-flex items-center justify-center px-6 sm:px-8 py-3.5 sm:py-4 rounded-full bg-ink text-cream font-semibold text-xs sm:text-sm hover:bg-navy transition-colors shrink-0 text-center break-all sm:break-normal">
                s.id/SPMBSMKINTAN2026
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer id="kontak" class="bg-white border-t border-ink/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-12 sm:py-16 grid sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10">
            <div>
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-full bg-ink flex items-center justify-center shrink-0">
                        <span class="font-display font-bold text-amber text-[10px]">SMKN 1</span>
                    </span>
                    <span class="font-display font-semibold text-ink text-sm sm:text-base">SMK Negeri 1 Indralaya Selatan</span>
                </div>
                <p class="mt-4 text-sm text-slate leading-relaxed">
                    Jl. Raya Tanah Tinggi, Meranjat I, Kec. Indralaya Selatan,
                    Kab. Ogan Ilir, Sumatera Selatan
                </p>
            </div>
            <div>
                <p class="font-display font-semibold text-ink text-sm">Sekolah</p>
                <ul class="mt-4 space-y-2 text-sm text-slate">
                    <li><a href="#tentang" class="hover:text-ink">Tentang Kami</a></li>
                    <li><a href="#program" class="hover:text-ink">Program Keahlian</a></li>
                    <li><a href="#fasilitas" class="hover:text-ink">Fasilitas</a></li>
                </ul>
            </div>
            <div>
                <p class="font-display font-semibold text-ink text-sm">Informasi</p>
                <ul class="mt-4 space-y-2 text-sm text-slate">
                    <li><a href="#spmb" class="hover:text-ink">SPMB 2026/2027</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-ink">Masuk Akun</a></li>
                </ul>
            </div>
            <div>
                <p class="font-display font-semibold text-ink text-sm">Contact Person PPDB</p>
                <ul class="mt-4 space-y-1.5 text-sm text-slate">
                    <li>0852-6726-2878 (Zaidah, S.Ag)</li>
                    <li>0813-7985-2802 (Ofit Adrian)</li>
                    <li>0821-8254-6122 (Hafizol, S.Si)</li>
                    <li>0813-6756-8802 (Ibadi)</li>
                    <li>0821-8603-2351 (Dwi Aprilia)</li>
                    <li>0813-6765-8046 (Yusnani, S.Ag)</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-ink/10">
            <p class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-6 text-xs text-slate">
                © {{ date('Y') }} SMK Negeri 1 Indralaya Selatan — Tajam, Tangguh, Terpuji. Semua hak dilindungi.
            </p>
        </div>
    </footer>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        menuBtn.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.toggle('hidden');
            menuBtn.setAttribute('aria-expanded', String(!isHidden));
        });
    </script>
</body>
</html>