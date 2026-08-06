<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\SparringPost;
use Illuminate\Http\Request;

class SparringPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SparringPost::with(['user', 'field', 'invites']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('team_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kota')) {
            $query->where('location', $request->kota);
        }

        if ($request->filled('sport')) {
            $query->where('sport_category', $request->sport);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('event_date', $request->tanggal);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            // Default: display active posts (open & matched)
            $query->whereIn('status', ['open', 'matched']);
        }

        $posts = $query->orderBy('event_date', 'asc')->paginate(12)->withQueryString();

        $cities = SparringPost::distinct()->pluck('location')->filter();
        $sports = SparringPost::distinct()->pluck('sport_category')->filter();

        return view('sparring.index', compact('posts', 'cities', 'sports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fields = Field::where('status', 'available')->orderBy('field_name')->get();

        return view('sparring.create', compact('fields'));
    }

    /**
     * Store a newly created sparring post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sport_category' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'team_name' => 'required|string|max:255',
            'field_id' => 'nullable|exists:fields,id',
            'cost' => 'nullable|string|max:255',
            'contact' => 'required|string|max:255',
        ]);

        $sparringPost = SparringPost::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'sport_category' => $validated['sport_category'],
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'team_name' => $validated['team_name'],
            'field_id' => $validated['field_id'] ?? null,
            'cost' => $validated['cost'] ?? null,
            'contact' => $validated['contact'],
            'status' => 'open',
        ]);

        return redirect()->route('sparring.index')->with('status', 'Jadwal sparring berhasil dipublikasikan!');
    }

    /**
     * Display the specified sparring post.
     */
    public function show(SparringPost $sparringPost)
    {
        $sparringPost->load(['user', 'field', 'invites.sender']);

        return view('sparring.show', compact('sparringPost'));
    }

    /**
     * Show the form for editing the specified sparring post.
     */
    public function edit(SparringPost $sparringPost)
    {
        //
    }

    /**
     * Update the specified sparring post.
     */
    public function update(Request $request, SparringPost $sparringPost)
    {
        //
    }

    /**
     * Remove the specified sparring post.
     */
    public function destroy(SparringPost $sparringPost)
    {
        //
    }
}