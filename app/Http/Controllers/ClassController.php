<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $classes = ClassModel::with('teacher')
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

    public function create(): View
    {
        $teachers = Teacher::orderBy('nama')->get();

        return view('classes.create', compact('teachers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255', 'unique:classes,nama_kelas'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        ClassModel::create($validated);

        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(ClassModel $class): View
    {
        $teachers = Teacher::orderBy('nama')->get();

        return view('classes.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, ClassModel $class): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255', 'unique:classes,nama_kelas,' . $class->id],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(ClassModel $class): RedirectResponse
    {
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
