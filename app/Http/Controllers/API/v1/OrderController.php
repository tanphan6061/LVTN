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
use PhpParser\Node\Stmt\DeclareDeclare;

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


    public function cancel(Order $order)
    {
        if ($order->user_id != $this->user->id) {
            return $this->respondedError("Not authorization");
        }

        if ($order->currentStatus != "processing") {
            return $this->respondedError("Order invalid", [
                'cart' => [
                    'Không thể hủy đơn hàng này'
                ]
            ]);
        }


        $order_discount_codes = $order->order_discount_codes;
        //dd($order_discount_codes);
        foreach ($order_discount_codes as $order_discount_code) {
            $discount_code = Discount_code::find($order_discount_code->discount_code_id);
            if (!$discount_code) {
                $discount_code->amount += 1;
                $discount_code->save();
            }
        }

        $order->history_orders()->create(['status' => 'cancel']);

        return $this->responded('Cancel order successfully', new OrderR($order));
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

        $orders = collect([]);
        $list_global_discount_codes = Discount_code::available()->getGlobalCouponAvailable();
        $global_discount_code = $list_global_discount_codes->where('code', $request->coupon_global_use)->first();
        $is_used_global_discount_code = false;
        $products = $this->getListProducts($cartItems); //get list products from cart
        $suppliers = $this->getListSuppliers($cartItems, $products); //get list suppliers from cart
        foreach ($suppliers as $supplier) {
            $supplier_discount_code = null;
            $deduct_supplier_discount_code = 0;
            $grandTotal = $supplier['grandTotal']; //granTotal in getListSuppliers method
            $current_supplier_discount_code = $validated['coupon_suppliers_use']->where('supplier_id', $supplier['id'])->first();

            if ($current_supplier_discount_code) {
                $supplier_discount_code = $supplier['discount_codes']->where('code', $current_supplier_discount_code->discount_code)->first();
                $deduct_supplier_discount_code = $this->getDeductSupplierDiscountCode($supplier, $current_supplier_discount_code);
            }


            $deduct_global_discount_code = $this->getDeductGlobalDiscountCode($supplier, $global_discount_code);
            //dd($supplier_discount_code, $global_discount_code);
            $order = $this->user->orders()->create(
                [
                    'supplier_id' => $supplier['id'],
                    'payment_type' => $validated['payment_type'],
                    'price' => $grandTotal,
                    'discount' => $deduct_global_discount_code + $deduct_supplier_discount_code,
                    'grand_total' => $grandTotal - ($deduct_global_discount_code + $deduct_supplier_discount_code)
                ]
            );


            $this->createOrderDetails($order, $supplier);

            if ($deduct_supplier_discount_code) {
                $supplier_discount_code->amount -= 1; //deduct value amount
                $supplier_discount_code->save();
                $this->createODDC($order, $supplier_discount_code, $deduct_supplier_discount_code);
            }

            if ($deduct_global_discount_code && $is_used_global_discount_code == false) {
                $is_used_global_discount_code = true;
                $global_discount_code->amount -= 1;//deduct value amount
                $global_discount_code->save();
                $this->createODDC($order, $global_discount_code, $deduct_global_discount_code);
            }

            $this->createShippingAddress($order, $addressShipping);
            $order->history_orders()->create();
            //$this->updateCart($supplier);
            $orders->push($order);
        }


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


            $this->updateProductAmount($product->id, $product->quantity);
            return $order->order_details()->create($data);
        });
    }

    private function updateProductAmount($product_id, $quantity)
    {
        $product = Product::find($product_id);
        $product->amount = $product->amount - $quantity;
        $product->save();
    }


    /**
     * create order_detail_discount_codes
     * @param $order
     * @param $discount_code
     * @param $deduct_value
     * @return mixed
     */
    private function createODDC($order, $discount_code, $deduct_value)
    {
        $acceptFields = ['code', 'start_date', 'end_date', 'amount'
            , 'percent', 'from_price', 'max_price', 'is_global', 'category_id'];
        return $order->order_discount_codes()->create(
            [
                'discount_code_id' => $discount_code->id,
                'order_id' => $order->id,
                'discount' => $deduct_value,
                'description' => collect($discount_code)->only($acceptFields)->toJson(), //temp discount
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


    private function getDeductSupplierDiscountCode($supplier, $current_supplier_discount_code)
    {
        $grandTotal = $supplier['grandTotal'];
        if (!$current_supplier_discount_code) return 0;

        $discount_code = $supplier['discount_codes']->where('code', $current_supplier_discount_code->discount_code)->first();
        if (!$discount_code) return 0;

        if ($discount_code->from_price > $grandTotal) return 0;

        $tempDeductCoupon = $grandTotal * $discount_code->percent / 100;
        return $tempDeductCoupon > $discount_code->max_price ? $discount_code->max_price : $grandTotal * $discount_code->percent / 100;
    }

    private function getDeductGlobalDiscountCode($supplier, $discount_code)
    {
        if (!$discount_code) return 0;

        $totalPriceByCategory = $supplier['items']->reduce(function ($accumulator, $product) use ($discount_code) {
            if ($product->category_id == $discount_code->category_id || $discount_code->category->childs->contains($product->category_id)) {
                return $accumulator + $product->grandTotal;
            }
            return $accumulator + 0;
        }, 0);


        if ($discount_code->from_price > $totalPriceByCategory) return 0;

        $tempDeductCoupon = $totalPriceByCategory * $discount_code->percent / 100;
        return $tempDeductCoupon > $discount_code->max_price ? $discount_code->max_price : $totalPriceByCategory * $discount_code->percent / 100;
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
            $supplier->discount_codes = $supplier->discount_codes()->available()
                ->where('is_global', 0)->get();
            return collect($supplier);
        })->unique();
    }
}
