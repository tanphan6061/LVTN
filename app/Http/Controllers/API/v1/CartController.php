<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\Api\CartCreateRequest;
use App\Http\Requests\Api\CartEditRequest;
use App\Http\Resources\CartSupplierItemR;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends ApiController
{
    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = $this->user->carts->map(function ($item) {
            if (!$product = $item->product) {
                $item->is_deleted = 1;
                $item->save();
                return null;
            }
            $product->quantity = $item->quantity;
            return $product;
        })->filter();

        $cart_items = $this->user->carts;
        $suppliers = $cart_items->map(function ($item) use ($products) {
            $supplier = $item->product->supplier;
            $supplier->items = $products->filter(function ($product) use ($supplier) {
                return $product->supplier->id == $supplier->id;
            });
            $supplier->discount_codes = $supplier->discount_codes()->available()
                ->where('is_global', 0)->get();
            return collect($supplier);
        })->unique();


        $data = [
            'suppliers' => CartSupplierItemR::collection($suppliers),
            'discount_codes' => [],
            'total_count' => $cart_items->sum('quantity')
        ];
        return $this->responded("Get cart successfully", $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartCreateRequest $request)
    {
        $validated = $request->validated();
        $cart_item = $this->user->carts;
        if (!$product = Product::find($validated['product_id'])) {
            $messages = [
                'product_id' => ['Sản phẩm không hợp lệ']
            ];
            return $this->respondedError('product_id invalid', $messages);
        }

        if (!$product->available) {
            $messages = [
                'product_id' => ['Sản phẩm không có sẵn']
            ];
            return $this->respondedError('product_id invalid', $messages);
        }

        if ($validated['quantity'] > $product->max_buy) {
            $messages = [
                'quantity' => ['Sản phẩm có số lượng mua tối đa là ' . $product->max_buy]
            ];
            return $this->respondedError('quantity invalid', $messages);
        }

        $item = $cart_item->where('product_id', $validated['product_id'])->first();
        if (!$item) {
            $data = $this->user->carts()->create($validated);
            return $this->responded("Create cart item successfully", $data);
        }

        if ($item->quantity + $validated['quantity'] > $product->max_buy) {
            $messages = [
                'quantity' => ['Sản phẩm có số lượng mua tối đa là ' . $product->max_buy]
            ];
            return $this->respondedError('quantity invalid', $messages);
        }

        if ($item->quantity + $validated['quantity'] > $product->amount) {
            $messages = [
                'quantity' => ['Số lượng mua lớn hơn số sản phẩm hiện có']
            ];
            return $this->respondedError('quantity invalid', $messages);
        }

        $item->quantity += $validated['quantity'];
        $item->save();
        return $this->responded("Update quality cart item successfully", $item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function update(CartEditRequest $request)
    {
        $user = $this->user;
        $validated = $request->validated();
        $product = Product::find($validated['product_id']);
        if (!$product) {
            return $this->respondedError('Product invalid');
        }

        if (!$product->available) {
            $messages = [
                'product_id' => ['Sản phẩm không có sẵn']
            ];
            return $this->respondedError('product_id invalid', $messages);
        }

        if (!$item = $user->carts->where('product_id', $validated['product_id'])->first()) {
            return $this->responded("Cart invalid");
        }

        if ($validated['quantity'] > $product->max_buy) {
            $messages = [
                'quantity' => ['Sản phẩm có số lượng mua tối đa là ' . $product->max_buy]
            ];
            return $this->respondedError('quantity invalid', $messages);
        }

        if ($validated['quantity'] > $product->amount) {
            $messages = [
                'quantity' => ['Số lượng mua lớn hơn số sản phẩm hiện có']
            ];
            return $this->respondedError('quantity invalid', $messages);
        }


        if ($validated['quantity'] <= 0) {
            $item->is_deleted = 1;
            $item->save();
            return $this->responded("Update cart item successfully");
        }

        $item->update($validated);
        return $this->responded("Update cart item successfully", $item);
    }

    public function destroy(Request $request)
    {
        $product_id = $request->product_id;
        $item = $this->user->carts->where('product_id', $product_id)->first();
        if (!$item) {
            $messages = [
                'product_id' => ['Sản phẩm không có sẵn']
            ];
            return $this->respondedError('product_id invalid', $messages);
        }

        $item->is_deleted = 1;
        $item->save();
        return $this->responded("Remove cart item successfully");

    }

    public function getCountItems()
    {
        $total = $this->user->carts()->count();
        return $this->responded("Get total count items in cart", [
            'total_count' => $total,
        ]);
    }
}
