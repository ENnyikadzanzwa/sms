<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeClass extends Model
{
    protected $fillable = [
        'name', 'grade_id'
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
    // GradeClass.php
    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'grade_class_staff');
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'grade_class_student');
    }



}
