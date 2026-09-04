<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('schedule_id')->nullable()->after('teacher_id')->constrained('schedules')->nullOnDelete();
            $table->foreignId('academic_year_id')->nullable()->after('schedule_id')->constrained('academic_years')->nullOnDelete();
            $table->unique(['schedule_id', 'student_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique(['schedule_id', 'student_id', 'date']);
            $table->dropForeign(['academic_year_id']);
            $table->dropForeign(['schedule_id']);
            $table->dropColumn(['academic_year_id', 'schedule_id']);
        });
    }
};
