<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function discount_codes()
    {
        return $this->hasMany(Discount_code::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
