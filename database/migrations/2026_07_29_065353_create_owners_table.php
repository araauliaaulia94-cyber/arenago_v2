<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();

            // Relationship to User
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Owner data
            $table->string('nama_usaha');
            $table->string('kota');
            $table->string('foto_usaha')->nullable();

            $table->enum('status_verifikasi', [
                'pending',
                'diterima',
                'ditolak'
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};