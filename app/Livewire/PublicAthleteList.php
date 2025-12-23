<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PublicAthleteList extends Component
{
    use WithPagination;

    // Properti untuk search binding
    public $search = '';

    // Reset pagination saat user mengetik search agar tidak error page
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Query data
        $athletes = User::query()
            ->with('unit') // Eager load relasi unit

            // 1. FILTER ROLE:
            // Sesuai struktur tabel Anda, kolom role default 'user'.
            // Jika role untuk atlet bernama 'user', gunakan 'user'.
            // Jika Anda pakai role bernama 'athlete' di database, ganti jadi 'athlete'.
            ->where('role', 'user')

            // 2. FILTER STATUS:
            // Sesuai struktur tabel, nama kolomnya 'verification_status', bukan 'status'.
            // Dan value untuk yang sudah ACC adalah 'approved'.
            ->where('verification_status', 'approved')

            ->where(function ($query) {
                // Logic pencarian: Cari berdasarkan Nama ATAU Nama Unit
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('unit', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('name', 'asc')
            ->paginate(12);

        return view('livewire.public-athlete-list', [
            'athletes' => $athletes
        ]);
    }
}
