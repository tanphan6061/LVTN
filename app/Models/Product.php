<?php

namespace App\Models;

use App\Taka\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    use HasFactory, Filterable;

    protected $guarded = [];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(Sub_category::class);
    }

    public function category()
    {
        return $this->hasManyThrough(Category::class, Sub_category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(Product_image::class);
    }


}
