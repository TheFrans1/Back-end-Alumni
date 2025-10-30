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
    Schema::create('alumni', function (Blueprint $table) {
        $table->id();
        $table->string('nim')->unique(); // NIM unik
        $table->string('nama');
        $table->string('jurusan');
        $table->year('lulusan'); // Tahun Lulusan
        $table->enum('jenjang', ['D3', 'S1']);
        $table->enum('status_pekerjaan', [
            'Bekerja', 
            'Belum Bekerja', 
            'Lanjut Kuliah', 
            'Lainnya'
        ])->default('Belum Bekerja');

        $table->string('bekerja_di')->nullable(); // Boleh kosong
        $table->string('posisi_pekerjaan')->nullable(); // Boleh kosong
        $table->string('lanjut_kuliah_di')->nullable(); // Boleh kosong

        $table->string('nomor_hp')->nullable();
        $table->string('email')->unique()->nullable(); // Email unik tapi boleh kosong

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
