<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak — SMK Wira Cipta Karya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#f8f7f2] text-[#17243f]">
    @php
        $role = auth()->user()?->role;
        $roleLabels = [
            'admin' => 'Admin',
            'guru' => 'Guru / Wali Kelas',
            'kepala_sekolah' => 'Kepala Sekolah',
        ];
        $roleCapabilities = [
            'admin' => [
                'Mengelola data siswa, guru, kelas, dan tahun ajaran.',
                'Mengatur penugasan guru sebagai wali kelas.',
                'Mengakses seluruh fitur dan rekapitulasi sistem.',
            ],
            'guru' => [
                'Menginput absensi untuk kelas yang diampu.',
                'Melihat rekap kehadiran siswa di kelasnya.',
                'Tidak dapat mengelola data master atau kelas lain.',
            ],
            'kepala_sekolah' => [
                'Melihat rekap kehadiran semua kelas.',
                'Meninjau laporan harian, bulanan, dan semester.',
                'Tidak dapat mengubah data master maupun absensi.',
            ],
        ];
        $fallbackUrl = auth()->check() ? route('dashboard') : route('login');
    @endphp

    <main class="flex min-h-screen items-center justify-center px-6 py-12">
        <section class="w-full max-w-2xl rounded-[2rem] border border-[#17243f]/10 bg-white p-8 shadow-xl shadow-[#17243f]/10 sm:p-12">
            <div class="flex flex-col gap-8 sm:flex-row sm:items-start">
                <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-3xl bg-[#17243f] text-2xl font-bold text-[#f5b63f]">
                    403
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#f5b63f]">Akses terbatas</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight">Kamu belum bisa membuka halaman ini</h1>
                    <p class="mt-4 leading-relaxed text-slate-600">
                        Halaman ini tidak termasuk dalam hak akses
                        <span class="font-semibold text-[#17243f]">{{ $roleLabels[$role] ?? 'pengguna' }}</span>.
                        Silakan kembali ke halaman sebelumnya.
                    </p>
                </div>
            </div>

            <div class="mt-8 rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5">
                <h2 class="font-bold">Hak akses {{ $roleLabels[$role] ?? 'pengguna' }}</h2>
                @if (isset($roleCapabilities[$role]))
                    <ul class="mt-3 space-y-2 text-sm leading-relaxed text-slate-600">
                        @foreach ($roleCapabilities[$role] as $capability)
                            <li class="flex gap-2"><span class="font-bold text-emerald-600">&#10003;</span><span>{{ $capability }}</span></li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-3 text-sm text-slate-600">Silakan login dengan akun yang memiliki hak akses sesuai halaman ini.</p>
                @endif
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a
                    href="{{ url()->previous() !== url()->current() ? url()->previous() : $fallbackUrl }}"
                    onclick="if (window.history.length > 1) { event.preventDefault(); window.history.back(); }"
                    class="inline-flex flex-1 items-center justify-center rounded-xl bg-[#17243f] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#263b63]"
                >
                    Kembali ke halaman sebelumnya
                </a>
                <a href="{{ $fallbackUrl }}" class="inline-flex items-center justify-center rounded-xl bg-[#e5e7eb] px-5 py-3 text-sm font-semibold text-[#17243f] transition hover:bg-[#d1d5db]">
                    {{ auth()->check() ? 'Ke Dashboard' : 'Ke Login' }}
                </a>
            </div>
        </section>
    </main>
</body>
</html>
