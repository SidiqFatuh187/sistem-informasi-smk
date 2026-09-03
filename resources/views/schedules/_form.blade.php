@csrf
@if ($mode === 'edit')
    @method('PUT')
@endif

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label for="academic_year_id" class="mb-2 block text-sm font-semibold">Tahun Ajaran</label>
        <select id="academic_year_id" name="academic_year_id" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
            <option value="">Pilih tahun ajaran</option>
            @foreach ($academicYears as $academicYear)
                <option value="{{ $academicYear->id }}" {{ old('academic_year_id', $schedule->academic_year_id ?? ($academicYear->is_active ? $academicYear->id : '')) == $academicYear->id ? 'selected' : '' }}>{{ $academicYear->tahun }} - {{ $academicYear->semester }}{{ $academicYear->is_active ? ' (Aktif)' : '' }}</option>
            @endforeach
        </select>
        @error('academic_year_id')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="class_id" class="mb-2 block text-sm font-semibold">Kelas</label>
        <select id="class_id" name="class_id" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
            <option value="">Pilih kelas</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}" {{ old('class_id', $schedule->class_id ?? '') == $class->id ? 'selected' : '' }}>{{ $class->nama_kelas }}</option>
            @endforeach
        </select>
        @error('class_id')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="teacher_id" class="mb-2 block text-sm font-semibold">Guru Pengajar</label>
        <select id="teacher_id" name="teacher_id" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
            <option value="">Pilih guru pengajar</option>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ old('teacher_id', $schedule->teacher_id ?? '') == $teacher->id ? 'selected' : '' }}>{{ $teacher->nama }}</option>
            @endforeach
        </select>
        @error('teacher_id')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="subject" class="mb-2 block text-sm font-semibold">Mata Pelajaran</label>
        <input id="subject" name="subject" value="{{ old('subject', $schedule->subject ?? '') }}" placeholder="Matematika" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
        @error('subject')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="day" class="mb-2 block text-sm font-semibold">Hari</label>
        <select id="day" name="day" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none">
            <option value="">Pilih hari</option>
            @foreach ($days as $day)
                <option value="{{ $day }}" {{ old('day', $schedule->day ?? '') === $day ? 'selected' : '' }}>{{ $day }}</option>
            @endforeach
        </select>
        @error('day')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div><label for="start_time" class="mb-2 block text-sm font-semibold">Mulai</label><input id="start_time" name="start_time" type="time" value="{{ old('start_time', isset($schedule) ? substr($schedule->start_time, 0, 5) : '') }}" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none"></div>
        <div><label for="end_time" class="mb-2 block text-sm font-semibold">Selesai</label><input id="end_time" name="end_time" type="time" value="{{ old('end_time', isset($schedule) ? substr($schedule->end_time, 0, 5) : '') }}" required class="w-full rounded-xl border border-[#17243f]/15 bg-[#f8f7f2] px-4 py-3 text-sm focus:border-[#17243f] focus:outline-none"></div>
    </div>
</div>

<div class="flex justify-end gap-3"><a href="{{ route('schedules.index') }}" class="rounded-full bg-[#e5e7eb] px-5 py-2.5 text-sm font-semibold hover:bg-[#d1d5db]">Batal</a><button type="submit" class="rounded-full bg-black px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">{{ $mode === 'edit' ? 'Perbarui' : 'Simpan' }}</button></div>
