<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $class->nama_kelas }} — SMK Wira Cipta Karya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#f8f7f2] text-[#17243f]">
    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <main class="min-w-0 flex-1">
            <header class="border-b border-[#17243f]/10 bg-[#f3f4f6]">
                <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-6 py-4">
                    <div>
                        <p class="text-sm text-slate-500">Detail Kelas</p>
                        <h1 class="text-xl font-bold">{{ $class->nama_kelas }}</h1>
                    </div>
                    <a href="{{ route('classes.index') }}" class="rounded-full bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Kembali</a>
                </div>
            </header>

            <div class="mx-auto max-w-5xl px-6 py-10">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
                @endif

                <div class="mb-6 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Wali Kelas</p><p class="mt-2 font-bold">{{ $class->teacher?->nama ?? 'Belum ditentukan' }}</p></div>
                    <div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Jumlah Siswa</p><p class="mt-2 text-2xl font-bold">{{ $class->students->count() }}</p></div>
                    <div class="rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Keterangan</p><p class="mt-2 text-sm text-slate-600">Centang siswa yang naik kelas.</p></div>
                </div>

                <form id="selectedPromotionForm" method="POST" action="{{ route('classes.promote-selected-students', $class) }}">
                    @csrf
                    <div class="mb-6 rounded-2xl border border-[#17243f]/10 bg-[#f3f4f6] p-5 shadow-sm">
                        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <h2 class="text-lg font-bold">Kenaikan Siswa</h2>
                                <p class="mt-1 text-sm text-slate-500">Siswa yang tidak dicentang akan tetap berada di kelas {{ $class->nama_kelas }}.</p>
                            </div>
                            <div class="w-full sm:w-64">
                                <label for="target_class_id" class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Kelas tujuan</label>
                                <select id="target_class_id" name="target_class_id" required class="w-full rounded-xl border border-[#17243f]/10 bg-white px-4 py-3 text-sm focus:border-[#17243f]/30 focus:outline-none">
                                    <option value="">Pilih kelas tujuan</option>
                                    @foreach ($targetClasses as $targetClass)
                                        <option value="{{ $targetClass->id }}">{{ $targetClass->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('target_class_id')<p class="mb-3 text-xs text-red-600">{{ $message }}</p>@enderror

                        @if ($class->students->isEmpty())
                            <p class="rounded-xl border border-dashed border-[#17243f]/15 bg-white p-6 text-center text-sm text-slate-500">Belum ada siswa di kelas ini.</p>
                        @else
                            <div class="overflow-x-auto rounded-xl border border-[#17243f]/10 bg-white">
                                <table class="min-w-full divide-y divide-[#17243f]/10">
                                    <thead class="bg-[#e5e7eb]"><tr>
                                        <th class="w-12 px-4 py-3"><input id="selectAllStudents" type="checkbox" class="h-4 w-4 accent-[#17243f]"></th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">NISN</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Siswa</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jenis Kelamin</th>
                                    </tr></thead>
                                    <tbody class="divide-y divide-[#17243f]/10">
                                        @foreach ($class->students as $student)
                                            <tr class="hover:bg-[#f8f7f2]">
                                                <td class="px-4 py-3"><input name="student_ids[]" value="{{ $student->id }}" type="checkbox" class="student-checkbox h-4 w-4 accent-[#17243f]"></td>
                                                <td class="px-4 py-3 text-sm">{{ $student->nisn }}</td>
                                                <td class="px-4 py-3 text-sm font-medium">{{ $student->nama }}</td>
                                                <td class="px-4 py-3 text-sm">{{ $student->jenis_kelamin }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @error('student_ids')<p class="mt-3 text-xs text-red-600">{{ $message }}</p>@enderror
                        <div class="mt-5 flex justify-end">
                            <x-confirm
                                :action="route('classes.promote-selected-students', $class)"
                                title="Konfirmasi Kenaikan Siswa"
                                message="Siswa yang dicentang akan dipindahkan ke kelas tujuan. Siswa yang tidak dicentang tetap di kelas ini. Lanjutkan?"
                                confirm-text="Ya, Naikkan"
                                button-text="Naikkan Siswa Terpilih"
                                form-id="selectedPromotionForm"
                            />
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        const selectAll = document.getElementById('selectAllStudents');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');

        selectAll?.addEventListener('change', function () {
            studentCheckboxes.forEach((checkbox) => checkbox.checked = this.checked);
        });
    </script>
</body>
</html>
