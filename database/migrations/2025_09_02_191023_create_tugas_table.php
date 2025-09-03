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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembimbing_id')->constrained('users');
            $table->foreignId('peserta_id')->constrained('users');
            $table->string('judul');
            $table->text('deskripsi');
            $table->enum('jenis', ['dokumen/proyek', 'lapangan_teknis']);
            $table->string('file_path')->nullable(); // Untuk upload file
            $table->text('laporan_deskripsi')->nullable(); // Untuk laporan lapangan
            $table->string('foto_path')->nullable(); // Untuk foto laporan lapangan
            $table->enum('status', ['diberikan', 'dikerjakan', 'verifikasi', 'selesai'])->default('diberikan');
            $table->date('tanggal_diberikan');
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
