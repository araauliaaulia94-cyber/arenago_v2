<?php

namespace App\Http\Controllers;

use App\Models\PhotoOfField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoOfFieldController extends Controller
{
    /**
     * Display a listing of field photos.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for adding a new photo.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created photo.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified photo.
     */
    public function show(PhotoOfField $photoOfField)
    {
        //
    }

    /**
     * Show the form for editing the specified photo.
     */
    public function edit(PhotoOfField $photoOfField)
    {
        //
    }

    /** Replace one gallery photo without changing the other photos. */
    public function update(Request $request, PhotoOfField $photoOfField)
    {
        $field = $photoOfField->field;
        $owner = $request->user()->owner;

        if (!$owner || $field->owner_id !== $owner->id) {
            abort(403);
        }

        $validated = $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $newPath = $validated['photo']->store('field_photos', 'public');
        $oldPath = $photoOfField->photo_path;

        $photoOfField->update(['photo_path' => $newPath]);
        Storage::disk('public')->delete($oldPath);

        return back()->with('status', 'Foto galeri berhasil diganti.');
    }

    public function destroy(PhotoOfField $photoOfField)
    {
        $field = $photoOfField->field;
        $owner = request()->user()->owner;

        if (!$owner || $field->owner_id !== $owner->id) {
            abort(403);
        }

        Storage::disk('public')->delete($photoOfField->photo_path);
        $photoOfField->delete();

        return back()->with('status', 'Foto galeri berhasil dihapus.');
    }
}
