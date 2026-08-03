<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Schedule;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * My Bookings page for the logged-in renter.
     */
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with(['schedule.field.owner', 'schedule.field.photos', 'payment'])
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show booking form for a specific schedule slot.
     */
    public function create(Schedule $schedule)
    {
        $schedule->load('field.owner');

        return view('bookings.create', compact('schedule'));
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        $schedule = Schedule::with('field')->findOrFail($validated['schedule_id']);

        if ($schedule->field->status !== 'available') {
            return back()->withInput()->withErrors(['schedule_id' => 'Lapangan sedang tidak tersedia.']);
        }

        $bookingDate = Carbon::parse($validated['booking_date']);
        if ($bookingDate->englishDayOfWeek !== $schedule->day) {
            return back()->withInput()->withErrors(['booking_date' => 'Tanggal yang dipilih tidak sesuai dengan hari operasional slot.']);
        }

        try {
            $booking = DB::transaction(function () use ($schedule, $bookingDate) {
                return Booking::create([
                    'user_id' => auth()->id(),
                    'schedule_id' => $schedule->id,
                    'booking_date' => $bookingDate->toDateString(),
                    'total_price' => $schedule->field->price_per_hour,
                    'status' => 'pending',
                ]);
            });
        } catch (QueryException $exception) {
            return back()->withInput()->withErrors(['booking_date' => 'Slot ini sudah dipesan pada tanggal tersebut.']);
        }

        // Send notification to field owner
        Notification::create([
            'user_id' => $schedule->field->owner->user_id,
            'title' => 'Pesanan Baru',
            'message' => 'Ada pesanan baru untuk lapangan ' . $schedule->field->field_name . ' oleh ' . auth()->user()->name,
            'type' => 'booking',
            'is_read' => false,
        ]);

        return redirect()->route('bookings.index')->with('status', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * Show booking detail.
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['schedule.field.owner', 'schedule.field.photos', 'payment']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Owner: view incoming bookings for their fields.
     */
    public function ownerBookings()
    {
        $owner = auth()->user()->owner;
        if (!$owner) {
            return redirect()->route('owner.register');
        }

        $bookings = Booking::whereHas('schedule.field', function ($q) use ($owner) {
            $q->where('owner_id', $owner->id);
        })->with(['user', 'schedule.field', 'payment'])->latest()->get();

        return view('owner.bookings.index', compact('bookings'));
    }

    /**
     * Owner: confirm a booking payment (mark as paid).
     */
    public function confirm(Booking $booking)
    {
        $owner = auth()->user()->owner;
        if (!$owner || $booking->schedule->field->owner_id !== $owner->id) {
            abort(403);
        }

        if (!$booking->payment || $booking->status !== 'pending') {
            return back()->withErrors(['booking' => 'Booking ini belum dapat dikonfirmasi.']);
        }

        DB::transaction(function () use ($booking) {
            $booking->payment->update([
                'status' => 'successful',
                'paid_at' => now(),
            ]);
            $booking->update(['status' => 'paid']);
        });

        // Notify the renter
        Notification::create([
            'user_id' => $booking->user_id,
            'title' => 'Pembayaran Dikonfirmasi',
            'message' => 'Pembayaran untuk lapangan ' . $booking->schedule->field->field_name . ' telah dikonfirmasi. Selamat berolahraga!',
            'type' => 'payment',
            'is_read' => false,
        ]);

        return redirect()->route('owner.bookings')->with('status', 'Booking berhasil dikonfirmasi!');
    }
}
