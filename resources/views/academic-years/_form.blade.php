@csrf
@if ($mode === 'edit')
    @method('PUT')
@endif
<div>
    <label for="tahun" class="mb-2 block text-sm font-semibold">Tahun Ajaran</label>
    <input id="tahun" name="tahun" value="{{ old('tahun', $academicYear->tahun ?? '') }}" placeholder="2026/2027" pattern="\d{4}/\d{4}" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
    <p class="mt-2 text-xs text-slate-500">Gunakan format tahun, misalnya 2026/2027.</p>
    @error('tahun')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
<div>
    <label for="semester" class="mb-2 block text-sm font-semibold">Semester</label>
    <select id="semester" name="semester" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
        <option value="">Pilih semester</option>
        <option value="Ganjil" {{ old('semester', $academicYear->semester ?? '') === 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
        <option value="Genap" {{ old('semester', $academicYear->semester ?? '') === 'Genap' ? 'selected' : '' }}>Genap</option>
    </select>
    @error('semester')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
<label class="flex items-start gap-3 rounded-xl border border-[#17243f]/10 bg-[#f8f7f2] p-4"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $academicYear->is_active ?? false) ? 'checked' : '' }} class="mt-1 h-4 w-4 accent-[#17243f]"><span><span class="block text-sm font-semibold">Jadikan periode aktif</span><span class="mt-1 block text-xs text-slate-500">Periode aktif sebelumnya akan otomatis menjadi nonaktif.</span></span></label>
<div class="flex justify-end gap-3"><a href="{{ route('academic-years.index') }}" class="rounded-full bg-[#e5e7eb] px-5 py-2.5 text-sm font-semibold hover:bg-[#d1d5db]">Batal</a><button type="submit" class="rounded-full bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">{{ $mode === 'edit' ? 'Perbarui' : 'Simpan' }}</button></div>
