<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamLevel extends Model
{
    protected $fillable = ['name'];

    public function attributes()
    {
        return $this->hasMany(ExamAttribute::class)->orderBy('order');
    }
}
