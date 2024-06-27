<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'amount', 'source', 'description', 'school_id'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

