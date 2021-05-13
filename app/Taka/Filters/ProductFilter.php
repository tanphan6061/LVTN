<?php
namespace App\Taka\Filters;

use App\Models\Brand;
use App\Models\Supplier;

class ProductFilter extends Filter
{
    public function supplier($slug)
    {
        $supplier = Supplier::where('slug', $slug)->first();
        $productIDs = ($supplier) ? $supplier->products->pluck('id') : [];
        return $this->builder->whereIn('id', $productIDs);
    }

    public function name($name)
    {
        return $this->builder->where('name', 'like', "%$name%");
    }

    public function brand($slug)
    {
        $brand = Brand::where('slug', $slug)->first();
        $productIDs = ($brand) ? $brand->products->pluck('id') : [];
        return $this->builder->whereIn('id', $productIDs);
    }

    public function price($range_string)
    {
        $range = explode(",", $range_string);
        $range[0] = isset($range[0]) ? intval($range[0]) : 0;
        $range[1] = isset($range[1]) ? intval($range[1]) : 0;

        if ($range[0] < 0) {
            $range[0] = 0;
        }

        if ($range[1] <= $range[0]) {
            $range[1] = 0;
        }


        $builder = $this->builder->where('price', '>=', $range[0]);
        if ($range[1] > 0) {
            $builder = $builder->where('price', '<=', $range[1]);
        }

        return $builder;
    }
}
