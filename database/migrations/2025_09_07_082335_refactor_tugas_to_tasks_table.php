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
        // Ganti nama tabel utama
        Schema::rename('tugas', 'tasks');

        // Ganti nama tabel penghubung (pivot)
        Schema::rename('tugas_user', 'task_user');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan nama jika migrasi di-rollback
        Schema::rename('tasks', 'tugas');
        Schema::rename('task_user', 'tugas_user');
    }
};
