<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'name', 'category_id', 'location_id', 'stock_level', 'restock_level', 'supplier_id'
    ];

    public function category()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function location()
    {
        return $this->belongsTo(ItemLocation::class);
    }

    public function supplier()
    {
        return $this->belongsTo(ItemSupplier::class);
    }

     // Add a method to check if the item needs restocking
     public function needsRestock()
     {
         return $this->stock_level < $this->restock_level;
     }

    public function allocations()
    {
        return $this->hasMany(ItemAllocation::class);
    }

    public function returns()
    {
        return $this->hasMany(ItemReturn::class);
    }
}
