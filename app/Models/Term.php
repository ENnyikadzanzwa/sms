<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'school_year_id','fee','currency'];

    public function gradeClasses()
    {
        return $this->hasMany(GradeClass::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
    public function studentTermFees()
    {
        return $this->hasMany(StudentTermFee::class);
    }
}

