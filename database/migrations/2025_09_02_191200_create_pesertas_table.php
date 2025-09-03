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
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users, jika user dihapus, profil ini juga ikut terhapus
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nim_nisn')->unique();
            $table->string('jurusan');
            $table->string('asal_sekolah_kampus');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
