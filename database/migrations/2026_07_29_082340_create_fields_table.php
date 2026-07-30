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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();

            // Relationship to Owner
            $table->foreignId('owner_id')
                  ->constrained('owners')
                  ->cascadeOnDelete();

            // Field data
            $table->string('field_name');
            $table->string('sport_category');
            $table->decimal('price_per_hour', 12, 2);
            $table->enum('status', [
                'available',
                'unavailable'
            ])->default('available');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};