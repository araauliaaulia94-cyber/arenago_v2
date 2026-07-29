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
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            // Related booking
            $table->foreignId('booking_id')
                ->constrained()
                ->cascadeOnDelete();

            // Payment details
            $table->decimal('amount', 10, 2);

            $table->enum('payment_method', [
                'bank_transfer',
                'qris',
                'e_wallet'
            ]);

            $table->string('payment_proof')->nullable();

            $table->enum('status', [
                'pending',
                'successful',
                'failed',
                'refunded'
            ])->default('pending');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};