<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_beasiswa', function (Blueprint $table) {
            $table->id('id_jenis');
            $table->string('nama_jenis');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Tambahkan foreign key ke tabel beasiswa
        Schema::table('beasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jenis')->after('nama_beasiswa')->nullable();
            $table->foreign('id_jenis')->references('id_jenis')->on('jenis_beasiswa')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('beasiswa', function (Blueprint $table) {
            $table->dropForeign(['id_jenis']);
            $table->dropColumn('id_jenis');
        });
        Schema::dropIfExists('jenis_beasiswa');
    }
}; 