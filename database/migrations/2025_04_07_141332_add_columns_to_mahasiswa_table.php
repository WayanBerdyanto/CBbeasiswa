<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('fakultas', 35)->after('jurusan');
            $table->string('no_hp', 15)->nullable()->after('gender');
            $table->text('alamat')->nullable()->after('no_hp');
            $table->decimal('ipk_terakhir', 3, 2)->default(0.00)->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['fakultas', 'no_hp', 'alamat', 'ipk_terakhir']);
        });
    }
}; 