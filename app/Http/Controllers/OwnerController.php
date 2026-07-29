<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $owners = Owner::with('user')->get();

        return response()->json([
            'data' => $owners,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_usaha' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'foto_usaha' => 'nullable|string|max:255',
            'status_verifikasi' => 'required|in:pending,diterima,ditolak',
        ]);

        $owner = Owner::create($validated);

        return response()->json([
            'message' => 'Owner created successfully.',
            'data' => $owner->load('user'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Owner $owner)
    {
        $owner->load('user');

        return response()->json([
            'data' => $owner,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Owner $owner)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'nama_usaha' => 'sometimes|required|string|max:255',
            'kota' => 'sometimes|required|string|max:255',
            'foto_usaha' => 'nullable|string|max:255',
            'status_verifikasi' => 'sometimes|required|in:pending,diterima,ditolak',
        ]);

        $owner->update($validated);

        return response()->json([
            'message' => 'Owner updated successfully.',
            'data' => $owner->load('user'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Owner $owner)
    {
        $owner->delete();

        return response()->json([
            'message' => 'Owner deleted successfully.',
        ]);
    }
}