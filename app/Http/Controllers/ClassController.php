<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $classes = ClassModel::with(['teacher', 'students'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nama_kelas', 'like', "%{$search}%")
                    ->orWhereHas('teacher', function ($teacherQuery) use ($search) {
                        $teacherQuery->where('nama', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->get();

        return view('classes.index', compact('classes', 'search'));
    }

    public function show(ClassModel $class): View
    {
        $class->load(['teacher', 'students' => fn ($query) => $query->orderBy('nama')]);
        $targetClasses = ClassModel::where('id', '!=', $class->id)->orderBy('nama_kelas')->get();

        return view('classes.show', compact('class', 'targetClasses'));
    }

    public function promoteStudents(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'source_class_id' => ['required', 'exists:classes,id'],
            'target_class_id' => ['required', 'exists:classes,id'],
        ]);

        if ($validated['source_class_id'] === $validated['target_class_id']) {
            return redirect()->route('classes.index')->with('error', 'Kelas asal dan kelas tujuan harus berbeda.');
        }

        $studentCount = Student::where('class_id', $validated['source_class_id'])->count();

        if ($studentCount === 0) {
            return redirect()->route('classes.index')->with('error', 'Kelas asal belum memiliki siswa yang dapat dinaikkan.');
        }

        DB::transaction(function () use ($validated) {
            Student::where('class_id', $validated['source_class_id'])
                ->update(['class_id' => $validated['target_class_id']]);
        });

        return redirect()->route('classes.index')->with('success', $studentCount . ' siswa berhasil dipindahkan ke kelas tujuan.');
    }

    public function promoteSelectedStudents(Request $request, ClassModel $class): RedirectResponse
    {
        $validated = $request->validate([
            'target_class_id' => ['required', Rule::exists('classes', 'id'), Rule::notIn([$class->id])],
            'student_ids' => ['required', 'array', 'min:1'],
            'student_ids.*' => ['integer', 'exists:students,id'],
        ]);

        $studentIds = Student::where('class_id', $class->id)
            ->whereIn('id', $validated['student_ids'])
            ->pluck('id');

        if ($studentIds->isEmpty()) {
            return redirect()->route('classes.show', $class)->with('error', 'Tidak ada siswa valid yang dipilih untuk dinaikkan.');
        }

        Student::whereIn('id', $studentIds)->update(['class_id' => $validated['target_class_id']]);

        return redirect()->route('classes.show', $class)->with('success', $studentIds->count() . ' siswa berhasil dinaikkan. Siswa yang tidak dicentang tetap di kelas ini.');
    }

    public function create(): View
    {
        $teachers = Teacher::orderBy('nama')->get();
        $academicYears = AcademicYear::orderByDesc('is_active')->orderByDesc('tahun')->get();

        return view('classes.create', compact('teachers', 'academicYears'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255', 'unique:classes,nama_kelas'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
        ]);

        ClassModel::create($validated);

        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(ClassModel $class): View
    {
        $teachers = Teacher::orderBy('nama')->get();
        $academicYears = AcademicYear::orderByDesc('is_active')->orderByDesc('tahun')->get();

        return view('classes.edit', compact('class', 'teachers', 'academicYears'));
    }

    public function update(Request $request, ClassModel $class): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255', 'unique:classes,nama_kelas,' . $class->id],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(ClassModel $class): RedirectResponse
    {
        if ($class->students()->exists()) {
            return redirect()->route('classes.index')->with('error', 'Kelas tidak bisa dihapus karena masih memiliki data siswa. Pindahkan atau hapus siswanya terlebih dahulu.');
        }

        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
