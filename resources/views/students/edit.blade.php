<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa — SMK Wira Cipta Karya</title>
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
                        <h1 class="font-bold text-xl">Edit Siswa</h1>
                    </div>
                    <a href="{{ route('students.index') }}" class="border border-ink/10 px-4 py-2 rounded-full text-sm font-semibold text-ink hover:bg-[#e5e7eb]">
                        Kembali
                    </a>
                </div>
            </header>

            <div class="max-w-4xl mx-auto px-6 py-10">
                <div class="bg-[#f3f4f6] rounded-2xl border border-ink/10 shadow-sm p-6">
                    <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="nisn" class="block text-sm font-semibold text-ink mb-2">NISN</label>
                            <input id="nisn" name="nisn" value="{{ old('nisn', $student->nisn) }}" required class="w-full rounded-xl border border-ink/15 bg-cream/60 px-4 py-3 text-sm focus:outline-none focus:border-navy">
                            @error('nisn')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama" class="block text-sm font-semibold text-ink mb-2">Nama Siswa</label>
                            <input id="nama" name="nama" value="{{ old('nama', $student->nama) }}" required class="w-full rounded-xl border border-ink/15 bg-cream/60 px-4 py-3 text-sm focus:outline-none focus:border-navy">
                            @error('nama')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="class_id" class="block text-sm font-semibold text-ink mb-2">Kelas</label>
                            <select id="class_id" name="class_id" required class="w-full rounded-xl border border-ink/15 bg-cream/60 px-4 py-3 text-sm focus:outline-none focus:border-navy">
                                <option value="">Pilih kelas</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>{{ $class->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-semibold text-ink mb-2">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full rounded-xl border border-ink/15 bg-cream/60 px-4 py-3 text-sm focus:outline-none focus:border-navy">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('students.index') }}" class="rounded-full bg-[#e5e7eb] px-5 py-2.5 text-sm font-semibold text-ink hover:bg-[#d1d5db]">Batal</a>
                            <button type="submit" class="rounded-full bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
