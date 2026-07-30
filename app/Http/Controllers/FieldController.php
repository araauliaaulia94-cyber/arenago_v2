<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\PhotoOfField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{
    /**
     * Public catalog: list all active fields with search & filter.
     */
    public function index(Request $request)
    {
        $query = Field::with(['owner', 'photos', 'reviews'])->where('status', 'available');

        if ($request->filled('search')) {
            $query->where('field_name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kota')) {
            $query->where('location', $request->kota);
        }
        if ($request->filled('sport')) {
            $query->where('sport_category', $request->sport);
        }
        if ($request->filled('min_price')) {
            $query->where('price_per_hour', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_hour', '<=', $request->max_price);
        }

        $fields = $query->latest()->paginate(12)->withQueryString();

        // Get distinct values for filter dropdowns
        $cities = Field::where('status', 'available')->distinct()->pluck('location');
        $sports = Field::where('status', 'available')->distinct()->pluck('sport_category');

        return view('fields.index', compact('fields', 'cities', 'sports'));
    }

    /**
     * Public detail page for a single field.
     */
    public function show(Field $field)
    {
        $field->load([
            'owner',
            'photos',
            'schedules' => fn ($query) => $query
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
                ->orderBy('start_time'),
            'reviews.user',
        ]);

        $avgRating = $field->reviews->avg('rating');

        return view('fields.show', compact('field', 'avgRating'));
    }

    // ─── Owner Management Methods ───

    /**
     * Owner dashboard: list their own fields.
     */
    public function ownerIndex()
    {
        $owner = auth()->user()->owner;

        if (!$owner) {
            return redirect()->route('owner.register')->with('status', 'Silakan daftar sebagai pemilik lapangan terlebih dahulu.');
        }

        $fields = $owner->fields()->with('photos')->latest()->get();

        return view('owner.fields.index', compact('fields'));
    }

    /**
     * Show form for creating a new field.
     */
    public function create()
    {
        $owner = auth()->user()->owner;
        if (!$owner) {
            return redirect()->route('owner.register');
        }

        return view('owner.fields.create');
    }

    /**
     * Store a new field.
     */
    public function store(Request $request)
    {
        $owner = auth()->user()->owner;
        if (!$owner) {
            return redirect()->route('owner.register');
        }

        $validated = $request->validate([
            'field_name' => 'required|string|max:255',
            'sport_category' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,unavailable',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $field = Field::create([
            'owner_id' => $owner->id,
            'field_name' => $validated['field_name'],
            'sport_category' => $validated['sport_category'],
            'price_per_hour' => $validated['price_per_hour'],
            'location' => $validated['location'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('field_photos', 'public');
                PhotoOfField::create([
                    'field_id' => $field->id,
                    'photo_path' => $path,
                ]);
            }
        }

        return redirect()->route('owner.fields.index')->with('status', 'Lapangan berhasil ditambahkan!');
    }

    /**
     * Show form for editing a field.
     */
    public function edit(Field $field)
    {
        $owner = auth()->user()->owner;
        if (!$owner || $field->owner_id !== $owner->id) {
            abort(403);
        }

        $field->load('photos');

        return view('owner.fields.edit', compact('field'));
    }

    /**
     * Update a field.
     */
    public function update(Request $request, Field $field)
    {
        $owner = auth()->user()->owner;
        if (!$owner || $field->owner_id !== $owner->id) {
            abort(403);
        }

        $validated = $request->validate([
            'field_name' => 'required|string|max:255',
            'sport_category' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,unavailable',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $field->update($validated);

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('field_photos', 'public');
                PhotoOfField::create([
                    'field_id' => $field->id,
                    'photo_path' => $path,
                ]);
            }
        }

        return redirect()->route('owner.fields.index')->with('status', 'Lapangan berhasil diperbarui!');
    }

    /**
     * Delete a field.
     */
    public function destroy(Field $field)
    {
        $owner = auth()->user()->owner;
        if (!$owner || $field->owner_id !== $owner->id) {
            abort(403);
        }

        // Delete associated photos from storage
        foreach ($field->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        $field->delete();

        return redirect()->route('owner.fields.index')->with('status', 'Lapangan berhasil dihapus!');
    }
}
