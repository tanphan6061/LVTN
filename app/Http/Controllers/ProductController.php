<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Auth::user()->products()->paginate(6);
        return view('products.list',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $this->validate(
            $request,
            [
                'name' => 'required',
                // 'slug' => [
                //     'regex:/^[a-z0-9-]+$/',
                //     'unique' => Rule::unique('events')->where(function ($query) {
                //         return $query->where('organizer_id', Auth::user()->id);
                //     })
                // ],
                'price' => 'required|numeric|min:0',
                'amount' => 'required|numeric|min:0',
                'description' => 'required',
                // 'detail' => 'required',
                'discount' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
            ],
            [
                'name.required' => "Tên sản phẩm là bắt buộc",
                'amount.required' => "Số lượng sản phẩm là bắt buộc",
                'description.required' => "Mô tả là bắt buộc",
                'discount.required' => "Số tiền (%) giảm là bắt buộc",
                'category_id.required' => "Loại phẩm là bắt buộc",
                'brand_id.required' => "Nhãn hiệu là bắt buộc",
                'price.required' => 'Giá sản phẩm là bắt buộc',
                'price.numeric' => 'Giá sản phẩm phải là số',
                'price.min' => 'Giá sản phẩm tối thiểu 0 vnđ',
            ]
        );
        dd($data, Auth::user()->products);
        //   $event = Auth::user()->events()->create($data);
        // return redirect()->route('events.show', $event)->with('success', 'Event successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
