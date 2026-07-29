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
        Schema::create('activity_histories', function (Blueprint $table) {

            $table->id();

            // User who performed the activity
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Activity type
            $table->string('activity');

            // Related module
            $table->string('module');

            // Additional details
            $table->text('description')->nullable();

            // Related object ID
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_histories');
    }
};