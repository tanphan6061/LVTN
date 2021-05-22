<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount_code extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function order_discount_codes()
    {
        return $this->hasMany(Order_Discount_code::class);
    }

    public function scopeAvailable($query)
    {
        return $query->whereDate('start_date', '<=', date('Y-m-d'))
            ->whereDate('end_date', '>=', date('Y-m-d'));

    }

    public static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }
}
