<?php

namespace Tests\Feature;

use App\Models\ClassModel;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_teacher_create_form(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('teachers.create'));

        $response->assertOk();
        $response->assertSee('Tambah Guru');
    }

    public function test_admin_can_create_teacher_and_assign_classes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $class = ClassModel::create(['nama_kelas' => 'X RPL 1']);

        $response = $this->actingAs($admin)->post(route('teachers.store'), [
            'nama' => 'Siti Nurhayati',
            'nip' => '1987654321',
            'no_hp' => '081234567890',
            'email' => 'siti@smkwck.sch.id',
            'password' => 'guru12345',
            'class_ids' => [$class->id],
        ]);

        $response->assertRedirect(route('teachers.index'));
        $this->assertDatabaseHas('teachers', [
            'nip' => '1987654321',
            'nama' => 'Siti Nurhayati',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'siti@smkwck.sch.id',
            'role' => 'guru',
        ]);
        $this->assertDatabaseHas('classes', [
            'id' => $class->id,
            'teacher_id' => Teacher::first()->id,
        ]);

        $loginResponse = $this->post(route('login.submit'), [
            'email' => 'siti@smkwck.sch.id',
            'password' => 'guru12345',
        ]);

        $loginResponse->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs(User::where('email', 'siti@smkwck.sch.id')->first());
    }
}
