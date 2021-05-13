<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Favourite;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Review;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory()->count(10)->create();
        Brand::factory()->count(5)->create();
        Category::factory()->count(5)->create();

        $this->call([
            SupplierSeeder::class,
        ]);
        Product::factory()->count(10)->create();
        Product_image::factory()->count(50)->create();
        Favourite::factory()->count(30)->create();
        Review::factory()->count(60)->create();
        Order::factory()->count(1)->create();
        Order_detail::factory()->count(5)->create();
    }
}
