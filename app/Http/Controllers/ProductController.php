<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $products = Auth::user()->products()->filterQ()->orderBy('created_at', 'DESC')->paginate(12);
        if ($request->q) {
            $products->setPath('?q=' . $request->q);
        }
        return view('products.list', compact('products'));
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
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        if ($request->category_id) {
            $category = Category::find($request->category_id);
            if (!$category) {
                return redirect()->back()->withErrors(['category_id' => 'Loại sản phẩm không tồn tại'])->withInput();
            }

            $data['category_id'] = $request->category_id;
        } else {
            if (!$request->parent_category) {
                return redirect()->back()->withErrors(['parent_category' => 'Danh mục sản phẩm là bắt buộc'])->withInput();
            }

            $parent_category = Category::find($request->parent_category);
            if (!$parent_category) {
                return redirect()->back()->withErrors(['parent_category' => 'Doanh mục sản phẩm không tồn tại'])->withInput();
            }

            $data['category_id'] = $request->parent_category;
        }

        if ($data['amount'] < $data['max_buy']) {
            return redirect()->back()->withErrors(['max_buy' => 'Số lượng được mua tối đa không được vượt quá số lượng sản phẩm'])->withInput();
        }

        if (!$request->key || !$request->value)
            return redirect()->back()->withErrors(['key' => 'Sản phẩm cần ít nhất 1 chi tiết sản phẩm'])->withInput();
        if (count($request->key) !== count($request->value))
            return redirect()->back()->withErrors(['key' => 'Chi tiết sản phẩm không hợp lệ'])->withInput();

        // for ($i = 0; $i < count($request->key); $i++) {

        // }
        $checkKey = collect($request->key)->every(function ($key) {
            return $key !== null;
        });

        if (!$checkKey)
            return redirect()->back()->withErrors(['key' => 'Tất cả các thuộc tính không được để trống'])->withInput();

        $checkValue = collect($request->value)->every(function ($value) {
            return $value !== null;
        });
        if (!$checkValue)
            return redirect()->back()->withErrors(['value' => 'Tất cả các chi tiết không được để trống'])->withInput();


        $product = Auth::user()->products()->create($data);

        $product->slug =  Str::slug($data['name'], '-') . '-' . $product->id;
        $product->save();
        for ($i = 0; $i < count($request->key); $i++) {
            $product->product_details()->create(['key' => $request->key[$i], 'value' => $request->value[$i]]);
        }

        if ($request->images) {
            $dir = 'uploads/images/products';
            foreach ($request->images as $image) {
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path($dir), $imageName);
                $image = $dir . "/" . $imageName;
                $product->images()->create(['url' => $image]);
            }
        } else {
            $product->images()->create();
        }

        return redirect()->route('products.show', $product)->with('success', 'Product successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->numberOfReview = round($product->reviews->avg('star'), 1) ?? 0;
        return view('products.detail', compact('product'));
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
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.edit', compact('categories', 'brands', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if ($request->category_id) {
            $category = Category::find($request->category_id);
            if (!$category) {
                return redirect()->back()->withErrors(['category_id' => 'Loại sản phẩm không tồn tại'])->withInput();
            }

            $data['category_id'] = $request->category_id;
        } else {
            if (!$request->parent_category) {
                return redirect()->back()->withErrors(['parent_category' => 'Danh mục sản phẩm là bắt buộc'])->withInput();
            }

            $parent_category = Category::find($request->parent_category);
            if (!$parent_category) {
                return redirect()->back()->withErrors(['parent_category' => 'Doanh mục sản phẩm không tồn tại'])->withInput();
            }

            $data['category_id'] = $request->parent_category;
        }

        if ($data['amount'] < $data['max_buy']) {
            return redirect()->back()->withErrors(['max_buy' => 'Số lượng được mua tối đa không được vượt quá số lượng sản phẩm'])->withInput();
        }

        if (!$request->key || !$request->value)
            return redirect()->back()->withErrors(['key' => 'Sản phẩm cần ít nhất 1 chi tiết sản phẩm'])->withInput();
        if (count($request->key) !== count($request->value))
            return redirect()->back()->withErrors(['key' => 'Chi tiết sản phẩm không hợp lệ'])->withInput();

        $checkKey = collect($request->key)->every(function ($key) {
            return $key !== null;
        });

        if (!$checkKey)
            return redirect()->back()->withErrors(['key' => 'Tất cả các thuộc tính không được để trống'])->withInput();

        $checkValue = collect($request->value)->every(function ($value) {
            return $value !== null;
        });
        if (!$checkValue)
            return redirect()->back()->withErrors(['value' => 'Tất cả các chi tiết không được để trống'])->withInput();


        $product->update($data);
        $product->product_details()->delete();
        for ($i = 0; $i < count($request->key); $i++) {
            $product->product_details()->create(['key' => $request->key[$i], 'value' => $request->value[$i]]);
        }
        if ($request->remove_image) {
            foreach ($request->remove_image as $id) {
                $product->images()->where('id', $id)->delete();
            }
        }


        if ($request->images) {
            $dir = 'uploads/images/products';
            foreach ($request->images as $key => $image) {
                if (!in_array($key, array_filter($request->remove_uploads))) {
                    $imageName = time() . '.' . $image->extension();
                    $image->move(public_path($dir), $imageName);
                    $image = $dir . "/" . $imageName;
                    $product->images()->create(['url' => $image]);
                }
            }
        }

        return redirect()->route('products.show', $product)->with('success', 'Product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->update(['is_deleted' => 1]);
        return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
    }
}
