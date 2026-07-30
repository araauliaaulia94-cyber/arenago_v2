<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function create()
    {
        // Check if user is already an owner
        if (auth()->user()->owner) {
            return redirect()->route('dashboard')->with('status', 'Anda sudah terdaftar sebagai pemilik lapangan.');
        }

        return view('owner.register');
    }

    public function store(Request $request)
    {
        // Check if user is already an owner
        if (auth()->user()->owner) {
            return redirect()->route('dashboard')->with('status', 'Anda sudah terdaftar sebagai pemilik lapangan.');
        }

        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'foto_usaha' => 'nullable|image|max:2048', // 2MB max
        ]);

        $path = null;
        if ($request->hasFile('foto_usaha')) {
            $path = $request->file('foto_usaha')->store('owner_photos', 'public');
        }

        $owner = Owner::create([
            'user_id' => auth()->id(),
            'nama_usaha' => $validated['nama_usaha'],
            'kota' => $validated['kota'],
            'foto_usaha' => $path,
            'status_verifikasi' => 'diterima', // Auto-accept for development mode based on PRD
        ]);

        return redirect()->route('dashboard')->with('status', 'Pendaftaran pemilik lapangan berhasil!');
    }
}