<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Absensi — SMK Wira Cipta Karya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#f8f7f2] text-[#17243f]">
    <div class="flex min-h-screen">
        @include('partials.sidebar')
        <main class="min-w-0 flex-1">
            <header class="border-b border-[#17243f]/10 bg-[#f3f4f6]"><div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-4"><div><p class="text-sm text-slate-500">Input Absensi</p><h1 class="text-xl font-bold">Isi Absensi Siswa</h1></div><a href="{{ route('attendances.index') }}" class="rounded-full bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Ganti Jadwal</a></div></header>
            <div class="mx-auto max-w-7xl px-6 py-10">
                @if (session('success'))<div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>@endif
                @if (session('error'))<div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>@endif
                @if (!$schedule)
                    <div class="rounded-2xl border border-dashed border-[#17243f]/15 bg-[#f3f4f6] p-8 text-center text-sm text-slate-500">Silakan pilih jadwal dan tanggal terlebih dahulu.</div>
                @else
                    <div class="mb-6 grid gap-4 sm:grid-cols-4"><div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Mata Pelajaran</p><p class="mt-2 font-bold">{{ $schedule->subject }}</p></div><div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Kelas</p><p class="mt-2 font-bold">{{ $schedule->classRoom->nama_kelas }}</p></div><div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Waktu</p><p class="mt-2 font-bold">{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }} WIB</p></div><div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</p><p class="mt-2 font-bold {{ $availability['can_submit'] ? 'text-emerald-700' : 'text-amber-700' }}">{{ $availability['label'] }}</p></div></div>
                    <div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5 shadow-sm">
                        <form id="attendanceForm" method="POST" action="{{ route('attendances.store') }}">@csrf<input type="hidden" name="schedule_id" value="{{ $schedule->id }}"><input type="hidden" name="date" value="{{ $selectedDate }}">
                            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"><div><h2 class="text-lg font-bold">{{ $schedule->classRoom->students->count() }} Siswa</h2><p class="mt-1 text-sm text-slate-500">Tanggal: {{ $selectedDate }} (WIB)</p></div><span class="{{ !$availability['can_submit'] ? 'pointer-events-none opacity-50' : '' }}"><x-confirm action="mark-all-present" title="Tandai Semua Hadir?" message="Semua siswa pada jadwal ini akan ditandai Hadir. Pastikan data ini sudah benar." confirm-text="Ya, Tandai Hadir" button-text="Tandai Semua Hadir" confirm-action="markAllStudents()" /></span></div>
                            @if (!$availability['can_submit'])<div class="mb-5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">{{ $availability['message'] }}</div>@endif
                            <div class="overflow-x-auto rounded-xl border border-[#17243f]/10 bg-white"><table class="min-w-full divide-y divide-[#17243f]/10"><thead class="bg-[#e5e7eb]"><tr><th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">NISN</th><th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nama</th><th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th></tr></thead><tbody class="divide-y divide-[#17243f]/10">
                                @foreach ($schedule->classRoom->students as $student)<tr class="hover:bg-[#f8f7f2]"><td class="px-4 py-3 text-sm">{{ $student->nisn }}</td><td class="px-4 py-3 text-sm font-medium">{{ $student->nama }}</td><td class="px-4 py-3"><select name="statuses[{{ $student->id }}]" {{ !$availability['can_submit'] ? 'disabled' : '' }} class="student-status w-full rounded-xl border border-[#17243f]/10 bg-white px-3 py-2 text-sm focus:border-[#17243f]/30 focus:outline-none"><option value="hadir" {{ ($attendanceMap[$student->id] ?? 'hadir') === 'hadir' ? 'selected' : '' }}>Hadir</option><option value="sakit" {{ ($attendanceMap[$student->id] ?? '') === 'sakit' ? 'selected' : '' }}>Sakit</option><option value="izin" {{ ($attendanceMap[$student->id] ?? '') === 'izin' ? 'selected' : '' }}>Izin</option><option value="alpa" {{ ($attendanceMap[$student->id] ?? '') === 'alpa' ? 'selected' : '' }}>Alpa</option></select></td></tr>@endforeach
                            </tbody></table></div>
                            <div class="mt-5"><label for="notes" class="mb-2 block text-sm font-semibold">Catatan</label><textarea id="notes" name="notes" rows="3" {{ !$availability['can_submit'] ? 'disabled' : '' }} class="w-full rounded-xl border border-[#17243f]/10 bg-white px-4 py-3 text-sm focus:border-[#17243f]/30 focus:outline-none" placeholder="Contoh: absensi diinput terlambat karena lupa..."></textarea></div>
                            <div class="mt-5 flex justify-end"><x-confirm :action="route('attendances.store')" title="Simpan Absensi?" message="Pastikan status seluruh siswa sudah benar. Data absensi akan disimpan untuk jadwal ini." confirm-text="Ya, Simpan" button-text="Simpan Absensi" form-id="attendanceForm" /></div>
                        </form>
                    </div>
                @endif
            </div>
        </main>
    </div>
    <script>function markAllStudents() { document.querySelectorAll('.student-status').forEach((select) => select.value = 'hadir'); }</script>
</body>
</html>
