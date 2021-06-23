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
            ->whereDate('end_date', '>=', date('Y-m-d'))
            ->where('amount', '>=', 1);

    }

    public function scopeGetGlobalCouponAvailable($query)
    {
        $user = auth('api')->user();
        if (!$user) {
            return null;
        }

        $cartItems = $user->carts;
        $categoryIDs = $cartItems->map(function ($item) {
            return $item->product->category->id;
        });

        $discounts = $query->where('is_global', 1)->get();

        return $discounts->filter(function ($discount) use ($categoryIDs) {
            $category = $discount->category;
            if ($categoryIDs->contains($category->id)) return true;
            $childIds = $category->childs->pluck('id');
            return $categoryIDs->contains(function ($categoryID) use ($childIds) {
                return $childIds->contains($categoryID);
            });
        });
    }

    public static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }
}
