<?php

// GradeClassStaff.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeClassStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_class_id',
        'staff_id',
    ];

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}

