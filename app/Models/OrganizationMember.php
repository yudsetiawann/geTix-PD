<?php

namespace App\Models;

use App\Models\OrganizationPosition;
use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(OrganizationPosition::class, 'organization_position_id');
    }
}
