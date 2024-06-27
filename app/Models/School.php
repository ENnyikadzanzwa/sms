<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'province', 'district', 'contact', 'address', 'type'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function communications()
    {
        return $this->hasMany(Communication::class);
    }

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    public function schoolYears()
    {
        return $this->hasMany(SchoolYear::class);
    }
   

    public function expenditures()
    {
        return $this->hasMany(Expenditure::class);
    }
}
