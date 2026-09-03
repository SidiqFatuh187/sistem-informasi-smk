<?php

namespace Tests\Feature;

use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_promote_students_without_changing_attendance_history(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $sourceClass = ClassModel::create(['nama_kelas' => 'X RPL 1']);
        $targetClass = ClassModel::create(['nama_kelas' => 'XI RPL 1']);
        $student = Student::create([
            'nisn' => '1002',
            'nama' => 'Bunga',
            'class_id' => $sourceClass->id,
            'jenis_kelamin' => 'Perempuan',
        ]);
        $attendance = Attendance::create([
            'student_id' => $student->id,
            'class_id' => $sourceClass->id,
            'teacher_id' => null,
            'date' => '2026-09-03',
            'status' => 'hadir',
        ]);

        $response = $this->actingAs($admin)->post(route('classes.promote-students'), [
            'source_class_id' => $sourceClass->id,
            'target_class_id' => $targetClass->id,
        ]);

        $response->assertRedirect(route('classes.index'));
        $this->assertDatabaseHas('students', ['id' => $student->id, 'class_id' => $targetClass->id]);
        $this->assertDatabaseHas('attendances', ['id' => $attendance->id, 'class_id' => $sourceClass->id]);
    }

    public function test_admin_can_promote_selected_students_and_keep_unselected_students_in_place(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $sourceClass = ClassModel::create(['nama_kelas' => 'X RPL 2']);
        $targetClass = ClassModel::create(['nama_kelas' => 'XI RPL 2']);
        $promotedStudent = Student::create(['nisn' => '1003', 'nama' => 'Citra', 'class_id' => $sourceClass->id, 'jenis_kelamin' => 'Perempuan']);
        $stayingStudent = Student::create(['nisn' => '1004', 'nama' => 'Doni', 'class_id' => $sourceClass->id, 'jenis_kelamin' => 'Laki-laki']);

        $response = $this->actingAs($admin)->post(route('classes.promote-selected-students', $sourceClass), [
            'target_class_id' => $targetClass->id,
            'student_ids' => [$promotedStudent->id],
        ]);

        $response->assertRedirect(route('classes.show', $sourceClass));
        $this->assertDatabaseHas('students', ['id' => $promotedStudent->id, 'class_id' => $targetClass->id]);
        $this->assertDatabaseHas('students', ['id' => $stayingStudent->id, 'class_id' => $sourceClass->id]);
    }

    public function test_class_with_students_cannot_be_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $class = ClassModel::create(['nama_kelas' => 'X RPL 1']);
        $student = Student::create([
            'nisn' => '1001',
            'nama' => 'Andi',
            'class_id' => $class->id,
            'jenis_kelamin' => 'Laki-laki',
        ]);

        $response = $this->actingAs($admin)->delete(route('classes.destroy', $class));

        $response->assertRedirect(route('classes.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('classes', ['id' => $class->id]);
        $this->assertDatabaseHas('students', ['id' => $student->id]);
    }

    public function test_empty_class_can_be_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $class = ClassModel::create(['nama_kelas' => 'X TKJ 1']);

        $response = $this->actingAs($admin)->delete(route('classes.destroy', $class));

        $response->assertRedirect(route('classes.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('classes', ['id' => $class->id]);
    }
}
