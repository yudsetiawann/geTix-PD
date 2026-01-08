<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class UserStatusAlert extends Component
{
    public $user;
    public $status = 'ok';
    public $rejectionNote = '';
    public $unitName = '';

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = Auth::user();
        $this->determineStatus();
    }

    private function determineStatus()
    {
        if (!$this->user) {
            return;
        }

        $isCoach = $this->user->role === 'coach' || (method_exists($this->user, 'hasRole') && $this->user->hasRole('coach'));
        $isAthlete = in_array($this->user->role, ['athlete', 'user']) || (method_exists($this->user, 'hasRole') && $this->user->hasRole('athlete'));

        if ($isCoach) {
            // Cek apakah pelatih sudah punya unit binaan
            // Pastikan relasi 'coachedUnits' ada di Model User
            $hasCoachedUnits = $this->user->coachedUnits && $this->user->coachedUnits->isNotEmpty();

            if (!$hasCoachedUnits) {
                $this->status = 'incomplete_coach';
            }
        } elseif ($isAthlete) {
            if (is_null($this->user->unit_id)) {
                $this->status = 'incomplete_athlete';
            } elseif ($this->user->verification_status === 'rejected') {
                $this->status = 'rejected';
                $this->rejectionNote = $this->user->rejection_note;
            } elseif ($this->user->verification_status === 'pending') {
                $this->status = 'pending';
                $this->unitName = $this->user->unit->name ?? 'Unit Anda';
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Jika status OK, jangan render apa-apa
        if ($this->status === 'ok') {
            return '';
        }

        return view('components.user-status-alert');
    }
}
