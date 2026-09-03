<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    public function index(): View
    {
        $academicYears = AcademicYear::withCount('classes')
            ->orderByDesc('is_active')
            ->orderByDesc('tahun')
            ->orderBy('semester')
            ->get();

        return view('academic-years.index', compact('academicYears'));
    }

    public function show(AcademicYear $academicYear): View
    {
        $academicYear->load(['classes' => fn ($query) => $query->with(['teacher', 'students'])->orderBy('nama_kelas')]);

        return view('academic-years.show', compact('academicYear'));
    }

    public function create(): View
    {
        return view('academic-years.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        DB::transaction(function () use ($validated) {
            if ($validated['is_active'] ?? false) {
                AcademicYear::where('is_active', true)->update(['is_active' => false]);
            }

            AcademicYear::create($validated);
        });

        return redirect()->route('academic-years.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit(AcademicYear $academicYear): View
    {
        return view('academic-years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear): RedirectResponse
    {
        $validated = $this->validateData($request, $academicYear);

        DB::transaction(function () use ($validated, $academicYear) {
            if ($validated['is_active'] ?? false) {
                AcademicYear::where('id', '!=', $academicYear->id)->where('is_active', true)->update(['is_active' => false]);
            }

            $academicYear->update($validated);
        });

        return redirect()->route('academic-years.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function activate(AcademicYear $academicYear): RedirectResponse
    {
        DB::transaction(function () use ($academicYear) {
            AcademicYear::where('is_active', true)->update(['is_active' => false]);
            $academicYear->update(['is_active' => true]);
        });

        return redirect()->route('academic-years.index')->with('success', 'Tahun ajaran ' . $academicYear->tahun . ' semester ' . $academicYear->semester . ' sekarang aktif.');
    }

    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        if ($academicYear->is_active) {
            return redirect()->route('academic-years.index')->with('error', 'Tahun ajaran aktif tidak bisa dihapus. Aktifkan periode lain terlebih dahulu.');
        }

        $academicYear->delete();

        return redirect()->route('academic-years.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    private function validateData(Request $request, ?AcademicYear $academicYear = null): array
    {
        return $request->validate([
            'tahun' => ['required', 'string', 'regex:/^\d{4}\/\d{4}$/'],
            'semester' => [
                'required',
                Rule::in(['Ganjil', 'Genap']),
                Rule::unique('academic_years')->where(fn ($query) => $query->where('tahun', $request->input('tahun')))->ignore($academicYear?->id),
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
