<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK Wira Cipta Karya — Belajar Keterampilan, Siap Kerja</title>
    <meta name="description" content="SMK Wira Cipta Karya membekali siswa dengan keahlian praktik industri lewat program TKJ, RPL, Multimedia, Akuntansi, dan TKR.">

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
        html { scroll-behavior: smooth; }
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
            .fade-in-up {
                animation: fadeInUp 0.7s ease-out both;
            }
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
        <nav class="max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between h-20">
            <a href="/" class="flex items-center gap-3 shrink-0">
                <span class="w-10 h-10 rounded-full bg-ink flex items-center justify-center">
                    <span class="font-display font-bold text-amber text-sm">WCK</span>
                </span>
                <span class="font-display font-semibold text-lg leading-tight">
                    SMK Wira Cipta Karya
                </span>
            </a>

            <ul class="hidden md:flex items-center gap-9 text-sm font-medium text-slate">
                <li><a href="#tentang" class="hover:text-ink transition-colors">Tentang</a></li>
                <li><a href="#program" class="hover:text-ink transition-colors">Program Keahlian</a></li>
                <li><a href="#alumni" class="hover:text-ink transition-colors">Alumni</a></li>
                <li><a href="#ppdb" class="hover:text-ink transition-colors">PPDB</a></li>
                <li><a href="#kontak" class="hover:text-ink transition-colors">Kontak</a></li>
            </ul>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                   class="hidden sm:inline-flex items-center px-5 py-2.5 rounded-full border border-ink/20 text-sm font-semibold text-ink hover:border-ink hover:bg-ink hover:text-cream transition-colors">
                    Masuk
                </a>
                <a href="#ppdb"
                   class="inline-flex items-center px-5 py-2.5 rounded-full bg-amber text-ink text-sm font-semibold hover:bg-ink hover:text-amber transition-colors">
                    Daftar PPDB
                </a>
                <button id="menuBtn" aria-label="Buka menu" aria-expanded="false" class="md:hidden p-2 text-ink">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>
            </div>
        </nav>

        <div id="mobileMenu" class="hidden md:hidden border-t border-ink/10 bg-cream px-6 py-4 space-y-3 text-sm font-medium text-slate">
            <a href="#tentang" class="block py-1">Tentang</a>
            <a href="#program" class="block py-1">Program Keahlian</a>
            <a href="#alumni" class="block py-1">Alumni</a>
            <a href="#ppdb" class="block py-1">PPDB</a>
            <a href="#kontak" class="block py-1">Kontak</a>
            <a href="{{ route('login') }}" class="block py-2 font-semibold text-ink">Masuk</a>
        </div>
    </header>

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 dot-grid opacity-60 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16 lg:py-24 relative grid lg:grid-cols-12 gap-12 items-center">

            <div class="lg:col-span-6 fade-in-up">
                <p class="text-sm font-semibold tracking-wide text-navy mb-4">
                    Terakreditasi A · Berbasis Kompetensi Industri
                </p>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-[3.4rem] leading-[1.08] font-semibold text-ink">
                    Belajar keterampilan yang langsung dipakai dunia kerja
                </h1>
                <p class="mt-6 text-slate text-base sm:text-lg max-w-md leading-relaxed">
                    Kelas praktik, bengkel kerja, dan magang industri sejak kelas 10 — supaya lulusan
                    SMK Wira Cipta Karya siap bekerja, berwirausaha, atau lanjut kuliah dengan bekal yang nyata.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="#ppdb" class="inline-flex items-center px-7 py-3.5 rounded-full bg-ink text-cream text-sm font-semibold hover:bg-navy transition-colors">
                        Daftar Tahun Ajaran Baru
                    </a>
                    <a href="#program" class="inline-flex items-center px-7 py-3.5 rounded-full border border-ink/20 text-sm font-semibold text-ink hover:border-ink transition-colors">
                        Lihat Program Keahlian
                    </a>
                </div>

                <dl class="mt-14 grid grid-cols-3 gap-6 max-w-md">
                    <div>
                        <dt class="sr-only">Program keahlian</dt>
                        <dd class="font-display text-2xl font-semibold text-ink">5</dd>
                        <p class="text-xs text-slate mt-1">Program keahlian</p>
                    </div>
                    <div>
                        <dt class="sr-only">Tingkat keterserapan kerja</dt>
                        <dd class="font-display text-2xl font-semibold text-ink">87%</dd>
                        <p class="text-xs text-slate mt-1">Lulusan terserap kerja</p>
                    </div>
                    <div>
                        <dt class="sr-only">Mitra industri</dt>
                        <dd class="font-display text-2xl font-semibold text-ink">60+</dd>
                        <p class="text-xs text-slate mt-1">Mitra industri & DUDI</p>
                    </div>
                </dl>
            </div>

            <div class="lg:col-span-6 relative fade-in-up" style="animation-delay:.15s">
                <div class="clip-panel bg-navy aspect-[4/5] max-w-md mx-auto relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80"
                         alt="Siswa SMK sedang praktik di bengkel kerja"
                         class="w-full h-full object-cover mix-blend-luminosity opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-ink/70 via-ink/0 to-transparent"></div>
                </div>

                <div class="absolute -left-4 sm:left-0 bottom-6 bg-white rounded-2xl shadow-lg shadow-ink/10 px-5 py-4 max-w-[210px]">
                    <p class="font-display font-semibold text-ink text-sm">Akreditasi A</p>
                    <p class="text-xs text-slate mt-1">Badan Akreditasi Nasional Sekolah/Madrasah</p>
                </div>

                <div class="absolute -right-2 sm:right-4 top-8 bg-amber rounded-2xl shadow-lg shadow-ink/10 px-5 py-3">
                    <p class="font-display font-semibold text-ink text-sm">Kelas Industri</p>
                    <p class="text-xs text-ink/70">Kurikulum bersama mitra kerja</p>
                </div>
            </div>
        </div>
    </section>

    {{-- TENTANG / KEUNGGULAN --}}
    <section id="tentang" class="bg-white border-y border-ink/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-20">
            <div class="grid lg:grid-cols-12 gap-10 lg:gap-16">
                <div class="lg:col-span-4">
                    <h2 class="font-display text-3xl font-semibold text-ink leading-tight">
                        Kenapa memilih SMK Wira Cipta Karya
                    </h2>
                    <p class="mt-4 text-slate leading-relaxed">
                        Kami merancang pembelajaran di sekitar praktik nyata, bukan sekadar teori di kelas,
                        supaya setiap lulusan punya portofolio kerja yang bisa dibuktikan.
                    </p>
                </div>

                <div class="lg:col-span-8 grid sm:grid-cols-2 gap-x-10 gap-y-10">
                    <div class="flex gap-4">
                        <span class="font-display text-xl font-semibold text-amber shrink-0 w-8">01</span>
                        <div>
                            <h3 class="font-display font-semibold text-ink">Praktik 60% dari jam belajar</h3>
                            <p class="mt-2 text-sm text-slate leading-relaxed">
                                Siswa lebih banyak berada di bengkel, laboratorium komputer, dan studio produksi
                                dibanding di ruang kelas teori.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-display text-xl font-semibold text-amber shrink-0 w-8">02</span>
                        <div>
                            <h3 class="font-display font-semibold text-ink">Magang sejak kelas 11</h3>
                            <p class="mt-2 text-sm text-slate leading-relaxed">
                                Praktik Kerja Lapangan di perusahaan mitra selama satu semester penuh,
                                dengan pembimbing dari industri.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-display text-xl font-semibold text-amber shrink-0 w-8">03</span>
                        <div>
                            <h3 class="font-display font-semibold text-ink">Sertifikasi kompetensi</h3>
                            <p class="mt-2 text-sm text-slate leading-relaxed">
                                Uji kompetensi keahlian bersama LSP, sehingga lulusan memegang sertifikat
                                yang diakui industri.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-display text-xl font-semibold text-amber shrink-0 w-8">04</span>
                        <div>
                            <h3 class="font-display font-semibold text-ink">Guru dari praktisi industri</h3>
                            <p class="mt-2 text-sm text-slate leading-relaxed">
                                Sebagian pengajar aktif bekerja atau pernah bekerja di bidang keahlian
                                yang mereka ajarkan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PROGRAM KEAHLIAN --}}
    <section id="program" class="bg-cream">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-20">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
                <h2 class="font-display text-3xl font-semibold text-ink">Program Keahlian</h2>
                <p class="text-sm text-slate max-w-sm">Lima jurusan dengan peminatan langsung ke kebutuhan
                    industri lokal dan nasional.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-px bg-ink/10 border border-ink/10 rounded-2xl overflow-hidden">
                @php
                    $programs = [
                        ['code' => 'RPL', 'name' => 'Rekayasa Perangkat Lunak', 'desc' => 'Pengembangan aplikasi web dan mobile dengan proyek nyata.'],
                        ['code' => 'TKJ', 'name' => 'Teknik Komputer & Jaringan', 'desc' => 'Instalasi jaringan, server, dan keamanan sistem.'],
                        ['code' => 'MM', 'name' => 'Multimedia', 'desc' => 'Videografi, desain grafis, dan animasi 2D/3D.'],
                        ['code' => 'AK', 'name' => 'Akuntansi & Keuangan', 'desc' => 'Pembukuan, perpajakan, dan sistem keuangan digital.'],
                        ['code' => 'TKR', 'name' => 'Teknik Kendaraan Ringan', 'desc' => 'Perawatan dan perbaikan mesin kendaraan roda empat.'],
                        ['code' => 'TB', 'name' => 'Tata Boga', 'desc' => 'Produksi kuliner dan manajemen usaha restoran.'],
                    ];
                @endphp

                @foreach ($programs as $p)
                    <div class="bg-cream p-8 hover:bg-white transition-colors">
                        <span class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-ink text-cream font-display text-xs font-semibold">
                            {{ $p['code'] }}
                        </span>
                        <h3 class="font-display font-semibold text-ink mt-5">{{ $p['name'] }}</h3>
                        <p class="text-sm text-slate mt-2 leading-relaxed">{{ $p['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ALUMNI / TESTIMONI --}}
    <section id="alumni" class="bg-ink text-cream">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-20">
            <h2 class="font-display text-3xl font-semibold">Cerita dari alumni</h2>
            <div class="mt-12 grid md:grid-cols-3 gap-8">
                <blockquote class="border-l-2 border-amber pl-6">
                    <p class="text-cream/90 leading-relaxed">
                        Magang di jurusan RPL langsung membuat saya paham cara kerja tim developer
                        sesungguhnya, bukan cuma dari buku.
                    </p>
                    <footer class="mt-4 text-sm text-cream/60">
                        Dinda Ayu Lestari — Frontend Developer, angkatan 2022
                    </footer>
                </blockquote>
                <blockquote class="border-l-2 border-amber pl-6">
                    <p class="text-cream/90 leading-relaxed">
                        Sertifikasi kompetensi dari sekolah jadi modal utama saya diterima kerja
                        di bengkel resmi tanpa harus training dari nol.
                    </p>
                    <footer class="mt-4 text-sm text-cream/60">
                        Rian Firmansyah — Teknisi, angkatan 2021
                    </footer>
                </blockquote>
                <blockquote class="border-l-2 border-amber pl-6">
                    <p class="text-cream/90 leading-relaxed">
                        Belajar tata boga di sini mendorong saya membuka usaha katering sendiri
                        sejak semester akhir kelas 12.
                    </p>
                    <footer class="mt-4 text-sm text-cream/60">
                        Salma Nur Azizah — Pemilik Usaha Katering, angkatan 2023
                    </footer>
                </blockquote>
            </div>
        </div>
    </section>

    {{-- PPDB CTA --}}
    <section id="ppdb" class="bg-amber">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
            <div class="max-w-xl">
                <h2 class="font-display text-3xl font-semibold text-ink">
                    Penerimaan Peserta Didik Baru dibuka
                </h2>
                <p class="mt-3 text-ink/80 leading-relaxed">
                    Gelombang pertama tersedia untuk 216 kursi di enam program keahlian.
                    Pendaftaran online, tanpa perlu datang ke sekolah dulu.
                </p>
            </div>
            <a href="#" class="inline-flex items-center justify-center px-8 py-4 rounded-full bg-ink text-cream font-semibold text-sm hover:bg-navy transition-colors shrink-0">
                Mulai Pendaftaran
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer id="kontak" class="bg-white border-t border-ink/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16 grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div>
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-full bg-ink flex items-center justify-center">
                        <span class="font-display font-bold text-amber text-xs">WCK</span>
                    </span>
                    <span class="font-display font-semibold text-ink">SMK Wira Cipta Karya</span>
                </div>
                <p class="mt-4 text-sm text-slate leading-relaxed">
                    Jl. Pendidikan Raya No. 12, Palembang, Sumatera Selatan
                </p>
            </div>
            <div>
                <p class="font-display font-semibold text-ink text-sm">Sekolah</p>
                <ul class="mt-4 space-y-2 text-sm text-slate">
                    <li><a href="#tentang" class="hover:text-ink">Tentang Kami</a></li>
                    <li><a href="#program" class="hover:text-ink">Program Keahlian</a></li>
                    <li><a href="#alumni" class="hover:text-ink">Alumni</a></li>
                </ul>
            </div>
            <div>
                <p class="font-display font-semibold text-ink text-sm">Informasi</p>
                <ul class="mt-4 space-y-2 text-sm text-slate">
                    <li><a href="#ppdb" class="hover:text-ink">PPDB</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-ink">Masuk Akun</a></li>
                </ul>
            </div>
            <div>
                <p class="font-display font-semibold text-ink text-sm">Kontak</p>
                <ul class="mt-4 space-y-2 text-sm text-slate">
                    <li>(0711) 555-0142</li>
                    <li>ppdb@smkwck.sch.id</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-ink/10">
            <p class="max-w-7xl mx-auto px-6 lg:px-10 py-6 text-xs text-slate">
                © {{ date('Y') }} SMK Wira Cipta Karya. Semua hak dilindungi.
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