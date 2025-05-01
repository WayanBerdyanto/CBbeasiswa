<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->unsignedBigInteger('id_pengajuan');
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->enum('status_verifikasi', ['belum_diverifikasi', 'valid', 'tidak_valid'])->default('belum_diverifikasi');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
}; 