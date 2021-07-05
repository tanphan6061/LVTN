<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Resources\BrandR;
use App\Http\Resources\ProductDetailR;
use App\Http\Resources\ProductR;
use App\Http\Resources\SearchResultR;
use App\Http\Resources\SupplierR;
use App\Models\Product;
use App\Taka\Filters\ProductFilter;
use App\Taka\Paginate\Paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function React\Promise\all;
use function Symfony\Component\String\s;

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
        //DB::enableQueryLog();
        $builder = Product::filterQ();
        $builder = $builder->filter($filter);
        $brands = $builder->getElementRelation('brand');
        $suppliers = $builder->getElementRelation('supplier');
        $products = new Paginate($builder);
        $list_sort = [
            ['key' => 'default', 'value' => 'Bán chạy'],
            ['key' => 'new_products', 'value' => 'Hàng mới'],
            ['key' => 'low_price', 'value' => 'Giá thấp'],
            ['key' => 'high_price', 'value' => 'Giá cao'],
        ];
        //dd(DB::getQueryLog());
        $listDataToArray = (object)[
            'products' => $products, 'brands' => $brands,
            'suppliers' => $suppliers, 'sort_settings' => collect($list_sort)
        ];

        return $this->responded('Get list products successfully', new SearchResultR($listDataToArray));
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        return $this->responded("Get product successfully", new ProductDetailR($product));
    }
}
