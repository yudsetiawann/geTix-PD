<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Unit extends Model
{
    protected $fillable = ['name', 'type', 'address'];

    public function athletes()
    {
        return $this->hasMany(User::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Relasi ke pelatih
    // public function coaches()
    // {
    //     return $this->belongsToMany(User::class, 'coach_unit');
    // }
    public function coaches()
    {
        return $this->belongsToMany(User::class, 'coach_unit', 'unit_id', 'user_id');
    }
}
