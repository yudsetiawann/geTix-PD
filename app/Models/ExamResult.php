<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = ['order_id', 'exam_attribute_id', 'value'];

    public function attribute()
    {
        return $this->belongsTo(ExamAttribute::class, 'exam_attribute_id');
    }
}
