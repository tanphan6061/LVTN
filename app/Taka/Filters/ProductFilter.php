<?php

namespace App\Taka\Filters;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class ProductFilter extends Filter
{


//    public function q($name)
//    {
//        return $this->builder->where('name', 'like', "%$name%");
//    }

    public function suppliers($list)
    {
        $ar_suppliers = explode(",", $list);
        $supplierIDs = Brand::getAvailable()->whereIn('id', $ar_suppliers)->pluck('id') ?? [];
        return $this->builder->whereIn('brand_id', $supplierIDs);
    }

    public function brands($list)
    {
        $ar_brands = explode(",", $list);
        /*$brand = Brand::where('slug', $slug)->first();
        $productIDs = ($brand) ? $brand->products->pluck('id') : [];*/
        $brandIDs = Brand::getAvailable()->whereIn('id', $ar_brands)->pluck('id') ?? [];
        return $this->builder->whereIn('brand_id', $brandIDs);
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

    public function stars($list)
    {
        $arr_star = explode(",", $list);
        return $this->builder
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->select([
                'products.*',
            ])
            ->groupByRaw('name')
            ->havingRaw('AVG(reviews.star) >= ?', [min($arr_star)]);
        //return $this->builder;
    }

    public function sortBy($type = "default")
    {
        switch ($type) {
            case "new_products":
                $builder = $this->builder->orderBy('products.updated_at', 'desc');
                break;
            case "low_price":
                $builder = $this->builder->orderBy('price');
                break;
            case "high_price":
                $builder = $this->builder->orderByDesc('price');
                break;
            default:
                $builder = $this->builder;
        }
        //dd($builder);
        return $builder;
    }
}
