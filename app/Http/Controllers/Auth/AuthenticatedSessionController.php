<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Cek apakah user punya akses ke panel admin
        if ($user->canAccessPanel(filament()->getPanel('admin'))) {

            if ($user->isAdmin()) {
                // Arahkan admin ke dashboard admin
                return redirect()->intended(route('filament.admin.pages.dashboard'));
            }

            if ($user->isScanner()) {
                // Arahkan scanner langsung ke halaman scan
                return redirect()->intended(route('filament.admin.pages.scan-ticket'));
            }

            // Fallback (jika punya akses tapi role tidak dikenal, misal butuh peran lain)
            return redirect()->intended(route('filament.admin.pages.dashboard'));
        }

        // User biasa, arahkan ke dashboard user (bawaan Breeze)
        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
