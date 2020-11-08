<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id', 'name', 'mobile'
    ];

    protected $appends = ['total_sales', 'total_paid', 'debtor'];

    public function getTotalSalesAttribute()
    {
        $price = 0;
        foreach ($this->sales as $sale) {
            $price += $sale->price - $sale->discount;
        }
        return number_format($price, 2, '.', ',');
    }

    public function getTotalPaidAttribute()
    {
        $price = 0;
        foreach ($this->sales as $sale) {
            $price += $sale->paid;
        }
        foreach ($this->incomes as $income) {
            $price += $income->price;
        }
        return number_format($price, 2, '.', ',');
    }

    public function getDebtorAttribute()
    {
        $price = 0;
        foreach ($this->sales as $sale) {
            $price += $sale->price - $sale->discount - $sale->paid;
        }
        foreach ($this->incomes as $income) {
            $price -= $income->price;
        }
        return number_format($price, 2, '.', ',');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}
