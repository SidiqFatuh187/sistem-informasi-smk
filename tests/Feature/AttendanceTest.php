<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_save_attendance_for_their_schedule(): void
    {
        $user = User::factory()->create(['role' => 'guru']);
        $teacher = Teacher::create(['user_id' => $user->id, 'nip' => '19870001', 'nama' => 'Siti']);
        $year = AcademicYear::create(['tahun' => '2026/2027', 'semester' => 'Ganjil', 'is_active' => true]);
        $class = ClassModel::create(['nama_kelas' => 'X RPL 1', 'teacher_id' => $teacher->id, 'academic_year_id' => $year->id]);
        $firstStudent = Student::create(['nisn' => '1001', 'nama' => 'Andi', 'class_id' => $class->id, 'jenis_kelamin' => 'Laki-laki']);
        $secondStudent = Student::create(['nisn' => '1002', 'nama' => 'Bunga', 'class_id' => $class->id, 'jenis_kelamin' => 'Perempuan']);
        $schedule = Schedule::create(['academic_year_id' => $year->id, 'class_id' => $class->id, 'teacher_id' => $teacher->id, 'subject' => 'Matematika', 'day' => 'Kamis', 'start_time' => '07:00', 'end_time' => '08:30']);

        $response = $this->actingAs($user)->post(route('attendances.store'), [
            'schedule_id' => $schedule->id,
            'date' => '2026-09-03',
            'statuses' => [$firstStudent->id => 'hadir', $secondStudent->id => 'izin'],
            'notes' => 'Kehadiran pagi',
        ]);

        $response->assertRedirect(route('attendances.create', ['schedule_id' => $schedule->id, 'date' => '2026-09-03']));
        $this->assertDatabaseHas('attendances', ['student_id' => $firstStudent->id, 'schedule_id' => $schedule->id, 'status' => 'hadir']);
        $this->assertDatabaseHas('attendances', ['student_id' => $secondStudent->id, 'schedule_id' => $schedule->id, 'status' => 'izin']);
    }

    public function test_teacher_cannot_use_another_teachers_schedule(): void
    {
        $firstUser = User::factory()->create(['role' => 'guru']);
        $firstTeacher = Teacher::create(['user_id' => $firstUser->id, 'nip' => '19870002', 'nama' => 'Siti']);
        $secondUser = User::factory()->create(['role' => 'guru']);
        $secondTeacher = Teacher::create(['user_id' => $secondUser->id, 'nip' => '19870003', 'nama' => 'Budi']);
        $year = AcademicYear::create(['tahun' => '2026/2027', 'semester' => 'Ganjil', 'is_active' => true]);
        $class = ClassModel::create(['nama_kelas' => 'X TKJ 1', 'teacher_id' => $secondTeacher->id, 'academic_year_id' => $year->id]);
        $student = Student::create(['nisn' => '1003', 'nama' => 'Citra', 'class_id' => $class->id, 'jenis_kelamin' => 'Perempuan']);
        $schedule = Schedule::create(['academic_year_id' => $year->id, 'class_id' => $class->id, 'teacher_id' => $secondTeacher->id, 'subject' => 'Informatika', 'day' => 'Kamis', 'start_time' => '07:00', 'end_time' => '08:30']);

        $response = $this->actingAs($firstUser)->post(route('attendances.store'), [
            'schedule_id' => $schedule->id,
            'date' => '2026-09-03',
            'statuses' => [$student->id => 'hadir'],
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount('attendances', 0);
    }
}
