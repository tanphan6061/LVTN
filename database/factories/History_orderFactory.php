<?php

namespace Database\Factories;

use App\Models\History_order;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class History_orderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = History_order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'order_id' =>  rand(1, Order::count()),
            'status' => 'processing',
        ];
    }
}
