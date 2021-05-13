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
            'phone' => '0358771364',
            'address' => $this->faker->address,
            'payment_type' => 'COD',
            'total_price' => rand(1000000, 100000000),
            'status' => 'delivered',
        ];
    }
}
