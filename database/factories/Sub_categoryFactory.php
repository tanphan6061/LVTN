<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Sub_category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class Sub_categoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sub_category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company,
            'slug' => Str::random(16),
            'category_id' => rand(1, Category::count())
        ];
    }
}
