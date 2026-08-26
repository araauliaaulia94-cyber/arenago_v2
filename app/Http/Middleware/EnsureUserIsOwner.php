<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOwner
{
    /**
     * Memastikan pengguna terautentikasi memiliki profil pemilik lapangan.
     * Pengguna tanpa profil diarahkan ke halaman pendaftaran pemilik.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->isOwner()) {
            return redirect()->route('owner.register')
                ->with('status', 'Silakan daftar sebagai pemilik lapangan terlebih dahulu.');
        }

        return $next($request);
    }
}
