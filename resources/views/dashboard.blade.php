<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — SMK Wira Cipta Karya</title>
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream text-ink min-h-screen">
    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <main class="flex-1 bg-cream">
            <header class="bg-white border-b border-ink/10">
                <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate">Selamat datang</p>
                        <h1 class="font-bold text-xl">{{ auth()->user()->name ?? 'Pengguna' }}</h1>
                    </div>

                    <div class="flex items-center gap-3">
                        @php
                            $roleLabels = [
                                'admin' => 'Admin',
                                'guru' => 'Guru / Wali Kelas',
                                'kepala_sekolah' => 'Kepala Sekolah',
                            ];
                            $userRole = auth()->user()->role ?? 'admin';
                        @endphp

                        <span class="inline-flex items-center rounded-full bg-navy/10 px-3 py-1 text-xs font-semibold text-navy uppercase tracking-wide">
                            {{ $roleLabels[$userRole] ?? 'User' }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-ink text-cream px-4 py-2 rounded-full text-sm font-semibold hover:bg-navy">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="mb-10">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-navy">Dashboard sistem</p>
                    <h2 class="mt-3 text-3xl font-bold">Panel {{ $roleLabels[$userRole] ?? 'Pengguna' }} SMK Wira Cipta Karya</h2>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                        <p class="text-sm text-slate">Jumlah Siswa</p>
                        <p class="mt-3 text-3xl font-bold">1.248</p>
                    </div>
                    <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                        <p class="text-sm text-slate">Kehadiran Hari Ini</p>
                        <p class="mt-3 text-3xl font-bold">94%</p>
                    </div>
                    <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                        <p class="text-sm text-slate">Kelas Aktif</p>
                        <p class="mt-3 text-3xl font-bold">18</p>
                    </div>
                </div>

                <div class="mt-8 grid lg:grid-cols-[1.5fr_1fr] gap-6">
                    <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-xl font-bold mb-4">Aktivitas utama</h3>

                        @if ($userRole === 'admin')
                            <ul class="space-y-3 text-slate">
                                <li>• Kelola data master siswa, guru, kelas, dan tahun ajaran.</li>
                                <li>• Pantau rekap kehadiran seluruh kelas.</li>
                                <li>• Mengatur pengguna dan akses sistem.</li>
                            </ul>
                        @elseif ($userRole === 'guru')
                            <ul class="space-y-3 text-slate">
                                <li>• Input absensi harian untuk kelas yang diampu.</li>
                                <li>• Cek rekap kehadiran per siswa dan per kelas.</li>
                                <li>• Hanya dapat mengelola kelas sendiri.</li>
                            </ul>
                        @else
                            <ul class="space-y-3 text-slate">
                                <li>• Melihat rekap kehadiran semua kelas.</li>
                                <li>• Meninjau laporan bulanan dan semester.</li>
                                <li>• Tidak memiliki akses edit data master atau absensi.</li>
                            </ul>
                        @endif
                    </div>

                    <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-xl font-bold mb-4">Status login</h3>
                        <p class="text-slate">Anda login sebagai <span class="font-semibold text-ink">{{ auth()->user()->email }}</span>.</p>
                        <p class="mt-3 text-sm text-slate">
                            Sistem ini masih bersifat dashboard sementara sesuai alur project dan role access yang sudah ditetapkan.
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
