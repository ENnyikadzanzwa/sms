<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guardian extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'email',
        'phone_number',
        'address',
        'date_of_birth',
        'national_id',
        'job',
    ];

    
    // public function students()
    // {
    //     return $this->hasMany(Student::class, 'guardian_id');
    // }
}



