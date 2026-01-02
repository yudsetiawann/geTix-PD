<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Unit;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PublicAthleteList extends Component
{
    use WithPagination;

    public $search = '';
    public ?Unit $unit = null;

    // HAPUS "Unit" atau "?Unit" dari argumen di sini
    // Ubah menjadi variabel biasa ($unit = null)
    public function mount($unit = null)
    {
        // 1. Jika rute '/ranting/{unit}' diakses, Laravel/Livewire
        // secara otomatis mengubah parameter menjadi instance Model Unit.
        if ($unit instanceof Unit) {
            $this->unit = $unit;
        }
        // 2. Jaga-jaga jika yang masuk adalah ID (integer/string)
        elseif (is_numeric($unit)) {
            $this->unit = Unit::find($unit);
        }
        // 3. Jika rute '/semua' diakses, $unit akan null atau string kosong,
        // maka property $this->unit kita biarkan null.
        else {
            $this->unit = null;
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query()
            ->with(['unit', 'level'])
            ->where('role', 'user')
            ->where('verification_status', 'approved');

        // Pengecekan aman menggunakan optional chaining
        if ($this->unit && $this->unit->exists) {
            $query->where('unit_id', $this->unit->id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nia', 'like', '%' . $this->search . '%');
            });
        }

        $query->orderBy('name');

        return view('livewire.public-athlete-list', [
            'athletes' => $query->paginate(12),
            'pageTitle' => ($this->unit && $this->unit->exists)
                ? 'Anggota Ranting: ' . $this->unit->name
                : 'Daftar Seluruh Anggota'
        ]);
    }
}
