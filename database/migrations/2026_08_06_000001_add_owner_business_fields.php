<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Melengkapi data pemilik lapangan sesuai REQ-1.3 PRD:
     * Nama Usaha, Kota, Foto Usaha, Alamat Lengkap, Rekening Bank.
     *
     * Kolom ditambahkan nullable agar tidak memutus data owner yang sudah ada.
     */
    public function up(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->text('alamat_lengkap')->nullable()->after('kota');
            $table->string('rekening_bank')->nullable()->after('alamat_lengkap');
        });
    }

    public function down(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->dropColumn(['rekening_bank', 'alamat_lengkap']);
        });
    }
};
