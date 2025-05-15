<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSemesterFieldsToPeriodeBeasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('periode_beasiswa', function (Blueprint $table) {
            $table->enum('tipe_semester', ['ganjil', 'genap', 'semua'])->default('semua')->after('nama_periode');
            $table->string('semester_syarat')->nullable()->after('tipe_semester');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('periode_beasiswa', function (Blueprint $table) {
            $table->dropColumn('tipe_semester');
            $table->dropColumn('semester_syarat');
        });
    }
}
