<?php

namespace App\Livewire\Coach;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class AthleteList extends Component
{
    use WithPagination;

    // Fitur Search
    public $search = '';

    // Reset pagination saat search berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function getAthletesProperty()
    {
        $coach = Auth::user();

        // Ambil ID unit yang dilatih pelatih ini
        $unitIds = $coach->coachedUnits->pluck('id')->toArray();

        return User::query()
            ->where('role', 'user')
            ->where('verification_status', 'approved') // HANYA YANG SUDAH DI-ACC
            ->whereIn('unit_id', $unitIds) // HANYA DARI UNIT BINAAN
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->with(['unit', 'level']) // Eager load agar performa cepat
            ->orderBy('name', 'asc')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.coach.athlete-list', [
            'athletes' => $this->athletes
        ]);
    }
}
