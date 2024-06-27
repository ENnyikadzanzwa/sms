<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'name'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function gradeClasses()
    {
        return $this->hasMany(GradeClass::class);
    }

}
