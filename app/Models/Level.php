<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['name', 'order', 'is_active'];

    // Scope untuk mengambil level aktif & terurut
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
