<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicYearCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_classes_for_an_academic_year(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $academicYear = AcademicYear::create(['tahun' => '2026/2027', 'semester' => 'Ganjil', 'is_active' => true]);
        $teacher = Teacher::create(['user_id' => $admin->id, 'nip' => '19870001', 'nama' => 'Siti Nurhayati']);
        ClassModel::create(['nama_kelas' => 'X RPL 1', 'teacher_id' => $teacher->id, 'academic_year_id' => $academicYear->id]);

        $response = $this->actingAs($admin)->get(route('academic-years.show', $academicYear));

        $response->assertOk();
        $response->assertSee('X RPL 1');
        $response->assertSee('Siti Nurhayati');
        $response->assertSee('Daftar Kelas');
    }

    public function test_admin_can_create_active_academic_year_and_deactivate_previous_one(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $oldYear = AcademicYear::create(['tahun' => '2025/2026', 'semester' => 'Ganjil', 'is_active' => true]);

        $response = $this->actingAs($admin)->post(route('academic-years.store'), [
            'tahun' => '2026/2027',
            'semester' => 'Ganjil',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('academic-years.index'));
        $this->assertDatabaseHas('academic_years', ['tahun' => '2026/2027', 'is_active' => true]);
        $this->assertDatabaseHas('academic_years', ['id' => $oldYear->id, 'is_active' => false]);
    }

    public function test_active_academic_year_cannot_be_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $academicYear = AcademicYear::create(['tahun' => '2026/2027', 'semester' => 'Genap', 'is_active' => true]);

        $response = $this->actingAs($admin)->delete(route('academic-years.destroy', $academicYear));

        $response->assertRedirect(route('academic-years.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('academic_years', ['id' => $academicYear->id]);
    }

    public function test_admin_can_activate_another_academic_year(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $oldYear = AcademicYear::create(['tahun' => '2025/2026', 'semester' => 'Genap', 'is_active' => true]);
        $newYear = AcademicYear::create(['tahun' => '2026/2027', 'semester' => 'Ganjil', 'is_active' => false]);

        $response = $this->actingAs($admin)->post(route('academic-years.activate', $newYear));

        $response->assertRedirect(route('academic-years.index'));
        $this->assertDatabaseHas('academic_years', ['id' => $oldYear->id, 'is_active' => false]);
        $this->assertDatabaseHas('academic_years', ['id' => $newYear->id, 'is_active' => true]);
    }
}