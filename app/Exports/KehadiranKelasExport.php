<?php

namespace App\Exports;

use App\Models\AcademicYear;
use App\Models\ClassModel;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KehadiranKelasExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function __construct(
        private ClassModel $class,
        private ?AcademicYear $academicYear,
        private ?string $subject = null,
    ) {}

    public function collection(): Enumerable
    {
        return $this->class->students()->orderBy('nama')->get()->map(function ($student) {
            $query = $student->attendances()->where('academic_year_id', $this->academicYear?->id);

            if ($this->subject) {
                $query->whereHas('schedule', fn ($q) => $q->where('subject', $this->subject));
            }

            $rows = $query->get();
            $total = $rows->count();
            $hadir = $rows->where('status', 'hadir')->count();

            return [
                $student->nisn,
                $student->nama,
                $hadir,
                $rows->where('status', 'sakit')->count(),
                $rows->where('status', 'izin')->count(),
                $rows->where('status', 'alpa')->count(),
                $total,
                $total > 0 ? round($hadir / $total * 100, 1) . '%' : '0%',
            ];
        });
    }

    public function headings(): array
    {
        return ['NISN', 'Nama', 'Hadir', 'Sakit', 'Izin', 'Alpa', 'Total Pertemuan', '% Kehadiran'];
    }

    public function title(): string
    {
        return substr($this->class->nama_kelas, 0, 31);
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}