<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->foreignId('academic_year_id')
                ->nullable()
                ->after('teacher_id')
                ->constrained('academic_years')
                ->nullOnDelete();
        });

            $activeYearId = DB::table('academic_years')->where('is_active', true)->value('id');

            if ($activeYearId) {
                DB::table('classes')->whereNull('academic_year_id')->update(['academic_year_id' => $activeYearId]);
            }
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropColumn('academic_year_id');
        });
    }
};
