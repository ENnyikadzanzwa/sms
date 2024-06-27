<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'description', 'amount', 'date', 'transaction_id'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
