<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::find(1);
        return [
            'user_id' => 1,
            'supplier_id' => 1,
            'payment_type' => 'COD',
            'price' => rand(1000000, 100000000),
            'discount' => 0,
            'grand_total' => rand(1000000, 100000000),
            'status' => 'delivered',
        ];
    }
}
