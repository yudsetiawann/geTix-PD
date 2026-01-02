<?php

namespace App\Livewire;

use App\Models\Unit;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PublicUnitList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $units = Unit::query()
            ->withCount(['athletes' => function ($query) {
                // Hitung hanya atlet yang APPROVED
                $query->where('verification_status', 'approved');
            }])
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('address', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(12);

        return view('livewire.public-unit-list', [
            'units' => $units
        ]);
    }
}
