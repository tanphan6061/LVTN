<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Shipping_address;
use Illuminate\Database\Eloquent\Factories\Factory;

class Shipping_addressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shipping_address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'order_id' => Order::all()->first()
        ];
    }
}
