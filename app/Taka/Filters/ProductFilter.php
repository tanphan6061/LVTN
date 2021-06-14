<?php

namespace App\Taka\Filters;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class ProductFilter extends Filter
{


//    public function q($name)
//    {
//        return $this->builder->where('name', 'like', "%$name%");
//    }

    public function suppliers($list = null)
    {
        if ($list == null) {
            return $this->builder;
        }

        $arraySuppliers = explode(",", $list);
        $supplierIDs = Brand::getAvailable()->whereIn('id', $arraySuppliers)->pluck('id') ?? [];
        return $this->builder->whereIn('products.supplier_id', $supplierIDs);
    }

    public function brands($list = null)
    {
        if ($list == null) {
            return $this->builder;
        }

        $arrayBrands = explode(",", $list);
        /*$brand = Brand::where('slug', $slug)->first();
        $productIDs = ($brand) ? $brand->products->pluck('id') : [];*/
        $brandIDs = Brand::getAvailable()->whereIn('id', $arrayBrands)->pluck('id') ?? [];
        return $this->builder->whereIn('products.brand_id', $brandIDs);
    }

    public function price($range_string = null)
    {
        if ($range_string == null) {
            return $this->builder;
        }

        $range = explode(",", $range_string);
        $range[0] = isset($range[0]) ? intval($range[0]) : 0;
        $range[1] = isset($range[1]) ? intval($range[1]) : 0;

        if ($range[0] < 0) {
            $range[0] = 0;
        }

        if ($range[1] <= $range[0]) {
            $range[1] = 0;
        }


        $builder = $this->builder->where('products.price', '>=', $range[0]);
        if ($range[1] > 0 && $range[0] != $range[1]) {
            $builder = $builder->where('products.price', '<=', $range[1]);
        }

        return $builder;
    }

    public function stars($list = null)
    {
        if ($list == null) {
            return $this->builder;
        }

        $arr_star = explode(",", $list);
        return $this->builder
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->select([
                'products.*',
            ])
            ->groupByRaw('name')
            ->havingRaw('AVG(reviews.star) >= ?', [min($arr_star)])
            ->havingRaw('AVG(reviews.star) <= ?', [max($arr_star)]);
        //return $this->builder;
    }

    public function sortBy($type = "default")
    {
        //DB::enableQueryLog();
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
                $builder = $this->builder
                    ->leftjoin('order_details', 'products.id', '=', 'order_details.product_id')
                    ->leftjoin('history_orders', function ($join) {
                        $join->on('order_details.order_id', '=', 'history_orders.order_id')
                            ->where('history_orders.status', 'delivered')
                            ->orWhereNull('history_orders.status');
                    })
                    ->select(
                        'products.*',
                        'history_orders.status',
                    //DB::raw('count(history_orders.status) as count')
                    )
                    ->groupByRaw('products.id')
                    ->orderByRaw('count(history_orders.status) DESC');
        }
        //dd($builder->get());
        //$builder->get();
        //dd(DB::getQueryLog());
        return $builder;
    }

    public function category($categoryID = null)
    {

        $category = Category::find($categoryID);
        if (!$category) {
            return $this->builder;
        }


        $listCategories = collect([]);
        $temp = collect([$category]);
        while ($temp->count() != 0) {
            $category = $temp->pop();
            $listCategories->push($category->id);
            $category->childs->each(function ($item) use ($temp) {
                $temp->push($item);
            });
        }

        return $this->builder->whereIn('products.category_id', $listCategories);
    }
}
