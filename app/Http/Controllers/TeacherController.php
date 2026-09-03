<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $teachers = Teacher::with(['user', 'classes'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($teacherQuery) use ($search) {
                    $teacherQuery->where('nama', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama')
            ->get();

        return view('teachers.index', compact('teachers', 'search'));
    }

    public function create(): View
    {
        $classes = ClassModel::with('teacher')->orderBy('nama_kelas')->get();

        return view('teachers.create', compact('classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255', 'unique:teachers,nip'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'class_ids' => ['nullable', 'array'],
            'class_ids.*' => ['integer', 'exists:classes,id'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = $this->createUser($validated);
            $teacher = Teacher::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'] ?? null,
            ]);

            $this->assignClasses($teacher, $validated['class_ids'] ?? []);
        });

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher): View
    {
        $teacher->load('user', 'classes');
        $classes = ClassModel::with('teacher')->orderBy('nama_kelas')->get();

        return view('teachers.edit', compact('teacher', 'classes'));
    }

    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255', Rule::unique('teachers', 'nip')->ignore($teacher->id)],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($teacher->user_id)],
            'password' => ['nullable', 'string', 'min:8'],
            'class_ids' => ['nullable', 'array'],
            'class_ids.*' => ['integer', 'exists:classes,id'],
        ]);

        DB::transaction(function () use ($validated, $teacher) {
            $teacher->update([
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'] ?? null,
            ]);

            $userData = [
                'name' => $validated['nama'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $teacher->user()->update($userData);
            $this->assignClasses($teacher, $validated['class_ids'] ?? []);
        });

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        DB::transaction(function () use ($teacher) {
            $teacher->classes()->update(['teacher_id' => null]);
            $user = $teacher->user;
            $teacher->delete();
            $user?->delete();
        });

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil dihapus.');
    }

    private function createUser(array $validated)
    {
        return \App\Models\User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'guru',
        ]);
    }

    private function assignClasses(Teacher $teacher, array $classIds): void
    {
        ClassModel::where('teacher_id', $teacher->id)->update(['teacher_id' => null]);

        if ($classIds !== []) {
            ClassModel::whereIn('id', $classIds)->update(['teacher_id' => $teacher->id]);
        }
    }
}
