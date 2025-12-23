<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('layouts.app')]
class PublicOrganizationStructure extends Component
{
    public $showModal = false;
    public $selectedMemberId = null;

    // 1. Tambahkan properti search
    public $search = '';

    #[Computed]
    public function selectedMember()
    {
        if (!$this->selectedMemberId) {
            return null;
        }

        return User::with(['organizationPosition', 'level', 'unit', 'coachedUnits'])
            ->find($this->selectedMemberId);
    }

    public function openProfile($userId)
    {
        $this->selectedMemberId = $userId;
        $this->showModal = true;
    }

    public function closeProfile()
    {
        $this->showModal = false;
        $this->selectedMemberId = null;
    }

    public function render()
    {
        $query = User::query()
            ->whereNotNull('organization_position_id')
            ->where('role', 'coach')
            ->whereHas('organizationPosition', function ($q) {
                $q->where('is_active', true);
            })
            // Join diperlukan untuk sorting berdasarkan order_level jabatan
            ->join('organization_positions', 'users.organization_position_id', '=', 'organization_positions.id')
            ->select('users.*') // Pastikan hanya mengambil data user agar id tidak tertimpa
            ->with(['organizationPosition', 'unit']);

        // 2. Logika Pencarian
        if (!empty($this->search)) {
            $query->where(function ($q) {
                // Cari berdasarkan Nama User
                $q->where('users.name', 'like', '%' . $this->search . '%')
                    // ATAU Cari berdasarkan Nama Jabatan
                    ->orWhereHas('organizationPosition', function ($subQ) {
                        $subQ->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Urutkan hasil
        $members = $query->orderBy('organization_positions.order_level', 'asc')->get();

        return view('livewire.public-organization-structure', [
            'members' => $members
        ]);
    }
}
