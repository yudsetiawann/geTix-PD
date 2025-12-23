<?php

namespace App\Models;

use App\Models\OrganizationMember;
use Illuminate\Database\Eloquent\Model;

class OrganizationPosition extends Model
{
    protected $guarded = [];

    public function members()
    {
        return $this->hasMany(OrganizationMember::class);
    }
}
