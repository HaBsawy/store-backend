<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'name', 'description', 'stock', 'min_allowed_stock', 'buy_price',
        'sell_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'purchase_product');
    }

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_product');
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }
}
