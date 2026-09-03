<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $academicYear->tahun }} {{ $academicYear->semester }} — SMK Wira Cipta Karya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#f8f7f2] text-[#17243f]">
    <div class="flex min-h-screen">
        @include('partials.sidebar')
        <main class="min-w-0 flex-1">
            <header class="border-b border-[#17243f]/10 bg-[#f3f4f6]">
                <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-6 py-4">
                    <div><p class="text-sm text-slate-500">Detail Tahun Ajaran</p><h1 class="text-xl font-bold">{{ $academicYear->tahun }} · Semester {{ $academicYear->semester }}</h1></div>
                    <a href="{{ route('academic-years.index') }}" class="rounded-full bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Kembali</a>
                </div>
            </header>
            <div class="mx-auto max-w-5xl px-6 py-10">
                <div class="mb-6 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Tahun Ajaran</p><p class="mt-2 text-lg font-bold">{{ $academicYear->tahun }}</p></div>
                    <div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Semester</p><p class="mt-2 text-lg font-bold">{{ $academicYear->semester }}</p></div>
                    <div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</p><p class="mt-2">@if ($academicYear->is_active)<span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span>@else<span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">Nonaktif</span>@endif</p></div>
                </div>
                <div class="mb-4"><h2 class="text-lg font-bold">Daftar Kelas</h2><p class="mt-1 text-sm text-slate-500">Kelas, jumlah siswa, dan wali kelas pada periode ini.</p></div>
                @if ($academicYear->classes->isEmpty())
                    <div class="rounded-2xl border border-dashed border-[#17243f]/15 bg-[#f3f4f6] p-8 text-center text-sm text-slate-500">Belum ada kelas pada tahun ajaran ini.</div>
                @else
                    <div class="overflow-hidden rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] shadow-sm"><div class="overflow-x-auto"><table class="min-w-full divide-y divide-[#17243f]/10"><thead class="bg-[#e5e7eb]"><tr><th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Kelas</th><th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jumlah Siswa</th><th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Wali Kelas</th><th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Detail</th></tr></thead><tbody class="divide-y divide-[#17243f]/10">
                        @foreach ($academicYear->classes as $class)
                            <tr class="hover:bg-white/60"><td class="px-4 py-3 text-sm font-medium">{{ $class->nama_kelas }}</td><td class="px-4 py-3 text-sm">{{ $class->students->count() }} siswa</td><td class="px-4 py-3 text-sm">{{ $class->teacher?->nama ?? 'Belum ditentukan' }}</td><td class="px-4 py-3 text-right"><a href="{{ route('classes.show', $class) }}" class="rounded-lg border border-[#17243f]/15 bg-white px-3 py-1.5 text-xs font-semibold hover:bg-[#e5e7eb]">Lihat Kelas</a></td></tr>
                        @endforeach
                    </tbody></table></div></div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
