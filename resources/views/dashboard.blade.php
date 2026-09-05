<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — SMK Wira Cipta Karya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
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
                            $roleLabels = ['admin' => 'Admin', 'guru' => 'Guru / Wali Kelas', 'kepala_sekolah' => 'Kepala Sekolah'];
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
                @if (! $academicYear)
                    <div class="rounded-2xl border border-dashed border-ink/15 bg-white p-8 text-center text-sm text-slate">
                        Belum ada tahun ajaran aktif. Silakan atur di menu Tahun Ajaran terlebih dahulu.
                    </div>
                @elseif ($mode === 'admin')
                    <div class="mb-10">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-navy">Dashboard sistem</p>
                        <h2 class="mt-3 text-3xl font-bold">Panel Admin SMK Wira Cipta Karya</h2>
                        <p class="mt-1 text-sm text-slate">{{ $academicYear->tahun }} · Semester {{ $academicYear->semester }}</p>
                    </div>

                    <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                            <p class="text-sm text-slate">Jumlah Siswa</p>
                            <p class="mt-3 text-3xl font-bold">{{ $totalStudents }}</p>
                        </div>
                        <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                            <p class="text-sm text-slate">Jumlah Guru</p>
                            <p class="mt-3 text-3xl font-bold">{{ $totalTeachers }}</p>
                        </div>
                        <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                            <p class="text-sm text-slate">Kelas Aktif</p>
                            <p class="mt-3 text-3xl font-bold">{{ $totalClasses }}</p>
                        </div>
                        <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                            <p class="text-sm text-slate">Kehadiran Hari Ini</p>
                            <p class="mt-3 text-3xl font-bold">
                                {{ $persenHadirToday !== null ? $persenHadirToday . '%' : '—' }}
                            </p>
                            <p class="mt-1 text-xs text-slate">
                                {{ $totalToday > 0 ? "dari {$totalToday} data absensi" : 'belum ada absensi hari ini' }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm mt-6">
                        <h3 class="text-lg font-bold mb-4">Tren kehadiran 7 hari terakhir</h3>
                        <canvas id="trendChart" height="90"></canvas>
                    </div>

                    <script>
                        new Chart(document.getElementById('trendChart'), {
                            type: 'line',
                            data: {
                                labels: {!! json_encode($trend->pluck('label')) !!},
                                datasets: [{
                                    label: '% Kehadiran',
                                    data: {!! json_encode($trend->pluck('persentase')) !!},
                                    borderColor: '#1E3A5F',
                                    backgroundColor: 'rgba(30, 58, 95, 0.1)',
                                    fill: true,
                                    tension: 0.3,
                                    pointRadius: 4,
                                    pointBackgroundColor: '#E8A33D',
                                }]
                            },
                            options: {
                                scales: { y: { beginAtZero: true, max: 100 } },
                                plugins: { legend: { display: false } }
                            }
                        });
                    </script>
                @elseif ($mode === 'guru')
                    <div class="mb-10">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-navy">Dashboard sistem</p>
                        <h2 class="mt-3 text-3xl font-bold">Ringkasan Hari Ini</h2>
                        <p class="mt-1 text-sm text-slate">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>

                    <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                            <p class="text-sm text-slate">Jadwal Hari Ini</p>
                            <p class="mt-3 text-3xl font-bold">{{ $totalToday }}</p>
                        </div>
                        <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                            <p class="text-sm text-slate">Sudah Lengkap</p>
                            <p class="mt-3 text-3xl font-bold text-emerald-700">{{ $completeToday }}</p>
                        </div>
                        <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                            <p class="text-sm text-slate">Belum Diabsen</p>
                            <p class="mt-3 text-3xl font-bold text-amber-700">{{ $pendingToday }}</p>
                        </div>
                        <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm">
                            <p class="text-sm text-slate">Kelas Diampu</p>
                            <p class="mt-3 text-3xl font-bold">{{ $totalClasses }}</p>
                        </div>
                    </div>

                    @if ($waliKelas)
                        <div class="bg-navy text-white rounded-2xl p-6 shadow-sm mb-6 flex items-center justify-between gap-4 flex-wrap">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-white/60">Wali Kelas</p>
                                <p class="mt-1 text-lg font-bold">{{ $waliKelas->nama_kelas }} · {{ $waliKelas->students_count }} siswa</p>
                            </div>
                            <a href="{{ route('rekap.kelas', ['class' => $waliKelas->id, 'academic_year_id' => $academicYear->id]) }}"
                                class="rounded-full bg-amber px-5 py-2.5 text-sm font-semibold text-ink hover:brightness-95">
                                Lihat Rekap Kelasku
                            </a>
                        </div>
                    @endif

                    <div class="bg-white border border-ink/10 rounded-2xl overflow-hidden shadow-sm">
                        <div class="px-6 py-4 border-b border-ink/10">
                            <h3 class="font-bold">Jadwal mengajar hari ini</h3>
                        </div>

                        @if ($todaySchedules->isEmpty())
                            <p class="p-6 text-sm text-slate">Tidak ada jadwal mengajar hari ini.</p>
                        @else
                            <ul class="divide-y divide-ink/10">
                                @foreach ($todaySchedules as $schedule)
                                    <li class="flex flex-wrap items-center justify-between gap-3 px-6 py-4">
                                        <div>
                                            <p class="font-semibold">{{ $schedule->subject }} · {{ $schedule->classRoom->nama_kelas }}</p>
                                            <p class="text-xs text-slate">
                                                {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }} WIB
                                                · {{ $schedule->attendance_count }}/{{ $schedule->total_students }} siswa diabsen
                                            </p>
                                        </div>

                                        @if ($schedule->is_complete)
                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Sudah diabsen</span>
                                        @else
                                            <a href="{{ route('attendances.create', ['schedule_id' => $schedule->id, 'date' => $today]) }}"
                                                class="rounded-full bg-ink px-4 py-2 text-xs font-semibold text-white hover:bg-navy">
                                                Isi Absensi
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('attendances.index') }}" class="text-sm font-semibold text-navy hover:underline">
                            Buka halaman Input Absensi lengkap →
                        </a>
                    </div>
                @else
                    {{-- KEPALA SEKOLAH --}}
                    <div class="mb-10">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-navy">Dashboard sistem</p>
                        <h2 class="mt-3 text-3xl font-bold">Rekap Kehadiran Seluruh Kelas</h2>
                        <p class="mt-1 text-sm text-slate">{{ $academicYear->tahun }} · Semester {{ $academicYear->semester }}</p>
                    </div>

                    <div class="bg-white border border-ink/10 rounded-2xl p-6 shadow-sm mb-6">
                        <h3 class="text-lg font-bold mb-4">Persentase kehadiran per kelas</h3>
                        <canvas id="kehadiranChart" height="90"></canvas>
                    </div>

                    <div class="bg-white border border-ink/10 rounded-2xl overflow-hidden shadow-sm">
                        <table class="min-w-full divide-y divide-ink/10">
                            <thead class="bg-cream">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate">Kelas</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate">Siswa</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate">% Kehadiran</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-ink/10">
                                @foreach ($classes as $class)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-semibold">{{ $class->nama_kelas }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-slate">{{ $class->students_count }}</td>
                                        <td class="px-4 py-3 text-center text-sm font-bold">{{ $class->persentase }}%</td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ route('rekap.kelas', ['class' => $class->id, 'academic_year_id' => $academicYear->id]) }}" class="text-xs font-semibold text-navy hover:underline">Lihat detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <script>
                        new Chart(document.getElementById('kehadiranChart'), {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($classes->pluck('nama_kelas')) !!},
                                datasets: [{
                                    label: '% Kehadiran',
                                    data: {!! json_encode($classes->pluck('persentase')) !!},
                                    backgroundColor: '#E8A33D',
                                    borderRadius: 6,
                                }]
                            },
                            options: {
                                scales: { y: { beginAtZero: true, max: 100 } },
                                plugins: { legend: { display: false } }
                            }
                        });
                    </script>
                @endif
            </div>
        </main>
    </div>
</body>
</html>