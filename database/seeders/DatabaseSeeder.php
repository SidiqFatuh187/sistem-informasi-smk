<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@smkwck.sch.id'],
            [
                'name' => 'Admin SMK Wira Cipta Karya',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $guru = User::firstOrCreate(
            ['email' => 'guru@smkwck.sch.id'],
            [
                'name' => 'Guru Wali Kelas',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
            ]
        );

        $kepalaSekolah = User::firstOrCreate(
            ['email' => 'kepala@smkwck.sch.id'],
            [
                'name' => 'Kepala Sekolah',
                'password' => Hash::make('kepala123'),
                'role' => 'kepala_sekolah',
            ]
        );

        $teacher = Teacher::firstOrCreate(
            ['nip' => '1987654321'],
            [
                'user_id' => $guru->id,
                'nama' => 'Siti Nurhayati',
                'no_hp' => '081234567890',
            ]
        );

        AcademicYear::firstOrCreate(
            ['tahun' => '2025/2026', 'semester' => 'Ganjil'],
            ['is_active' => true]
        );

        $kelasX = ClassModel::firstOrCreate(
            ['nama_kelas' => 'XII RPL 1'],
            ['teacher_id' => $teacher->id]
        );

        $kelasXI = ClassModel::firstOrCreate(
            ['nama_kelas' => 'XI TKJ 1'],
            ['teacher_id' => $teacher->id]
        );

        $studentData = [
            ['nisn' => '2025001', 'nama' => 'Andi Pratama', 'class_id' => $kelasX->id, 'jenis_kelamin' => 'Laki-laki'],
            ['nisn' => '2025002', 'nama' => 'Bunga Lestari', 'class_id' => $kelasX->id, 'jenis_kelamin' => 'Perempuan'],
            ['nisn' => '2025003', 'nama' => 'Candra Wijaya', 'class_id' => $kelasXI->id, 'jenis_kelamin' => 'Laki-laki'],
            ['nisn' => '2025004', 'nama' => 'Dewi Sartika', 'class_id' => $kelasXI->id, 'jenis_kelamin' => 'Perempuan'],
        ];

        foreach ($studentData as $student) {
            Student::firstOrCreate(
                ['nisn' => $student['nisn']],
                $student
            );
        }

        return;
    }
}
