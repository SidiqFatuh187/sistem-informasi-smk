<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap {{ $class->nama_kelas }} — SMK Wira Cipta Karya</title>
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
                        <p class="text-sm text-slate">Rekap Kehadiran</p>
                        <h1 class="font-bold text-xl text-ink">{{ $class->nama_kelas }}</h1>
                    </div>

                    <a href="{{ route('rekap.index', ['academic_year_id' => $academicYear?->id]) }}"
                        class="rounded-full bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition">
                        ← Ganti Kelas
                    </a>
                </div>
            </header>

            <div class="max-w-7xl mx-auto px-6 py-10">
                @if (! $academicYear)
                    <div class="rounded-2xl border border-dashed border-ink/15 bg-[#f3f4f6] p-8 text-center text-sm text-slate">
                        Belum ada tahun ajaran aktif. Silakan atur di menu Tahun Ajaran terlebih dahulu.
                    </div>
                @else
                    {{-- Ringkasan info kelas --}}
                    <div class="mb-6 grid gap-4 sm:grid-cols-4">
                        <div class="rounded-2xl border border-ink/10 bg-[#f3f4f6] p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate">Wali Kelas</p>
                            <p class="mt-2 font-bold text-ink">{{ $class->teacher?->nama ?? 'Belum ditentukan' }}</p>
                        </div>
                        <div class="rounded-2xl border border-ink/10 bg-[#f3f4f6] p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate">Semester</p>
                            <p class="mt-2 font-bold text-ink">{{ $academicYear->tahun }} · {{ $academicYear->semester }}</p>
                        </div>
                        <div class="rounded-2xl border border-ink/10 bg-[#f3f4f6] p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate">Jumlah Siswa</p>
                            <p class="mt-2 font-bold text-ink">{{ $recap->count() }}</p>
                        </div>
                        <div class="rounded-2xl border border-ink/10 bg-[#f3f4f6] p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate">Mata Pelajaran Ditampilkan</p>
                            <p class="mt-2 font-bold text-ink">{{ $subject ?? 'Semua Mapel' }}</p>
                        </div>
                    </div>

                    {{-- Filter mapel & export --}}
                    <section class="mb-6 rounded-2xl border border-ink/10 bg-[#f3f4f6] p-5 shadow-sm">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <form method="GET" action="{{ route('rekap.kelas', $class->id) }}" class="flex flex-1 flex-col gap-3 sm:flex-row sm:items-end">
                                <input type="hidden" name="academic_year_id" value="{{ $academicYear->id }}">
                                <div class="w-full sm:max-w-xs">
                                    <label for="subject" class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate">Mata Pelajaran</label>
                                    <select id="subject" name="subject" onchange="this.form.submit()"
                                        class="w-full rounded-xl border border-ink/10 bg-white px-4 py-3 text-sm text-ink focus:border-ink/30">
                                        <option value="">Semua Mapel</option>
                                        @foreach ($subjects as $item)
                                            <option value="{{ $item }}" {{ $subject === $item ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>

                            <a href="{{ route('rekap.kelas.export', array_filter(['class' => $class->id, 'academic_year_id' => $academicYear->id, 'subject' => $subject])) }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                </svg>
                                Export Excel
                            </a>
                        </div>
                    </section>

                    {{-- Tabel rekap per siswa --}}
                    <section class="rounded-2xl border border-ink/10 bg-[#f3f4f6] p-6 shadow-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <h2 class="text-lg font-bold text-ink">Rekap Per Siswa</h2>
                            <p class="text-xs text-slate">Diurutkan berdasarkan nama (A–Z)</p>
                        </div>

                        @if ($recap->isEmpty())
                            <p class="rounded-xl border border-dashed border-ink/15 bg-white p-5 text-sm text-slate">
                                Belum ada siswa terdaftar di kelas ini.
                            </p>
                        @else
                            <div class="overflow-x-auto rounded-xl border border-ink/10 bg-white">
                                <table class="min-w-full divide-y divide-ink/10">
                                    <thead class="bg-[#e5e7eb]">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate">NISN</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate">Nama</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate">Hadir</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate">Sakit</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate">Izin</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate">Alpa</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate">Total</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate">% Kehadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-ink/10">
                                        @foreach ($recap as $row)
                                            <tr class="hover:bg-[#f8f7f2]">
                                                <td class="px-4 py-3 text-sm text-slate">{{ $row['student']->nisn }}</td>
                                                <td class="px-4 py-3 text-sm font-semibold text-ink">{{ $row['student']->nama }}</td>
                                                <td class="px-4 py-3 text-center text-sm font-semibold text-emerald-700">{{ $row['hadir'] }}</td>
                                                <td class="px-4 py-3 text-center text-sm font-semibold text-sky-700">{{ $row['sakit'] }}</td>
                                                <td class="px-4 py-3 text-center text-sm font-semibold text-amber-700">{{ $row['izin'] }}</td>
                                                <td class="px-4 py-3 text-center text-sm font-semibold text-red-700">{{ $row['alpa'] }}</td>
                                                <td class="px-4 py-3 text-center text-sm text-slate">{{ $row['total'] }}</td>
                                                <td class="px-4 py-3 text-center text-sm font-bold text-ink">{{ $row['persentase'] }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </section>
                @endif
            </div>
        </main>
    </div>
</body>
</html>