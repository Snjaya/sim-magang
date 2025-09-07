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
            // Mengubah kolom enum untuk menambahkan 'revisi'
            $table->enum('status', ['diberikan', 'dikerjakan', 'verifikasi', 'selesai', 'revisi'])
                ->default('diberikan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            // Mengembalikan definisi kolom enum ke kondisi semula jika di-rollback
            $table->enum('status', ['diberikan', 'dikerjakan', 'verifikasi', 'selesai'])
                ->default('diberikan')->change();
        });
    }
};
