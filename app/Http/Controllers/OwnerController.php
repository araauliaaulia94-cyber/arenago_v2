<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function create()
    {
        if (auth()->user()->owner) {
            return redirect()->route('owner.fields.index')->with('status', 'Anda sudah terdaftar sebagai pemilik lapangan.');
        }

        return view('owner.register');
    }

    public function store(Request $request)
    {
        if (auth()->user()->owner) {
            return redirect()->route('dashboard')->with('status', 'Anda sudah terdaftar sebagai pemilik lapangan.');
        }

        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string|max:500',
            'rekening_bank' => 'nullable|string|max:100',
            'foto_usaha' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('foto_usaha')) {
            $path = $request->file('foto_usaha')->store('owner_photos', 'public');
        }

        Owner::create([
            'user_id' => auth()->id(),
            'nama_usaha' => $validated['nama_usaha'],
            'kota' => $validated['kota'],
            'alamat_lengkap' => $validated['alamat_lengkap'],
            'rekening_bank' => $validated['rekening_bank'] ?? null,
            'foto_usaha' => $path,
            'status_verifikasi' => 'diterima',
        ]);

        return redirect()->route('owner.fields.index')->with('status', 'Pendaftaran pemilik lapangan berhasil! Selanjutnya tambahkan lapangan Anda.');
    }

    public function edit(Request $request)
    {
        $owner = $request->user()->owner;
        if (!$owner) {
            return redirect()->route('owner.register');
        }

        return view('owner.profile.edit', compact('owner'));
    }

    public function update(Request $request)
    {
        $owner = $request->user()->owner;
        if (!$owner) {
            return redirect()->route('owner.register');
        }

        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string|max:500',
            'rekening_bank' => 'nullable|string|max:100',
            'foto_usaha' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_usaha')) {
            if ($owner->foto_usaha && \Illuminate\Support\Facades\Storage::disk('public')->exists($owner->foto_usaha)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($owner->foto_usaha);
            }
            $validated['foto_usaha'] = $request->file('foto_usaha')->store('owner_photos', 'public');
        }

        $owner->update($validated);

        return redirect()->route('owner.profile.edit')->with('status', 'Profil usaha Anda berhasil diperbarui.');
    }
}
