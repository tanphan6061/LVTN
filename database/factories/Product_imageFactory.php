<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Product_image;
use Illuminate\Database\Eloquent\Factories\Factory;

class Product_imageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product_image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => $this->faker->imageUrl(),
            'product_id' => rand(1, Product::count())
        ];
    }
}
