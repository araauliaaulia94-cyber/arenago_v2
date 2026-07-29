<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fields = Field::with('owner')->get();

        return response()->json([
            'data' => $fields,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'field_name' => 'required|string|max:255',
            'sport_category' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'status' => 'required|in:available,unavailable',
        ]);

        $field = Field::create($validated);

        return response()->json([
            'message' => 'Field created successfully.',
            'data' => $field->load('owner'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Field $field)
    {
        $field->load('owner');

        return response()->json([
            'data' => $field,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Field $field)
    {
        $validated = $request->validate([
            'owner_id' => 'sometimes|required|exists:owners,id',
            'field_name' => 'sometimes|required|string|max:255',
            'sport_category' => 'sometimes|required|string|max:255',
            'price_per_hour' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|in:available,unavailable',
        ]);

        $field->update($validated);

        return response()->json([
            'message' => 'Field updated successfully.',
            'data' => $field->load('owner'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        $field->delete();

        return response()->json([
            'message' => 'Field deleted successfully.',
        ]);
    }
}