<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'year',
        'school_id'
    ];
    
    public function terms()
    {
        return $this->hasMany(Term::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
