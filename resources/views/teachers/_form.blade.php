@csrf
@if ($mode === 'edit')
    @method('PUT')
@endif

@php
    $teacher = $teacher ?? null;
    $assignedClassIds = $teacher?->classes?->pluck('id')->all() ?? [];
@endphp

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label for="nama" class="mb-2 block text-sm font-semibold">Nama Guru</label>
        <input id="nama" name="nama" value="{{ old('nama', $teacher->nama ?? '') }}" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
        @error('nama')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="nip" class="mb-2 block text-sm font-semibold">NIP</label>
        <input id="nip" name="nip" value="{{ old('nip', $teacher->nip ?? '') }}" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
        @error('nip')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="no_hp" class="mb-2 block text-sm font-semibold">Nomor HP</label>
        <input id="no_hp" name="no_hp" value="{{ old('no_hp', $teacher->no_hp ?? '') }}" class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
        @error('no_hp')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="email" class="mb-2 block text-sm font-semibold">Email Login</label>
        <input id="email" name="email" type="email" value="{{ old('email', $teacher->user->email ?? '') }}" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
        @error('email')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label for="password" class="mb-2 block text-sm font-semibold">{{ $mode === 'edit' ? 'Password Baru (opsional)' : 'Password Login' }}</label>
        <input id="password" name="password" type="password" {{ $mode === 'create' ? 'required' : '' }} class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
        <p class="mt-2 text-xs text-slate-500">Minimal 8 karakter.</p>
        @error('password')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="border-t border-[#17243f]/10 pt-5">
    <div class="mb-3"><h2 class="text-base font-bold">Kelas yang Diampu</h2><p class="mt-1 text-sm text-slate-500">Pilih kelas yang menjadi tanggung jawab guru ini sebagai wali kelas.</p></div>
    @error('class_ids')<p class="mb-2 text-xs text-red-600">{{ $message }}</p>@enderror
    <div class="grid gap-3 sm:grid-cols-2">
        @foreach ($classes as $class)
            @php $selected = in_array($class->id, old('class_ids', $assignedClassIds)); @endphp
            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-[#17243f]/10 bg-[#f8f7f2] p-3 hover:border-[#f5b63f]">
                <input type="checkbox" name="class_ids[]" value="{{ $class->id }}" {{ $selected ? 'checked' : '' }} class="mt-1 h-4 w-4 accent-[#17243f]">
                <span class="min-w-0 text-sm"><span class="block font-semibold">{{ $class->nama_kelas }}</span><span class="block text-xs text-slate-500">Wali kelas saat ini: {{ $class->teacher?->nama ?? 'Belum ditentukan' }}</span></span>
            </label>
        @endforeach
    </div>
    @if ($classes->isEmpty())<p class="text-sm text-slate-500">Belum ada kelas. Buat kelas terlebih dahulu.</p>@endif
    @error('class_ids.*')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div class="flex justify-end gap-3">
    <a href="{{ route('teachers.index') }}" class="rounded-full bg-[#e5e7eb] px-5 py-2.5 text-sm font-semibold hover:bg-[#d1d5db]">Batal</a>
    <button type="submit" class="rounded-full bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">{{ $mode === 'edit' ? 'Perbarui' : 'Simpan' }}</button>
</div>
