<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $available = false;
        $product_id = 0;
        $user_id = 0;
        while (!$available) {
            $product_id = rand(1, Product::count());
            $user_id = rand(1, User::count());
            $flag = Review::where(['product_id' => $product_id, 'user_id' => $user_id])->first();
            if (!$flag) $available = true;
        }
        return [
            //
            'product_id' => $product_id,
            'user_id' => $user_id,
            'star' => rand(1, 5),
            'comment' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab commodi dignissimos error et maiores natus quis repellat repudiandae, ut veritatis. Accusamus eum ipsa neque numquam possimus quae sapiente? Id, officiis.",
        ];
    }
}

?>
