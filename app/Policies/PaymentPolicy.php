<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Renter may create payment for their own booking. Double-payment guard handled in controller.
     */
    public function create(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id;
    }
}
