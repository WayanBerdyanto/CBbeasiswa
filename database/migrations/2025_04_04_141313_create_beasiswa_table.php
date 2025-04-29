<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('beasiswa', function (Blueprint $table) {
            $table->id('id_beasiswa');
            $table->string('nama_beasiswa');
            $table->string('jenis');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('beasiswa');
    }
};

