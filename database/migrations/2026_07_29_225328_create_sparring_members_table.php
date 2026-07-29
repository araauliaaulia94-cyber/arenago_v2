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
        Schema::create('sparring_members', function (Blueprint $table) {

            $table->id();

            // Related sparring post
            $table->foreignId('sparring_post_id')
                ->constrained()
                ->cascadeOnDelete();

            // User who joins
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Join status
            $table->enum('status', [
                'pending',
                'accepted',
                'rejected',
                'left'
            ])->default('pending');

            // Join date
            $table->timestamp('joined_at')->nullable();

            $table->timestamps();

            // Prevent duplicate members
            $table->unique(['sparring_post_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sparring_members');
    }
};