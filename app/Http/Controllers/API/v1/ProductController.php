<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Resources\ProductR;
use App\Models\Product;
use App\Taka\Filters\ProductFilter;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param \ProductFilter $filter
     * @return \Illuminate\Http\Response
     */
    public function index(ProductFilter $filter)
    {
        $products = Product::filter($filter)->get();
        //dd($products);
        $data = [
            'products' => ProductR::collection($products),
            'count' => $products->count(),
        ];
        return $this->responded('Get list products successfully', $data);
    }



    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->responded("Get product successfully", new ProductR($product));
    }



}
