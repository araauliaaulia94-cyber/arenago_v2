<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Show payment form for a booking.
     */
    public function create(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->payment) {
            return redirect()->route('bookings.show', $booking)->with('status', 'Pembayaran sudah pernah diunggah.');
        }

        $booking->load('schedule.field');

        return view('payments.create', compact('booking'));
    }

    /**
     * Store payment proof.
     */
    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:bank_transfer,qris,e_wallet',
            'payment_proof' => 'required|image|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        DB::transaction(function () use ($booking, $validated, $path) {
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'payment_method' => $validated['payment_method'],
                'payment_proof' => $path,
                'status' => 'pending',
            ]);
        });

        // Notify owner
        Notification::create([
            'user_id' => $booking->schedule->field->owner->user_id,
            'title' => 'Bukti Pembayaran Diunggah',
            'message' => auth()->user()->name . ' telah mengunggah bukti pembayaran untuk lapangan ' . $booking->schedule->field->field_name,
            'type' => 'payment',
            'is_read' => false,
        ]);

        return redirect()->route('bookings.show', $booking)->with('status', 'Bukti pembayaran berhasil diunggah! Menunggu konfirmasi pemilik.');
    }
}
