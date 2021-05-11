<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discount_code()
    {
        return $this->belongsTo(Discount_code::class);
    }

    public function order_details()
    {
        return $this->hasMany(Order_detail::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Order_detail::class);
    }
}
