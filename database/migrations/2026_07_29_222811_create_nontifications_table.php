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
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();

            // Recipient of the notification
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Notification title
            $table->string('title');

            // Notification message
            $table->text('message');

            // Notification type
            $table->enum('type', [
                'booking',
                'payment',
                'schedule',
                'review',
                'system'
            ]);

            // Read status
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};