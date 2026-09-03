<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForbiddenPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guru_sees_role_aware_forbidden_page_when_opening_admin_route(): void
    {
        $guru = User::factory()->create(['role' => 'guru']);

        $response = $this->actingAs($guru)->get(route('students.index'));

        $response->assertForbidden();
        $response->assertSee('Akses terbatas');
        $response->assertSee('Guru / Wali Kelas');
        $response->assertSee('Menginput absensi untuk kelas yang diampu.');
        $response->assertSee('Kembali ke halaman sebelumnya');
    }
}
