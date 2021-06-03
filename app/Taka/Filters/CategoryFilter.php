<?php

namespace App\Taka\Filters;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Collection;

class CategoryFilter extends Filter
{
    public function supplier($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return $this->builder;
        }
//        $categories = $supplier->products->map(function ($product) {
//            return $product->category;
//        })->unique()->pluck('id');
//        $parentCategories = $categories->map(function ($idCategory) {
//            $category = Category::find($idCategory);
//            while ($id = $category->parent_category_id) {
//                $category = Category::find($id);
//            }
//            return $category;
//        })->unique();
//        $childCategories = $parentCategories->reduce(function ($acc, $item) {
//            $list = $this->getChilds($item, collect([]));
//            return collect($acc)->push($list);
//        }, collect([]))->collapse();
//        return $this->builder->whereIn('id', $categories);

        $categories = $supplier->products->map(function ($product) {
            return $product->category;
        })->unique();

        $listCategories = $categories->reduce(function ($acc, $item) {
            $list = $this->getParent($item, collect([]));
            return collect($acc)->push($list);
        }, collect([]))->collapse()->unique();

        return $this->builder->whereIn('id', $listCategories);
    }

    public function parent_id($id = null)
    {
        if (!$id || $id == "null") {
            return $this->builder->whereNull('parent_category_id');
        }

        return $this->builder->where('parent_category_id', $id);
    }

    public function level($type = "ancestors")
    {
        return $this->builder;
    }

    public function getParent($child, Collection $collection)
    {
        $collection->push($child->id);
        if ($parent = $child->parent_category)
            $this->getParent($parent, $collection);
        return $collection;
    }

    public function getChilds($parent, Collection $list)
    {
        $list->push($parent->id);
        foreach ($parent->childs as $child) {
            $this->getChilds($child, $list);
        }
        return $list;
    }
}
