<?php

namespace Database\Factories;

use App\Http\Resources\ProductR;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Resources\Json\JsonResource;

class Order_detailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order_detail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $loop = true;
        $product_id = null;
        while ($loop) {
            $products = Supplier::find(1)->products->pluck('id')->toArray();
            $product_id = $products[rand(0, count($products) - 1)];
            $flag = Order_detail::where('product_id', $product_id)->first();
            if (!$flag) $loop = false;
        }

        $product = Product::find($product_id);

        return [
            'order_id' => 1,
            'product_id' => $product_id,
            'quantity' => rand(1, 5),
            'price' => $product->price,
            'discount' => $product->discount,
            'temp_product' => (new ProductR($product))->toJson(),
            //'grand_total' => Product::find($product_id)->currentPrice,
        ];
    }
}
