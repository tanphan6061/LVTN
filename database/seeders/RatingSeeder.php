<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $raw_data = json_decode(file_get_contents('http://localhost:8000/crawl_data/ratings.json'));
        $count_raw = count($raw_data);
        $products = Product::all();
        foreach ($products as $product) {
            $limit = rand(0, 20);
            $users = User::all()->random($limit);
            foreach ($users as $user) {
                $ratting = $raw_data[rand(0, $count_raw - 1)];
                $user->reviews()->create([
                    'comment' => $ratting->comment ?? "Hàng rất tệ!",
                    'star' => $ratting->rating_star,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
