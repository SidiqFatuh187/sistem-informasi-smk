<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $classId = $request->input('class_id');
        $gender = $request->input('jenis_kelamin');

        $classes = ClassModel::orderBy('nama_kelas')->get();

        $students = Student::with('classRoom.teacher')
            ->when($classId !== null && $classId !== '', function ($query) use ($classId) {
                $query->where('class_id', $classId);
            })
            ->when($gender !== null && $gender !== '', function ($query) use ($gender) {
                $query->where('jenis_kelamin', $gender);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%")
                        ->orWhereHas('classRoom', function ($classQuery) use ($search) {
                            $classQuery->where('nama_kelas', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->get();

        return view('students.index', compact('students', 'search', 'classes', 'classId', 'gender'));
    }

    public function create(): View
    {
        $classes = ClassModel::orderBy('nama_kelas')->get();

        return view('students.create', compact('classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nisn' => ['required', 'string', 'max:20', 'unique:students,nisn'],
            'nama' => ['required', 'string', 'max:255'],
            'class_id' => ['required', 'exists:classes,id'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student): View
    {
        $classes = ClassModel::orderBy('nama_kelas')->get();

        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'nisn' => ['required', 'string', 'max:20', 'unique:students,nisn,' . $student->id],
            'nama' => ['required', 'string', 'max:255'],
            'class_id' => ['required', 'exists:classes,id'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
