<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(Request $request): View
    {
        $academicYearId = $request->input('academic_year_id');
        $day = $request->input('day');
        $classId = $request->input('class_id');
        $academicYears = AcademicYear::orderByDesc('is_active')->orderByDesc('tahun')->get();
        $classes = ClassModel::when($request->user()->role !== 'admin', function ($query) use ($request) {
            $query->whereHas('schedules', fn ($scheduleQuery) => $scheduleQuery->where('teacher_id', $request->user()->teacher?->id ?? -1));
        })->orderBy('nama_kelas')->get();

        $schedules = Schedule::with(['academicYear', 'classRoom', 'teacher'])
            ->when($request->user()->role !== 'admin', function ($query) use ($request) {
                $query->where('teacher_id', $request->user()->teacher?->id ?? -1);
            })
            ->when($academicYearId, fn ($query) => $query->where('academic_year_id', $academicYearId))
            ->when($day, fn ($query) => $query->where('day', $day))
            ->when($classId, fn ($query) => $query->where('class_id', $classId))
            ->orderByRaw("CASE day WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 ELSE 7 END")
            ->orderBy('start_time')
            ->get();

        return view('schedules.index', compact('schedules', 'academicYears', 'academicYearId', 'day', 'classes', 'classId'));
    }

    public function create(): View
    {
        return view('schedules.create', $this->formOptions());
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);
        $this->ensureClassBelongsToAcademicYear($validated);
        Schedule::create($validated);

        return redirect()->route('schedules.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule): View
    {
        return view('schedules.edit', array_merge(['schedule' => $schedule], $this->formOptions()));
    }

    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        $validated = $this->validateData($request);
        $this->ensureClassBelongsToAcademicYear($validated);
        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Jadwal pelajaran berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }

    private function formOptions(): array
    {
        return [
            'academicYears' => AcademicYear::orderByDesc('is_active')->orderByDesc('tahun')->get(),
            'classes' => ClassModel::orderBy('nama_kelas')->get(),
            'teachers' => Teacher::orderBy('nama')->get(),
            'days' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        ];
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'class_id' => ['required', 'exists:classes,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'subject' => ['required', 'string', 'max:255'],
            'day' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);
    }

    private function ensureClassBelongsToAcademicYear(array $validated): void
    {
        abort_unless(
            ClassModel::whereKey($validated['class_id'])
                ->where('academic_year_id', $validated['academic_year_id'])
                ->exists(),
            422,
            'Kelas yang dipilih bukan bagian dari tahun ajaran tersebut.'
        );
    }
}
