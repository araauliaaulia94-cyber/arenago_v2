<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Renter may view/cancel their own booking.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id;
    }

    /**
     * Renter may cancel their own booking. State guard (pending) handled in controller.
     */
    public function cancel(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id;
    }

    /**
     * Owner may confirm/complete bookings for their own fields. State guards handled in controller.
     */
    public function manageAsOwner(User $user, Booking $booking): bool
    {
        return $user->owner !== null
            && $booking->schedule->field->owner_id === $user->owner->id;
    }
}
