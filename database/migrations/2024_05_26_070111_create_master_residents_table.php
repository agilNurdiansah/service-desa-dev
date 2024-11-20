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
        Schema::create('master_residents', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk'); // Nomor KK
            $table->string('nik')->unique(); // Nomor Induk Kependudukan
            $table->string('status_pernikahan'); // Status Pernikahan
            $table->string('relationship_family'); // Hubungan Keluarga
            $table->string('kewarganegaraan'); // Kewarganegaraan
            $table->string('nama_ayah'); // Nama Ayah
            $table->string('nama_ibu'); // Nama Ibu
            $table->string('nama'); // Nama Lengkap
            $table->enum('jenis_kelamin', ['L', 'P']); // Jenis Kelamin
            $table->string('tempat_lahir'); // Tempat Lahir
            $table->string('pendidikan'); // Pendidikan Terakhir
            $table->string('jenis_pekerjaan'); // Jenis Pekerjaan
            $table->string('agama'); // Agama
            $table->date('tanggal_lahir'); // Tanggal Lahir
            $table->text('alamat'); // Alamat Lengkap
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_residents');
    }
};
