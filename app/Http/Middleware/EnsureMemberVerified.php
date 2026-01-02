<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureMemberVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Jika User tidak login, biarkan default auth middleware yang menangani
        if (! $user) {
            return $next($request);
        }

        // 2. Tentukan status verifikasi berdasarkan Role
        $isVerified = false;

        if ($user->role === 'user') {
            // Atlet: Harus approved
            $isVerified = $user->verification_status === 'approved';
        } elseif ($user->isCoach()) {
            // Pelatih: Harus sudah pilih Unit/Struktur (sesuai logic Anda)
            // Pastikan method/relasi ini ada di Model User
            $isVerified = $user->coachedUnits()->exists();
        } else {
            // Admin & Scanner: Bypass (Selalu verified)
            $isVerified = true;
        }

        // 3. Jika TIDAK Terverifikasi
        if (! $isVerified) {
            // Redirect ke Home dengan pesan peringatan
            return redirect()->route('home')->with('error', 'Akses terbatas. Lengkapi data diri pada profil dan tunggu konfirmasi dari pelatih.');
        }

        return $next($request);
    }
}
