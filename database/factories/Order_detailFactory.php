<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            $product_id = rand(1, Product::count());
            $flag = Order_detail::where('product_id', $product_id)->first();
            if (!$flag) $loop = false;
        }

        return [
            'order_id' => 1,
            'product_id' => $product_id,
            'amount' => rand(1, 10),
            'price' => Product::find($product_id)->currentPrice,
        ];
    }
}
