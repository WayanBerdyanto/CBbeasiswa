<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('periode_beasiswa', function (Blueprint $table) {
            $table->id('id_periode');
            $table->unsignedBigInteger('id_beasiswa');
            $table->string('nama_periode');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('tidak_aktif');
            $table->integer('kuota')->default(0);
            $table->timestamps();

            $table->foreign('id_beasiswa')->references('id_beasiswa')->on('beasiswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_beasiswa');
    }
}; 