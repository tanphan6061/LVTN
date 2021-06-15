<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Taka\Favourite\Favouritable;
use App\Taka\Review\Reviewable;
use App\Taka\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Filterable, Favouritable, Reviewable;

    protected $guarded = [];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(Product_image::class);
    }

    public function product_details()
    {
        return $this->hasMany(Product_detail::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getGrandTotalAttribute()
    {
        return $this->price * (100 - $this->discount) / 100;
    }

    public function getisAvailableAttribute()
    {
        return $this->status == 'available' && $this->amount > 0;
    }

    public function scopeGetElementRelation($query, $relation)
    {
        return $query->with($relation)->get()->map(function ($product) use ($relation) {
            return $product->$relation;
        })->unique()->sortBy('id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }
}
