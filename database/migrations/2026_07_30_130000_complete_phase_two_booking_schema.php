<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->string('location')->nullable()->after('price_per_hour');
            $table->text('description')->nullable()->after('location');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->date('booking_date')->nullable()->after('schedule_id');
            $table->unique(['schedule_id', 'booking_date'], 'bookings_schedule_date_unique');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unique('booking_id', 'payments_booking_unique');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique('payments_booking_unique');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique('bookings_schedule_date_unique');
            $table->dropColumn('booking_date');
        });

        Schema::table('fields', function (Blueprint $table) {
            $table->dropColumn(['location', 'description']);
        });
    }
};
