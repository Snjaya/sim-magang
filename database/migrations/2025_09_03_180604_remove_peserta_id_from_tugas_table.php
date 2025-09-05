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
        Schema::table('tugas', function (Blueprint $table) {
            // Hapus foreign key constraint dulu sebelum hapus kolomnya
            $table->dropForeign(['peserta_id']);
            $table->dropColumn('peserta_id');
        });
    }

    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            // Jika migrasi di-rollback, buat kembali kolomnya
            $table->foreignId('peserta_id')->constrained('users');
        });
    }
};
