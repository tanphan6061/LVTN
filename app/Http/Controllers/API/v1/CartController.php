<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartCreateRequest;
use App\Http\Requests\Api\CartEditRequest;
use App\Http\Resources\CartItemR;
use App\Http\Resources\CartProductItemR;
use App\Http\Resources\CartSupplierItemR;
use App\Http\Resources\SupplierR;
use App\Models\Cart;
use App\Models\Discount_code;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $cart_items = $this->user->carts;
        $products = $suppliers = $cart_items->map(function ($item) {
            $product = $item->product;
            $product->quantity = $item->quantity;
            return $product;
        });

        $suppliers = $cart_items->map(function ($item) use ($products) {
            $supplier = $item->product->supplier;
            $supplier->items = $products->filter(function ($product) use ($supplier) {
                return $product->supplier->id == $supplier->id;
            });
            $supplier->discount_codes = $supplier->discount_codes()->available()->get();
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
        $item = $cart_item->where('product_id', $validated['product_id'])->first();
        if ($item && $item->quantity + $validated['quantity'] > $product->amount) {
            $messages = [
                'quantity' => ['Số lượng mua lớn hơn số sản phẩm hiện có']
            ];
            return $this->respondedError('quantity invalid', $messages);
        }

        if ($item) {
            $item->quantity += $validated['quantity'];
            $item->save();
            return $this->responded("Update quality cart item successfully", $item);
        }

        $data = $this->user->carts()->create($validated);
        return $this->responded("Create cart item successfully", $data);
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
        if (!$product = Product::find($validated['product_id'])) {
            return $this->respondedError('Product invalid');
        }
        if (!$cart = $user->carts->where('product_id', $validated['product_id'])->first()) {
            return $this->responded("Cart invalid");
        }
        if ($validated['quantity'] <= 0) {
            $cart->is_deleted = 1;
            $cart->save();
            return $this->responded("Update cart item successfully");
        }

        $cart->update($validated);
        return $this->responded("Update cart item successfully", $cart);

    }
}
