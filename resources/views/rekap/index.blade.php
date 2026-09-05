<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran — SMK Wira Cipta Karya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#17243f',
                        cream: '#f8f7f2',
                        amber: '#f5b63f',
                        slate: '#64748b',
                        navy: '#17243f',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream text-ink min-h-screen">
    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <main class="flex-1 min-w-0 bg-cream">
            <header class="bg-[#f3f4f6] border-b border-ink/10">
                <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-slate">Kehadiran</p>
                        <h1 class="font-bold text-xl text-ink">Rekap Kehadiran</h1>
                    </div>

                    <form method="GET" action="{{ route('rekap.index') }}" class="flex items-center gap-2">
                        <label for="academic_year_id" class="text-xs font-semibold uppercase tracking-[0.2em] text-slate">Semester</label>
                        <select id="academic_year_id" name="academic_year_id" onchange="this.form.submit()"
                            class="rounded-xl border border-ink/10 bg-white px-4 py-2 text-sm text-ink focus:border-ink/30">
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}" {{ $academicYear && $academicYear->id === $year->id ? 'selected' : '' }}>
                                    {{ $year->tahun }} · {{ $year->semester }}{{ $year->is_active ? ' (Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </header>

            <div class="max-w-7xl mx-auto px-6 py-10">
                @if (! $academicYear)
                    <div class="rounded-2xl border border-dashed border-ink/15 bg-[#f3f4f6] p-8 text-center text-sm text-slate">
                        Belum ada tahun ajaran aktif. Silakan atur di menu Tahun Ajaran terlebih dahulu.
                    </div>
                @else
                    <p class="mb-6 text-sm text-slate">
                        Menampilkan rekap kehadiran untuk <span class="font-semibold text-ink">{{ $academicYear->tahun }} · Semester {{ $academicYear->semester }}</span>.
                        Klik salah satu kelas untuk melihat rincian kehadiran per siswa.
                    </p>

                    @if ($classes->isEmpty())
                        <div class="rounded-2xl border border-dashed border-ink/15 bg-[#f3f4f6] p-8 text-center text-sm text-slate">
                            Belum ada kelas yang terdaftar pada semester ini.
                        </div>
                    @else
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($classes as $class)
                                <a href="{{ route('rekap.kelas', ['class' => $class->id, 'academic_year_id' => $academicYear->id]) }}"
                                    class="group rounded-2xl border border-ink/10 bg-[#f3f4f6] p-5 shadow-sm transition hover:border-amber hover:shadow-md">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate">Kelas</p>
                                            <h2 class="mt-1 text-lg font-bold text-ink">{{ $class->nama_kelas }}</h2>
                                            <p class="mt-1 text-xs text-slate">
                                                Wali kelas: <span class="font-semibold text-ink/80">{{ $class->teacher?->nama ?? 'Belum ditentukan' }}</span>
                                            </p>
                                        </div>
                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-ink/5 text-ink transition group-hover:bg-amber/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.159.69.159 1.006 0Z" />
                                            </svg>
                                        </span>
                                    </div>

                                    <div class="mt-4 flex items-center gap-4 text-sm">
                                        <div>
                                            <p class="font-bold text-ink">{{ $class->students_count }}</p>
                                            <p class="text-xs text-slate">Siswa</p>
                                        </div>
                                        <div class="h-8 w-px bg-ink/10"></div>
                                        <div>
                                            <p class="font-bold text-ink">{{ $class->attendance_count }}</p>
                                            <p class="text-xs text-slate">Data absensi tercatat</p>
                                        </div>
                                    </div>

                                    <div class="mt-4 grid grid-cols-4 gap-2 rounded-xl bg-white p-3 text-center">
                                        <div>
                                            <p class="text-sm font-bold text-emerald-700">{{ $class->hadir_count }}</p>
                                            <p class="text-[10px] uppercase tracking-wide text-slate">Hadir</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-sky-700">{{ $class->sakit_count }}</p>
                                            <p class="text-[10px] uppercase tracking-wide text-slate">Sakit</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-amber-700">{{ $class->izin_count }}</p>
                                            <p class="text-[10px] uppercase tracking-wide text-slate">Izin</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-red-700">{{ $class->alpa_count }}</p>
                                            <p class="text-[10px] uppercase tracking-wide text-slate">Alpa</p>
                                        </div>
                                    </div>

                                    <p class="mt-4 text-xs font-semibold text-ink/70 group-hover:text-ink">
                                        Lihat rincian per siswa →
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
        </main>
    </div>
</body>
</html>