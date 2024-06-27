<?php
// app/Models/Expenditure.php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    protected $fillable = [
        'amount', 'purpose', 'description', 'school_id'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
