<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttribute extends Model
{
    protected $fillable = ['exam_level_id', 'name', 'type', 'order'];

    public function level()
    {
        return $this->belongsTo(ExamLevel::class, 'exam_level_id');
    }
}
