<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\Api\OrderCreateRequest;
use App\Http\Resources\OrderDetailR;
use App\Http\Resources\OrderR;
use App\Http\Resources\ProductR;
use App\Http\Resources\TempProductOrderDetailR;
use App\Models\Discount_code;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping_address;
use App\Taka\Paginate\Paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends ApiController
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
        //DB::enableQueryLog();
        //dd(DB::getQueryLog());
        $builder = Order::where('user_id', $this->user->id)->orderBy('id', 'desc');
        $orders = new Paginate($builder);
        $data = [
            'data' => OrderR::collection($orders->getData()),
            'total_count' => $orders->getTotal()
        ];
        return $this->responded("Get list orders successfully", $data);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        if ($order->user_id != $this->user->id) {
            return $this->respondedError("Not authorization");
        }

        return $this->responded("Get detail order successfully", new OrderDetailR($order));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderCreateRequest $request)
    {
        $validated = $request->validated();

        if ($validated['address_id']) {
            $addressShipping = $this->user->addresses->where('id', $validated['address_id'])->first();
        } else {
            $addressShipping = $this->user->addresses->where('active', 1)->first();
        }

        if (!$addressShipping) {
            return $this->respondedError("Address shipping invalid", [
                'address_id' => ['Chưa thêm địa chỉ nhận hàng!']
            ]);
        }

        $validated['coupon_suppliers_use'] = $this->toObjectCollection($validated['coupon_suppliers_use']);
        $cartItems = $this->user->carts;
        if (!$cartItems->count()) {
            return $this->respondedError("Cart Empty", [
                'cart' => ['Giỏ hàng đang trống!']
            ]);
        }

        $isAvailable = $cartItems->every(function ($item) {
            $product = $item->product;
            return $product->available;
        });

        $isValidAmount = $cartItems->every(function ($item) {
            $product = $item->product;
            return ($product->max_buy >= $item->quantity) && ($product->max_buy <= $product->amount);
        });


        if (!$isAvailable) {
            return $this->respondedError("Cart Empty", [
                'cart' => ['Giỏ hàng đang chứa sản phẩm không có sẵn!']
            ]);
        }

        if (!$isValidAmount) {
            return $this->respondedError("Cart Empty", [
                'cart' => ['Giỏ hàng không hợp lệ, kiểm tra lại giỏ hàng!']
            ]);
        }

        $listDiscountAvailable = Discount_code::available()->getGlobalCouponAvailable();

        $discountGlobal = $listDiscountAvailable->where('code', $request->coupon_global_use)->first();
        $discountGlobalUsed = false;

        $products = $this->getListProducts($cartItems);

        $suppliers = $this->getListSuppliers($cartItems, $products);

        $orders = collect($suppliers)->map(function ($supplier) use ($discountGlobalUsed, $discountGlobal, $validated, $addressShipping) {
            $discountSupplier = null;
            $deductCouponSupplier = 0;

            $grandTotal = $supplier['grandTotal'];
            $itemCouponSupplier = $validated['coupon_suppliers_use']->where('supplier_id', $supplier['id'])->first();
            if ($itemCouponSupplier) {
                $discountSupplier = $supplier['discount_codes']->where('code', $itemCouponSupplier->discount_code)->first();
                $deductCouponSupplier = $this->getDeductCouponSupplier($supplier, $itemCouponSupplier);
            }

            $deductCouponGlobal = $this->getDeductCouponGlobal($supplier, $discountGlobal);

            $order = $this->user->orders()->create(
                [
                    'supplier_id' => $supplier['id'],
                    'payment_type' => $validated['payment_type'],
                    'price' => $grandTotal,
                    'discount' => $deductCouponGlobal + $deductCouponSupplier,
                    'grand_total' => $grandTotal - ($deductCouponGlobal + $deductCouponSupplier)
                ]
            );


            $this->createOrderDetails($order, $supplier);

            if ($deductCouponSupplier) {
                $this->createODC($order, $discountSupplier, $deductCouponSupplier);
            }

            if ($deductCouponGlobal && $discountGlobalUsed == false) {
                $discountGlobalUsed = true;
                $this->createODC($order, $discountGlobal, $deductCouponGlobal);
            }

            $this->createShippingAddress($order, $addressShipping);
            $order->history_orders()->create();
            $this->updateCart($supplier);
            return $order;
        });


        return $this->responded("Create orders successfully", OrderR::collection($orders));
    }


    private function createOrderDetails($order, $supplier)
    {
        return $supplier['items']->map(function ($product) use ($order) {
            $temp_product = Product::find($product->id);
            $data = [
                'product_id' => $product->id,
                'price' => $product->price,
                'discount' => $product->discount,
                'quantity' => $product->quantity,
                'temp_product' => (new TempProductOrderDetailR($temp_product))->toJson()
            ];

            //dd($data);

            $this->updateProduct($product->id, $product->quantity);
            return $order->order_details()->create($data);
        });
    }

    private function updateProduct($id, $quantity)
    {
        $product = Product::find($id);
        $product->amount = $product->amount - $quantity;
        $product->save();
    }


    private function createODC($order, $discount_code, $deduct)
    {
        $acceptFields = ['code', 'start_date', 'end_date', 'amount'
            , 'percent', 'from_price', 'max_price', 'is_global', 'category_id'];
        return $order->order_discount_codes()->create(
            [
                'discount_code_id' => $discount_code->id,
                'order_id' => $order->id,
                'discount' => $deduct,
                'description' => collect($discount_code)->only($acceptFields)->toJson(),
            ]
        );
    }

    private function createShippingAddress($order, $addressShipping)
    {
        $data_shipping = collect($addressShipping)->only('name', 'phone', 'address');
        $data_shipping['order_id'] = $order->id;
        return Shipping_address::create($data_shipping->toArray());
    }

    private function updateCart($supplier)
    {
        return $supplier['items']->map(function ($product) {
            $item = $this->user->carts->where('product_id', $product->id)->where('is_delete', 0)->first();
            $item->update(['is_deleted' => 1]);
            return $item;
        });
    }


    private function getDeductCouponSupplier($supplier, $itemCouponSupplier)
    {
        $grandTotal = $supplier['grandTotal'];
        if (!$itemCouponSupplier) return 0;

        $discountCode = $supplier['discount_codes']->where('code', $itemCouponSupplier->discount_code)->first();
        if (!$discountCode) return 0;

        if ($discountCode->from_price > $grandTotal) return 0;

        $tempDeductCoupon = $grandTotal * $discountCode->percent / 100;
        return $tempDeductCoupon > $discountCode->max_price ? $discountCode->max_price : $grandTotal * $discountCode->percent / 100;
    }

    private function getDeductCouponGlobal($supplier, $discountCode)
    {
        if (!$discountCode) return 0;

        $totalPriceByCategory = $supplier['items']->reduce(function ($accumulator, $product) use ($discountCode) {
            if ($product->category_id == $discountCode->category_id || $discountCode->category->childs->contains($product->category_id)) {
                return $accumulator + $product->grandTotal;
            }
            return $accumulator + 0;
        }, 0);


        if ($discountCode->from_price > $totalPriceByCategory) return 0;

        $tempDeductCoupon = $totalPriceByCategory * $discountCode->percent / 100;
        return $tempDeductCoupon > $discountCode->max_price ? $discountCode->max_price : $totalPriceByCategory * $discountCode->percent / 100;
    }

    private function getListProducts($cartItems)
    {
        return $cartItems->map(function ($item) {
            $product = $item->product;
            $product->quantity = $item->quantity;
            return $product;
        });
    }

    private function getListSuppliers($cartItems, $products)
    {
        return $cartItems->map(function ($item) use ($products) {
            $supplier = $item->product->supplier;
            $supplier->items = $products->filter(function ($product) use ($supplier) {
                return $product->supplier->id == $supplier->id;
            });
            $supplier->grandTotal = $supplier->items->reduce(function ($accumulator, $product) {
                return $accumulator + $product->grandTotal * $product->quantity;
            }, 0);
            $supplier->discount_codes = $supplier->discount_codes()->available()->get();
            return collect($supplier);
        })->unique();
    }
}
