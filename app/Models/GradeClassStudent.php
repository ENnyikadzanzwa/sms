<?php

// GradeClassStudent.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeClassStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_class_id',
        'student_id',
    ];

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
