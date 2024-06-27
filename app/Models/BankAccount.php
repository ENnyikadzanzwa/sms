<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'bank_name', 'account_number', 'account_type', 'currency_id', 'balance'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
