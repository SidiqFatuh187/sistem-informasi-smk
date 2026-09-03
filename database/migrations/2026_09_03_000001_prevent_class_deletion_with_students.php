<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->cascadeOnDelete();
        });
    }
};
