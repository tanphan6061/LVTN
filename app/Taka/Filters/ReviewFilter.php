<?php

namespace App\Taka\Filters;

use App\Models\Brand;
use App\Models\Supplier;

class ReviewFilter extends Filter
{
    function product_id($id)
    {
        return $this->builder->where('product_id', $id)->get();

    }
}
