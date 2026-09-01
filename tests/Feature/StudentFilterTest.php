<?php

namespace Tests\Feature;

use App\Models\ClassModel;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_filter_students_by_class_and_gender(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@smkwck.sch.id',
            'role' => 'admin',
        ]);

        $classX = ClassModel::create([
            'nama_kelas' => 'X',
            'teacher_id' => null,
        ]);

        $classXI = ClassModel::create([
            'nama_kelas' => 'XI',
            'teacher_id' => null,
        ]);

        Student::create([
            'nisn' => '1001',
            'nama' => 'Andi',
            'class_id' => $classX->id,
            'jenis_kelamin' => 'Laki-laki',
        ]);

        Student::create([
            'nisn' => '1002',
            'nama' => 'Sari',
            'class_id' => $classX->id,
            'jenis_kelamin' => 'Perempuan',
        ]);

        Student::create([
            'nisn' => '1003',
            'nama' => 'Budi',
            'class_id' => $classXI->id,
            'jenis_kelamin' => 'Laki-laki',
        ]);

        $response = $this->actingAs($admin)
            ->get('/students?class_id=' . $classX->id . '&jenis_kelamin=Laki-laki');

        $response->assertOk();
        $response->assertSee('Andi');
        $response->assertDontSee('Sari');
        $response->assertDontSee('Budi');
    }
}
