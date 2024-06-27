<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'email', // Add the email field here
        'address_id',
        'guardian_id',
        'school_id',
        'user_id',
    ];

    public function termFees()
    {
        return $this->hasMany(StudentTermFee::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function guardian()
    {
        return $this->belongsTo(User::class, 'guardian_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function gradeClasses()
    {
        return $this->belongsToMany(GradeClass::class, 'grade_class_student');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
