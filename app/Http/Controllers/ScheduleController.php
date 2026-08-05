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
        $this->authorize('manage', $field);

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
        $this->authorize('manage', $field);

        $validated = $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $overlap = $field->schedules()
            ->where('day', $validated['day'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('start_time', '<', $validated['start_time'])
                            ->where('end_time', '>', $validated['end_time']);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->withInput()->withErrors(['start_time' => 'Slot ini tumpang tindih dengan slot yang sudah ada pada hari ' . $validated['day'] . '.']);
        }

        $field->schedules()->create($validated);

        return redirect()->route('owner.schedules.index', $field)->with('status', 'Slot jadwal berhasil ditambahkan!');
    }

    /**
     * Delete a schedule slot.
     */
    public function destroy(Field $field, Schedule $schedule)
    {
        $this->authorize('manage', $schedule);

        if ($schedule->field_id !== $field->id) {
            abort(404);
        }

        $schedule->delete();

        return redirect()->route('owner.schedules.index', $field)->with('status', 'Slot jadwal berhasil dihapus!');
    }
}
