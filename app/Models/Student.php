<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'nisn',
        'nama',
        'class_id',
        'jenis_kelamin',
    ];

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }
}
