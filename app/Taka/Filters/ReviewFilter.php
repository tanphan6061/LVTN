<?php

namespace App\Taka\Filters;

use App\Models\Product;
use App\Models\User;
use Doctrine\DBAL\Exception;

class ReviewFilter extends Filter
{
    function product_id($id)
    {
        $product = Product::find($id);
        $reviews = $product ? $product->reviews->pluck('id') : [];
        return $this->builder->whereIn('id', $reviews);
    }

    function user_id($id)
    {
//        if (!auth('api')->check()) {
//            return $this->builder;
//        }
//
//        $reviews = auth('api')->user()->reviews->pluck('id');
        $user = User::find($id);
        $reviews = $user ?  $user->reviews->pluck('id') : [];
        return $this->builder->whereIn('id', $reviews);
    }

    protected function response()
    {
        $states = $this->getFilters();
//        if (isset($states['product_id']) || auth('api')->check() == true) {
//            return $this->builder;
//        }
//        if (isset($states['product_id'])) {
//            return $this->builder;
//        }
//        return $this->builder->whereIn('id', []);
        return $this->builder;
    }
}
