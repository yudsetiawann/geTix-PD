<?php

namespace App\Http\Requests;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // Biodata
            'nik' => ['required', 'numeric', 'digits:16', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['required', 'numeric'],
            'gender' => ['required', 'in:L,P'],
            'place_of_birth' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'string', 'max:500'],
            'job' => ['required', 'string', 'max:100'],

            'level_id' => ['required', 'exists:levels,id'],
            'join_year' => ['required', 'digits:4', 'integer', 'min:1955', 'max:' . date('Y')],

            'organization_position_id' => [
                'nullable',
                'exists:organization_positions,id'
            ],

            // 1. Jika User Biasa (Atlet)
            'unit_latihan_id' => [
                Rule::requiredIf(fn() => $this->user()->role === 'user'),
                'nullable',
                'exists:units,id'
            ],

            // 2. Jika Coach
            'coached_units' => [
                Rule::requiredIf(fn() => $this->user()->isCoach()),
                'array'
            ],

            'coached_units.*' => [
                'exists:units,id',
                // === PERBAIKAN DI SINI ===
                function ($attribute, $value, $fail) {
                    $currentUserId = $this->user()->id;

                    $existingCoach = DB::table('coach_unit')
                        ->join('users', 'coach_unit.user_id', '=', 'users.id')
                        // Tambahkan 'coach_unit.' agar tidak ambigu
                        ->where('coach_unit.unit_id', $value)
                        // Tambahkan 'coach_unit.' juga di sini agar aman
                        ->where('coach_unit.user_id', '!=', $currentUserId)
                        ->select('users.name')
                        ->first();

                    if ($existingCoach) {
                        $unitName = Unit::find($value)->name ?? 'Unit tersebut';
                        $fail("Ranting {$unitName} sudah dilatih oleh Coach {$existingCoach->name}.");
                    }
                },
            ],
        ];
    }
}
