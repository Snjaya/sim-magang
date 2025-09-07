<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('task_user', function (Blueprint $table) {
            // Mengubah nama kolom dari tugas_id menjadi task_id
            $table->renameColumn('tugas_id', 'task_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_user', function (Blueprint $table) {
            // Mengembalikan nama kolom jika migrasi di-rollback
            $table->renameColumn('task_id', 'tugas_id');
        });
    }
};
