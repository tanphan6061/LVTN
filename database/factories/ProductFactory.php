<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => rand(1, Category::count()),
            'brand_id' => rand(1, Brand::count() - 4),
            'supplier_id' => rand(1, Supplier::count()),
            'name' => $this->faker->unique()->name,
            'slug' => Str::random(16),
            'price' => rand(10000, 9000000),
            'amount' => rand(0, 20),
            'description' => $this->faker->paragraph,
            'detail' => $this->faker->text(500),
            'status' => 'available',
            'discount' => 0
        ];
    }
}
