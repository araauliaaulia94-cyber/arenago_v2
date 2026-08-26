<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Role-aware dashboard: ringkasan berbeda untuk penyewa dan pemilik lapangan.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $isOwner = $user->isOwner();

        $bookings = $user->bookings()->with('payment')->latest()->get();

        $totalBookings = $bookings->count();
        $needsPayment = $bookings->filter(fn ($booking) => $booking->status === 'pending' && !$booking->payment)->count();
        $paidBookings = $bookings->where('status', 'paid')->count();

        return view('dashboard', [
            'user' => $user,
            'isOwner' => $isOwner,
            'totalBookings' => $totalBookings,
            'needsPayment' => $needsPayment,
            'paidBookings' => $paidBookings,
        ]);
    }
}
