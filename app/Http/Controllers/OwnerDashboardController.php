<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OwnerDashboardController extends Controller
{
    /**
     * Dashboard pemilik: fokus pada manajemen venue (lapangan & slot jadwal),
     * dengan ringkasan/CTA ke halaman Pesanan Masuk, sesuai REQ-2.4.
     */
    public function __invoke(Request $request): View
    {
        $owner = $request->user()->owner;

        $fields = $owner->fields()->with('photos')->orderBy('created_at', 'desc')->get();

        $needsAction = Booking::whereHas('schedule.field', function ($query) use ($owner) {
            $query->where('owner_id', $owner->id);
        })->where('status', 'pending')->whereHas('payment')->count();

        return view('owner.dashboard', compact('fields', 'needsAction'));
    }
}