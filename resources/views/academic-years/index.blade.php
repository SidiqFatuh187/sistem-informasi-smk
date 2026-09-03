<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahun Ajaran — SMK Wira Cipta Karya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#f8f7f2] text-[#17243f]">
    <div class="flex min-h-screen">
        @include('partials.sidebar')
        <main class="min-w-0 flex-1">
            <header class="border-b border-[#17243f]/10 bg-[#f3f4f6]">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-4">
                    <div><p class="text-sm text-slate-500">Manajemen</p><h1 class="text-xl font-bold">Tahun Ajaran</h1></div>
                    <a href="{{ route('academic-years.create') }}" class="rounded-full bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">+ Tambah Tahun Ajaran</a>
                </div>
            </header>
            <div class="mx-auto max-w-7xl px-6 py-10">
                @if (session('success'))<div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>@endif
                @if (session('error'))<div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>@endif
                <div class="mb-6 rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5 shadow-sm">
                    <h2 class="text-lg font-bold">Periode Akademik</h2>
                    <p class="mt-1 text-sm text-slate-500">Hanya satu tahun ajaran yang dapat berstatus aktif dan digunakan sebagai periode berjalan.</p>
                </div>
                @if ($academicYears->isEmpty())
                    <div class="rounded-2xl border border-dashed border-[#17243f]/15 bg-[#f3f4f6] p-8 text-center shadow-sm"><h2 class="text-xl font-bold">Belum ada tahun ajaran</h2><p class="mt-2 text-sm text-slate-500">Tambahkan periode akademik pertama.</p><a href="{{ route('academic-years.create') }}" class="mt-6 inline-flex rounded-full bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">+ Tambah Tahun Ajaran</a></div>
                @else
                    <div class="overflow-hidden rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] shadow-sm"><div class="overflow-x-auto"><table class="min-w-full divide-y divide-[#17243f]/10"><thead class="bg-[#e5e7eb]"><tr><th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tahun Ajaran</th><th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Semester</th><th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jumlah Kelas</th><th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th><th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th></tr></thead><tbody class="divide-y divide-[#17243f]/10">
                        @foreach ($academicYears as $academicYear)
                            <tr class="hover:bg-white/60"><td class="px-4 py-3 text-sm font-medium"><a href="{{ route('academic-years.show', $academicYear) }}" class="hover:underline">{{ $academicYear->tahun }}</a></td><td class="px-4 py-3 text-sm">Semester {{ $academicYear->semester }}</td><td class="px-4 py-3 text-sm"><a href="{{ route('academic-years.show', $academicYear) }}" class="hover:underline">Lihat {{ $academicYear->classes_count ?? $academicYear->classes->count() }} kelas</a></td><td class="px-4 py-3 text-sm">@if ($academicYear->is_active)<span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span>@else<span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">Nonaktif</span>@endif</td><td class="px-4 py-3 text-right"><div class="flex justify-end gap-2"><a href="{{ route('academic-years.edit', $academicYear) }}" class="rounded-lg border border-amber-300 bg-amber-50 px-3 py-1.5 text-xs font-semibold hover:bg-amber-100">Edit</a>@if (!$academicYear->is_active)<form method="POST" action="{{ route('academic-years.activate', $academicYear) }}">@csrf<button type="submit" class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-100">Aktifkan</button></form><x-delete :action="route('academic-years.destroy', $academicYear)" :name="$academicYear->tahun . ' - ' . $academicYear->semester" />@endif</div></td></tr>
                        @endforeach
                    </tbody></table></div></div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
