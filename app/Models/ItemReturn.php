<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 
        'staff_id', 
        'quantity'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
