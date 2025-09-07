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
        Schema::table('pesertas', function (Blueprint $table) {
            // Mengganti nama kolom
            $table->renameColumn('asal_sekolah_kampus', 'institusi_asal');
        });
    }

    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            // Mengembalikan nama jika di-rollback
            $table->renameColumn('institusi_asal', 'asal_sekolah_kampus');
        });
    }
};
