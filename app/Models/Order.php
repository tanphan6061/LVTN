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

    public function history_orders()
    {
        return $this->hasMany(History_order::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, Order_detail::class);
    }

    public function shipping_address()
    {
        return $this->hasOne(Shipping_address::class);
    }

    public function order_discount_codes()
    {
        return $this->hasMany(Order_Discount_code::class);
    }

    public function currentStatus(){
        return $this->history_orders()->latest()->first()->status;
    }
}
