<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'item_name', 'category', 'stock_level', 'restock_level', 'location'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
