<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $academicYear = AcademicYear::where('is_active', true)->first();

        if ($user->role === 'guru') {
            return $this->guru($user->teacher, $academicYear);
        }

        if ($user->role === 'kepala_sekolah') {
            return $this->kepalaSekolah($academicYear);
        }

        return $this->admin($academicYear);
    }

    private function admin(?AcademicYear $academicYear)
    {
        $totalStudents = Student::whereHas('classRoom', fn ($q) => $q->where('academic_year_id', $academicYear?->id))->count();
        $totalTeachers = Teacher::count();
        $totalClasses = ClassModel::where('academic_year_id', $academicYear?->id)->count();

        $todayAttendances = Attendance::where('academic_year_id', $academicYear?->id)
            ->whereDate('date', Carbon::today())
            ->get();

        $totalToday = $todayAttendances->count();
        $hadirToday = $todayAttendances->where('status', 'hadir')->count();
        $persenHadirToday = $totalToday > 0 ? round($hadirToday / $totalToday * 100, 1) : null;

        $trend = collect(range(6, 0))->map(function ($daysAgo) use ($academicYear) {
            $date = Carbon::today()->subDays($daysAgo);

            $rows = Attendance::where('academic_year_id', $academicYear?->id)
                ->whereDate('date', $date)
                ->get();

            $total = $rows->count();
            $hadir = $rows->where('status', 'hadir')->count();

            return [
                'label' => $date->translatedFormat('D, d M'),
                'persentase' => $total > 0 ? round($hadir / $total * 100, 1) : 0,
            ];
        });

        return view('dashboard', [
            'mode' => 'admin',
            'academicYear' => $academicYear,
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalClasses' => $totalClasses,
            'persenHadirToday' => $persenHadirToday,
            'totalToday' => $totalToday,
            'trend' => $trend,
        ]);
    }

    private function guru(?Teacher $teacher, ?AcademicYear $academicYear)
    {
        if (! $teacher) {
            return view('dashboard', [
                'mode' => 'guru',
                'academicYear' => $academicYear,
                'todaySchedules' => collect(),
                'totalToday' => 0,
                'completeToday' => 0,
                'pendingToday' => 0,
                'totalClasses' => 0,
                'waliKelas' => null,
            ]);
        }

        $timezone = config('app.timezone', 'Asia/Jakarta');
        $now = Carbon::now($timezone);
        $today = $now->toDateString();
        $todayName = $this->indonesianDay($now);

        $todaySchedules = Schedule::with('classRoom')
            ->where('teacher_id', $teacher->id)
            ->where('academic_year_id', $academicYear?->id)
            ->where('day', $todayName)
            ->orderBy('start_time')
            ->get()
            ->map(function (Schedule $schedule) use ($today) {
                $totalStudents = $schedule->classRoom->students()->count();
                $attendanceCount = Attendance::where('schedule_id', $schedule->id)
                    ->whereDate('date', $today)
                    ->distinct('student_id')
                    ->count('student_id');

                $schedule->total_students = $totalStudents;
                $schedule->attendance_count = $attendanceCount;
                $schedule->is_complete = $totalStudents > 0 && $attendanceCount >= $totalStudents;

                return $schedule;
            });

        $totalToday = $todaySchedules->count();
        $completeToday = $todaySchedules->where('is_complete', true)->count();
        $pendingToday = $totalToday - $completeToday;

        $totalClasses = Schedule::where('teacher_id', $teacher->id)
            ->where('academic_year_id', $academicYear?->id)
            ->distinct('class_id')
            ->count('class_id');

        $waliKelas = ClassModel::where('teacher_id', $teacher->id)
            ->where('academic_year_id', $academicYear?->id)
            ->withCount('students')
            ->first();

        return view('dashboard', [
            'mode' => 'guru',
            'academicYear' => $academicYear,
            'todaySchedules' => $todaySchedules,
            'totalToday' => $totalToday,
            'completeToday' => $completeToday,
            'pendingToday' => $pendingToday,
            'totalClasses' => $totalClasses,
            'waliKelas' => $waliKelas,
            'today' => $today,
        ]);
    }

    private function kepalaSekolah(?AcademicYear $academicYear)
    {
        $classes = ClassModel::where('academic_year_id', $academicYear?->id)
            ->withCount('students')
            ->withCount(['attendances as hadir_count' => fn ($q) => $q->where('academic_year_id', $academicYear?->id)->where('status', 'hadir')])
            ->withCount(['attendances as total_count' => fn ($q) => $q->where('academic_year_id', $academicYear?->id)])
            ->orderBy('nama_kelas')
            ->get()
            ->map(function ($class) {
                $class->persentase = $class->total_count > 0
                    ? round($class->hadir_count / $class->total_count * 100, 1)
                    : 0;

                return $class;
            });

        return view('dashboard', [
            'mode' => 'kepala_sekolah',
            'academicYear' => $academicYear,
            'classes' => $classes,
        ]);
    }

    private function indonesianDay(Carbon $date): string
    {
        return [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ][$date->format('l')];
    }
}