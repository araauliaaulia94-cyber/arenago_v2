<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kuota maksimal anggota pada sparring post sesuai fitur
     * "Maksimal Anggota": pembuat post menjadi anggota pertama, jumlah
     * anggota saat ini ditampilkan (contoh 1/10), dan saat kuota penuh
     * status post menjadi 'full' sehingga tidak menerima anggota baru.
     */
    public function up(): void
    {
        Schema::table('sparring_posts', function (Blueprint $table) {
            $table->unsignedInteger('max_players')->default(10)->after('status');
        });

        // Perluas konstrain status untuk mengizinkan nilai 'full' (penuh).
        DB::statement("ALTER TABLE sparring_posts DROP CONSTRAINT sparring_posts_status_check");
        DB::statement("ALTER TABLE sparring_posts ADD CONSTRAINT sparring_posts_status_check CHECK (status::text = ANY (ARRAY['open'::character varying, 'matched'::character varying, 'completed'::character varying, 'cancelled'::character varying, 'full'::character varying]::text[]))");
    }

    public function down(): void
    {
        Schema::table('sparring_posts', function (Blueprint $table) {
            $table->dropColumn('max_players');
        });

        // Kembalikan konstrain status tanpa nilai 'full'.
        DB::statement("ALTER TABLE sparring_posts DROP CONSTRAINT sparring_posts_status_check");
        DB::statement("ALTER TABLE sparring_posts ADD CONSTRAINT sparring_posts_status_check CHECK (status::text = ANY (ARRAY['open'::character varying, 'matched'::character varying, 'completed'::character varying, 'cancelled'::character varying]::text[]))");
    }
};
