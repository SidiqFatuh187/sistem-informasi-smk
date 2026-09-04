<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $teacher = $request->user()->teacher;
        $schedules = $this->availableSchedules($request, $teacher?->id);
        $timezone = config('app.timezone', 'Asia/Jakarta');
        $now = Carbon::now($timezone);
        $today = $now->toDateString();
        $todaySchedules = $schedules->filter(fn (Schedule $schedule) => $schedule->day === $this->indonesianDay($now));

        $todaySchedules->each(function (Schedule $schedule) use ($today, $now, $timezone): void {
            $schedule->load([
                'classRoom.students',
                'attendances' => fn ($query) => $query->whereDate('date', $today),
            ]);
            $schedule->attendance_count = $schedule->attendances->pluck('student_id')->unique()->count();
            $schedule->attendance_status = $this->attendanceStatus($schedule, $now, $timezone);
        });

        $nextSchedule = $schedules
            ->map(function (Schedule $schedule) use ($now, $timezone) {
                $schedule->next_start = $this->nextOccurrence($schedule, $now, $timezone);

                return $schedule;
            })
            ->filter(fn (Schedule $schedule) => $schedule->next_start->isFuture())
            ->sortBy('next_start')
            ->first();

        return view('attendances.index', [
            'schedules' => $schedules,
            'todaySchedules' => $todaySchedules,
            'nextSchedule' => $nextSchedule,
            'selectedSchedule' => $this->selectedSchedule($request, $schedules),
            'selectedDate' => $request->input('date', $today),
            'today' => $today,
            'now' => $now,
            'isAdmin' => $request->user()->role === 'admin',
        ]);
    }

    public function create(Request $request): View
    {
        $teacher = $request->user()->teacher;
        $schedules = $this->availableSchedules($request, $teacher?->id);
        $schedule = $this->selectedSchedule($request, $schedules);
        $date = $request->input('date', Carbon::now()->toDateString());
        $attendanceMap = $schedule
            ? Attendance::where('schedule_id', $schedule->id)->whereDate('date', $date)->pluck('status', 'student_id')
            : collect();

        return view('attendances.create', [
            'schedules' => $schedules,
            'schedule' => $schedule,
            'selectedDate' => $date,
            'today' => Carbon::now()->toDateString(),
            'attendanceMap' => $attendanceMap,
            'isAdmin' => $request->user()->role === 'admin',
            'availability' => $schedule ? $this->availability($schedule, $date) : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'schedule_id' => ['required', 'exists:schedules,id'],
            'date' => ['required', 'date_format:Y-m-d'],
            'statuses' => ['required', 'array', 'min:1'],
            'statuses.*' => [Rule::in(['hadir', 'sakit', 'izin', 'alpa'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $schedule = Schedule::with('classRoom')->findOrFail($validated['schedule_id']);
        $this->authorizeSchedule($request, $schedule);
        $availability = $this->availability($schedule, $validated['date']);

        if (!$availability['can_submit']) {
            return back()->withInput()->with('error', $availability['message']);
        }

        $students = $schedule->classRoom->students()->whereIn('id', array_keys($validated['statuses']))->get();

        if ($students->count() !== count($validated['statuses'])) {
            return back()->withInput()->with('error', 'Data siswa tidak sesuai dengan kelas pada jadwal ini.');
        }

        $teacherId = $schedule->teacher_id;
        $now = Carbon::now();

        DB::transaction(function () use ($students, $validated, $schedule, $teacherId, $now) {
            foreach ($students as $student) {
                Attendance::updateOrCreate(
                    [
                        'schedule_id' => $schedule->id,
                        'student_id' => $student->id,
                        'date' => $validated['date'],
                    ],
                    [
                        'academic_year_id' => $schedule->academic_year_id,
                        'class_id' => $schedule->class_id,
                        'teacher_id' => $teacherId,
                        'status' => $validated['statuses'][$student->id],
                        'notes' => $validated['notes'] ?? null,
                        'updated_at' => $now,
                    ]
                );
            }
        });

        return redirect()->route('attendances.create', ['schedule_id' => $schedule->id, 'date' => $validated['date']])
            ->with('success', 'Absensi berhasil disimpan untuk ' . $students->count() . ' siswa.');
    }

    private function availableSchedules(Request $request, ?int $teacherId)
    {
        return Schedule::with(['classRoom', 'teacher', 'academicYear'])
            ->when($request->user()->role !== 'admin', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId ?? -1);
            })
            ->orderByRaw("CASE day WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 ELSE 7 END")
            ->orderBy('start_time')
            ->get();
    }

    private function selectedSchedule(Request $request, $schedules): ?Schedule
    {
        $scheduleId = $request->input('schedule_id');

        return $scheduleId ? $schedules->firstWhere('id', (int) $scheduleId) : null;
    }

    private function authorizeSchedule(Request $request, Schedule $schedule): void
    {
        if ($request->user()->role !== 'admin' && $schedule->teacher_id !== $request->user()->teacher?->id) {
            abort(403, 'Jadwal ini bukan tanggung jawab Anda.');
        }
    }

    private function availability(Schedule $schedule, string $date): array
    {
        $timezone = config('app.timezone', 'Asia/Jakarta');
        $dateTime = Carbon::createFromFormat('Y-m-d', $date, $timezone);
        $dayNames = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        $scheduleDay = $dayNames[$dateTime->format('l')];
        $start = Carbon::parse($date . ' ' . $schedule->start_time, $timezone);
        $now = Carbon::now($timezone);

        if ($scheduleDay !== $schedule->day) {
            return ['state' => 'wrong_day', 'can_submit' => false, 'label' => 'Hari tidak sesuai', 'message' => 'Tanggal yang dipilih bukan hari jadwal ini.'];
        }

        if ($dateTime->isFuture()) {
            return ['state' => 'future', 'can_submit' => false, 'label' => 'Belum tersedia', 'message' => 'Absensi untuk tanggal yang akan datang belum dapat diisi.'];
        }

        if ($dateTime->isToday() && $now->lt($start)) {
            return ['state' => 'not_started', 'can_submit' => false, 'label' => 'Belum dimulai', 'message' => 'Absensi akan terbuka pada jam ' . $start->format('H:i') . ' WIB.'];
        }

        return ['state' => $dateTime->isToday() && $now->lte(Carbon::parse($date . ' ' . $schedule->end_time, $timezone)) ? 'active' : 'late', 'can_submit' => true, 'label' => $dateTime->isToday() && $now->lte(Carbon::parse($date . ' ' . $schedule->end_time, $timezone)) ? 'Sedang berlangsung' : 'Input terlambat', 'message' => ''];
    }

    private function indonesianDay(Carbon $date): string
    {
        return ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'][$date->format('l')];
    }

    private function nextOccurrence(Schedule $schedule, Carbon $now, string $timezone): Carbon
    {
        $candidate = $now->copy()->startOfDay();

        for ($dayOffset = 0; $dayOffset < 7; $dayOffset++) {
            $date = $candidate->copy()->addDays($dayOffset);

            if ($this->indonesianDay($date) === $schedule->day) {
                $start = Carbon::parse($date->toDateString() . ' ' . $schedule->start_time, $timezone);

                if ($start->isFuture()) {
                    return $start;
                }
            }
        }

        return $candidate->addWeek();
    }

    private function attendanceStatus(Schedule $schedule, Carbon $now, string $timezone): string
    {
        $totalStudents = $schedule->classRoom->students->count();
        $end = Carbon::parse($now->toDateString() . ' ' . $schedule->end_time, $timezone);
        $isLate = $now->greaterThan($end);

        if ($schedule->attendance_count === 0) {
            return $isLate ? 'Input terlambat' : 'Belum diabsen';
        }

        if ($schedule->attendance_count < $totalStudents) {
            return $isLate ? 'Input terlambat' : 'Belum lengkap';
        }

        return $schedule->attendances->max('updated_at')?->greaterThan($end) ? 'Input terlambat' : 'Sudah diabsen';
    }
}
