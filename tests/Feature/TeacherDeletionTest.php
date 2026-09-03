<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_teacher_preserves_classes_students_and_attendance(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $teacherUser = User::factory()->create(['role' => 'guru']);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => '1987654321',
            'nama' => 'Siti Nurhayati',
        ]);
        $class = ClassModel::create([
            'nama_kelas' => 'X RPL 1',
            'teacher_id' => $teacher->id,
        ]);
        $student = Student::create([
            'nisn' => '1001',
            'nama' => 'Andi',
            'class_id' => $class->id,
            'jenis_kelamin' => 'Laki-laki',
        ]);
        $attendance = Attendance::create([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'teacher_id' => $teacher->id,
            'date' => '2026-09-03',
            'status' => 'hadir',
        ]);

        $response = $this->actingAs($admin)->delete(route('teachers.destroy', $teacher));

        $response->assertRedirect(route('teachers.index'));
        $this->assertDatabaseMissing('teachers', ['id' => $teacher->id]);
        $this->assertDatabaseMissing('users', ['id' => $teacherUser->id]);
        $this->assertDatabaseHas('classes', ['id' => $class->id, 'teacher_id' => null]);
        $this->assertDatabaseHas('students', ['id' => $student->id, 'class_id' => $class->id]);
        $this->assertDatabaseHas('attendances', ['id' => $attendance->id, 'teacher_id' => null]);
    }
}
