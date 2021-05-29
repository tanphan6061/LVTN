<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Discount_code;
use App\Models\Favourite;
use App\Models\History_order;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Review;
use App\Models\Shipping_address;
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
        User::create([
            'name' => 'Nguoi trong ao ho',
            'email' => 'choeger@example.net',
            // 'email_verified_at' => now(),
            'password' => bcrypt('Demopass69'), // password
            'birthday' => '1999-01-01', // password
            'sex' => 'male', // password
        ]);
        User::factory()->count(10)->create();
        Brand::factory()->count(10)->create();
        Category::factory()->count(5)->create();

        $this->call([
            SupplierSeeder::class,
        ]);

        Product::factory()->count(50)->create();
        Discount_code::factory()->count(10)->create();
        Product_image::factory()->count(50)->create();
        Favourite::factory()->count(30)->create();
        Review::factory()->count(60)->create();
        Order::factory()->count(1)->create();
        Order_detail::factory()->count(5)->create();
        Shipping_address::factory()->count(1)->create();
        History_order::factory()->count(3)->create();
    }

}
