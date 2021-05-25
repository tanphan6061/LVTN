<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Discount_code extends Model
{
    use HasFactory;

    protected $table = "order_discount_codes";
    protected $guarded = [];

    public function discount_code()
    {
        return $this->belongsTo(Discount_code::class);
    }
}
