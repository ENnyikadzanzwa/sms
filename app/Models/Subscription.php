<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'max_students', 'max_staff', 'max_guardians', 'fee'
    ];

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}

