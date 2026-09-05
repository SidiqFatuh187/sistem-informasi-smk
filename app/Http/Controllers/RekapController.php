<?php

namespace App\Http\Controllers;

use App\Exports\KehadiranKelasExport;
use App\Models\AcademicYear;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $academicYear = $this->resolveAcademicYear($request);

         $classes = ClassModel::query()
            ->where('academic_year_id', $academicYear?->id)
            ->with('teacher')
            ->withCount('students')
            ->withCount(['attendances as attendance_count' => fn ($q) => $q->where('academic_year_id', $academicYear?->id)])
            ->withCount(['attendances as hadir_count' => fn ($q) => $q->where('academic_year_id', $academicYear?->id)->where('status', 'hadir')])
            ->withCount(['attendances as sakit_count' => fn ($q) => $q->where('academic_year_id', $academicYear?->id)->where('status', 'sakit')])
            ->withCount(['attendances as izin_count' => fn ($q) => $q->where('academic_year_id', $academicYear?->id)->where('status', 'izin')])
            ->withCount(['attendances as alpa_count' => fn ($q) => $q->where('academic_year_id', $academicYear?->id)->where('status', 'alpa')])
            ->orderBy('nama_kelas')
            ->get();

        return view('rekap.index', [
            'classes' => $classes,
            'academicYear' => $academicYear,
            'academicYears' => AcademicYear::orderByDesc('tahun')->orderByDesc('semester')->get(),
        ]);
    }

    public function show(Request $request, ClassModel $class)
    {
        $academicYear = $this->resolveAcademicYear($request);
        $subject = $request->query('subject');

        $subjects = $class->schedules()
            ->where('academic_year_id', $academicYear?->id)
            ->orderBy('subject')
            ->pluck('subject')
            ->unique()
            ->values();

        $recap = $this->buildRecap($class, $academicYear, $subject);

        return view('rekap.show', [
            'class' => $class,
            'academicYear' => $academicYear,
            'subject' => $subject,
            'subjects' => $subjects,
            'recap' => $recap,
        ]);
    }

    public function export(Request $request, ClassModel $class)
    {
        $academicYear = $this->resolveAcademicYear($request);
        $subject = $request->query('subject');

        $filename = 'rekap-' . str($class->nama_kelas)->slug() . '-' .
            str($academicYear?->tahun . '-' . $academicYear?->semester)->slug() . '.xlsx';

        return Excel::download(new KehadiranKelasExport($class, $academicYear, $subject), $filename);
    }

    private function buildRecap(ClassModel $class, ?AcademicYear $academicYear, ?string $subject)
    {
        return $class->students()->orderBy('nama')->get()->map(function ($student) use ($academicYear, $subject) {
            $query = $student->attendances()->where('academic_year_id', $academicYear?->id);

            if ($subject) {
                $query->whereHas('schedule', fn ($q) => $q->where('subject', $subject));
            }

            $rows = $query->get();
            $total = $rows->count();
            $hadir = $rows->where('status', 'hadir')->count();

            return [
                'student' => $student,
                'hadir' => $hadir,
                'sakit' => $rows->where('status', 'sakit')->count(),
                'izin' => $rows->where('status', 'izin')->count(),
                'alpa' => $rows->where('status', 'alpa')->count(),
                'total' => $total,
                'persentase' => $total > 0 ? round($hadir / $total * 100, 1) : 0,
            ];
        });
    }

    private function resolveAcademicYear(Request $request): ?AcademicYear
    {
        if ($request->filled('academic_year_id')) {
            return AcademicYear::find($request->integer('academic_year_id'));
        }

        return AcademicYear::where('is_active', true)->first();
    }
}