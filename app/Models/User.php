<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'school_id', 'name', 'contact', 'email', 'username', 'password', 'role', 'address_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function communicationsSent()
    {
        return $this->hasMany(Communication::class, 'sender_id');
    }

    public function communicationsReceived()
    {
        return $this->hasMany(Communication::class, 'receiver_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'assigned_to');
    }
}
