<?php

namespace App\Taka\Filters;

use App\Models\Category;
use App\Models\Supplier;

class CategoryFilter extends Filter
{
    public function supplier($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return $this->builder;
        }

        $categories = $supplier->products->map(function ($product) {
            return $product->category;
        })->unique()->pluck('id');
//        $parentCategories = $categories->map(function ($category) {
//            while ($category->parent_category_id) {
//                $category = Category::find($category->parent_category_id);
//            }
//            return $category;
//        })->unique()->pluck('id');
        return $this->builder->whereIn('id', $categories);
    }

    public function parent_id($id = null)
    {
        if (!$id) {
            return $this->builder->whereNull('parent_category_id');
        }
        
        return $this->builder->where('parent_category_id', $id);
    }
}
