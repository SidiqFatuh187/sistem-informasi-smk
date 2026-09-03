<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas — SMK Wira Cipta Karya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cream text-ink min-h-screen">
    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <main class="flex-1 bg-cream">
            <header class="bg-[#f3f4f6] border-b border-ink/10">
                <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate">Data Master</p>
                        <h1 class="font-bold text-xl">Edit Kelas</h1>
                    </div>
                    <a href="{{ route('classes.index') }}" class="bg-black text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-slate-800">
                        Kembali
                    </a>
                </div>
            </header>

            <div class="max-w-4xl mx-auto px-6 py-10">
                <div class="bg-[#f3f4f6] rounded-2xl border border-ink/10 shadow-sm p-6">
                    <form method="POST" action="{{ route('classes.update', $class) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="nama_kelas" class="block text-sm font-semibold text-ink mb-2">Nama Kelas</label>
                            <input id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $class->nama_kelas) }}" required class="w-full rounded-xl border border-ink/15 bg-cream/60 px-4 py-3 text-sm focus:outline-none focus:border-navy">
                            @error('nama_kelas')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="teacher_id" class="block text-sm font-semibold text-ink mb-2">Wali Kelas</label>
                            <select id="teacher_id" name="teacher_id" class="w-full rounded-xl border border-ink/15 bg-cream/60 px-4 py-3 text-sm focus:outline-none focus:border-navy">
                                <option value="">Pilih wali kelas</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $class->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->nama }}</option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="academic_year_id" class="block text-sm font-semibold text-ink mb-2">Tahun Ajaran</label>
                            <select id="academic_year_id" name="academic_year_id" required class="w-full rounded-xl border border-ink/15 bg-cream/60 px-4 py-3 text-sm focus:outline-none focus:border-navy">
                                <option value="">Pilih tahun ajaran</option>
                                @foreach ($academicYears as $academicYear)
                                    <option value="{{ $academicYear->id }}" {{ old('academic_year_id', $class->academic_year_id) == $academicYear->id ? 'selected' : '' }}>{{ $academicYear->tahun }} - {{ $academicYear->semester }}{{ $academicYear->is_active ? ' (Aktif)' : '' }}</option>
                                @endforeach
                            </select>
                            @error('academic_year_id')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('classes.index') }}" class="rounded-full bg-[#e5e7eb] px-5 py-2.5 text-sm font-semibold text-ink hover:bg-[#d1d5db]">Batal</a>
                            <button type="submit" class="rounded-full bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
