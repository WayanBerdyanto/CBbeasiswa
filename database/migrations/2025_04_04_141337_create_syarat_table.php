<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyaratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syarat', function (Blueprint $table) {
            $table->id('id_syarat');
            $table->unsignedBigInteger('id_beasiswa'); // Pastikan tipe datanya sama dengan primary key beasiswa
            $table->decimal('syarat_ipk', 3, 2);
            $table->text('syarat_dokumen');
            $table->timestamps();

            // Foreign key harus mengacu ke id_beasiswa, bukan id
            $table->foreign('id_beasiswa')->references('id_beasiswa')->on('beasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syarat');
    }
}
