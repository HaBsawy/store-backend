<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'user_id', 'name', 'mobile'
    ];

    protected $appends = ['total_purchases', 'total_paid', 'creditor'];

    public function getTotalPurchasesAttribute()
    {
        $price = 0;
        foreach ($this->purchases as $purchase) {
            $price += $purchase->price;
        }
        return number_format($price, 2, '.', ',');
    }

    public function getTotalPaidAttribute()
    {
        $price = 0;
        foreach ($this->purchases as $purchase) {
            $price += $purchase->paid;
        }
        foreach ($this->outcomes as $outcome) {
            $price += $outcome->price;
        }
        return number_format($price, 2, '.', ',');
    }

    public function getCreditorAttribute()
    {
        $price = 0;
        foreach ($this->purchases as $purchase) {
            $price += $purchase->price - $purchase->paid;
        }
        foreach ($this->outcomes as $outcome) {
            $price -= $outcome->price;
        }
        return number_format($price, 2, '.', ',');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function outcomes()
    {
        return $this->hasMany(Outcome::class);
    }
}
