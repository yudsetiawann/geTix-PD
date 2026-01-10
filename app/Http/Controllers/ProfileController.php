<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\OrganizationPosition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        // Eager load relasi 'coaches' (Pastikan relasi ini ada di Model Unit)
        // agar kita bisa cek di view siapa pelatihnya
        $units = Unit::with('coaches')->orderBy('name', 'asc')->get();

        // [BARU] Ambil data jabatan dinamis
        $positions = OrganizationPosition::active()->get();

        // $positions = OrganizationPosition::where('is_active', true)
        //     ->orderBy('order_level', 'asc')
        //     ->get();

        return view('profile.edit', [
            'user' => $request->user(),
            'units' => $units,
            'positions' => $positions,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Mapping Data Dasar
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->nik = $validated['nik'];
        $user->phone_number = $validated['phone'];
        $user->job = $validated['job'];
        $user->address = $validated['address'];
        $user->place_of_birth = $validated['place_of_birth'];
        $user->date_of_birth = $validated['date_of_birth'];
        $user->gender = $validated['gender'];
        $user->join_year = $validated['join_year'];
        $user->level_id = $validated['level_id'];

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // --- SKENARIO ATLET ---
        if ($user->role === 'user') {
            $newUnitId = $validated['unit_latihan_id'] ?? null;

            if ($user->unit_id != $newUnitId) {
                $user->unit_id = $newUnitId;
                $user->verification_status = 'pending';
            } elseif (in_array($user->verification_status, ['incomplete', 'rejected'])) {
                $user->verification_status = 'pending';
            }

            // Atlet tidak punya jabatan organisasi, pastikan null
            $user->organization_position_id = null;
            $user->rejection_note = null;
        }

        // --- SKENARIO COACH ---
        if ($user->isCoach()) {
            // 1. Sync Unit Binaan (Many-to-Many)
            if (isset($validated['coached_units'])) {
                $user->coachedUnits()->sync($validated['coached_units']);
            }

            // 2. Simpan Jabatan Organisasi (TAMBAHAN BARU)
            // Menggunakan null coalescing operator (??) jika input kosong
            $user->organization_position_id = $validated['organization_position_id'] ?? null;

            // 3. Auto Approve Coach jika status incomplete
            if ($user->verification_status === 'incomplete') {
                $user->verification_status = 'approved';
            }
        }

        $user->save();

        // === LOGIKA BARU: UPLOAD FOTO PROFIL ===
        if ($request->hasFile('photo')) {
            $user->addMediaFromRequest('photo')
                ->toMediaCollection('profile_photo');
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
