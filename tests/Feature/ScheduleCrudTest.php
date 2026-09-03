<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_schedule_for_a_class_and_teacher(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $academicYear = AcademicYear::create(['tahun' => '2026/2027', 'semester' => 'Ganjil', 'is_active' => true]);
        $teacher = Teacher::create(['user_id' => $admin->id, 'nip' => '19870001', 'nama' => 'Siti Nurhayati']);
        $class = ClassModel::create(['nama_kelas' => 'X RPL 1', 'teacher_id' => $teacher->id, 'academic_year_id' => $academicYear->id]);

        $response = $this->actingAs($admin)->post(route('schedules.store'), [
            'academic_year_id' => $academicYear->id,
            'class_id' => $class->id,
            'teacher_id' => $teacher->id,
            'subject' => 'Matematika',
            'day' => 'Senin',
            'start_time' => '07:00',
            'end_time' => '08:30',
        ]);

        $response->assertRedirect(route('schedules.index'));
        $this->assertDatabaseHas('schedules', [
            'academic_year_id' => $academicYear->id,
            'class_id' => $class->id,
            'subject' => 'Matematika',
            'day' => 'Senin',
        ]);
    }

    public function test_schedule_cannot_use_class_from_another_academic_year(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $firstYear = AcademicYear::create(['tahun' => '2025/2026', 'semester' => 'Ganjil', 'is_active' => false]);
        $secondYear = AcademicYear::create(['tahun' => '2026/2027', 'semester' => 'Ganjil', 'is_active' => true]);
        $teacher = Teacher::create(['user_id' => $admin->id, 'nip' => '19870002', 'nama' => 'Budi']);
        $class = ClassModel::create(['nama_kelas' => 'X TKJ 1', 'academic_year_id' => $firstYear->id]);

        $response = $this->actingAs($admin)->from(route('schedules.create'))->post(route('schedules.store'), [
            'academic_year_id' => $secondYear->id,
            'class_id' => $class->id,
            'teacher_id' => $teacher->id,
            'subject' => 'Informatika',
            'day' => 'Selasa',
            'start_time' => '07:00',
            'end_time' => '08:30',
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseCount('schedules', 0);
    }
}
