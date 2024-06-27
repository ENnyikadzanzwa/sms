<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'name', 'date', 'description'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}