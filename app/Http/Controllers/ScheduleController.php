<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Show schedules for a specific field (owner view).
     */
    public function index(Field $field)
    {
        $owner = auth()->user()->owner;
        if (!$owner || $field->owner_id !== $owner->id) {
            abort(403);
        }

        $schedules = $field->schedules()
            ->orderByRaw("CASE day
                WHEN 'Monday' THEN 1
                WHEN 'Tuesday' THEN 2
                WHEN 'Wednesday' THEN 3
                WHEN 'Thursday' THEN 4
                WHEN 'Friday' THEN 5
                WHEN 'Saturday' THEN 6
                WHEN 'Sunday' THEN 7
                ELSE 8
            END")
            ->orderBy('start_time')
            ->get();

        return view('owner.schedules.index', compact('field', 'schedules'));
    }

    /**
     * Store a new schedule slot.
     */
    public function store(Request $request, Field $field)
    {
        $owner = auth()->user()->owner;
        if (!$owner || $field->owner_id !== $owner->id) {
            abort(403);
        }

        $validated = $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $field->schedules()->create($validated);

        return redirect()->route('owner.schedules.index', $field)->with('status', 'Slot jadwal berhasil ditambahkan!');
    }

    /**
     * Delete a schedule slot.
     */
    public function destroy(Field $field, Schedule $schedule)
    {
        $owner = auth()->user()->owner;
        if (!$owner || $field->owner_id !== $owner->id) {
            abort(403);
        }

        if ($schedule->field_id !== $field->id) {
            abort(404);
        }

        $schedule->delete();

        return redirect()->route('owner.schedules.index', $field)->with('status', 'Slot jadwal berhasil dihapus!');
    }
}
