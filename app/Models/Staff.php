<?php

// app/Models/Staff.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'national_id',
        'address',
        'phone_number',
        'date_of_birth',
        'highest_education_level'
    ];
    // Staff.php
    public function gradeClasses()
    {
        return $this->belongsToMany(GradeClass::class, 'grade_class_staff');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

}
