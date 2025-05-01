<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->decimal('ipk', 3, 2)->after('id_mahasiswa'); // IPK mahasiswa saat mengajukan
            $table->enum('status_dokumen', ['belum_lengkap', 'lengkap', 'ditolak'])->default('belum_lengkap')->after('status_pengajuan');
            $table->enum('status_seleksi', ['belum_diproses', 'lolos', 'tidak_lolos'])->default('belum_diproses')->after('status_dokumen');
            $table->text('catatan_seleksi')->nullable()->after('alasan_pengajuan');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn(['ipk', 'status_dokumen', 'status_seleksi', 'catatan_seleksi']);
        });
    }
}; 