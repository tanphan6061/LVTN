<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Taka\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Filterable;

    protected $guarded = [];

//    public function sub_categories()
//    {
//        return $this->hasMany(Category::class, 'parent_category_id', 'id');
//    }

    public function parent_category()
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }


}
