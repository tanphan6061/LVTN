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
            'password' => bcrypt('Demopass69'), // password
            'birthday' => '1999-01-01',
            'sex' => 'male',
        ]);
        User::factory()->count(20)->create();

        //Brand::factory()->count(78)->create();
        //Category::factory()->count(26)->create();


        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);

        $this->call(SupplierSeeder::class);

        $this->call(ProductSeeder::class);
        $this->call(Product1Seeder::class);
        $this->call(Product2Seeder::class);
        $this->call(Product3Seeder::class);
        $this->call(Product4Seeder::class);
        $this->call(Product5Seeder::class);
        $this->call(Product6Seeder::class);
        $this->call(Product7Seeder::class);
        $this->call(Product8Seeder::class);
        $this->call(Product9Seeder::class);
        $this->call(Product10Seeder::class);
        $this->call(Product11Seeder::class);
        $this->call(Product12Seeder::class);
        $this->call(Product13Seeder::class);
        $this->call(Product14Seeder::class);
        $this->call(Product15Seeder::class);
        $this->call(Product16Seeder::class);
        $this->call(Product17Seeder::class);
        $this->call(Product18Seeder::class);
        $this->call(Product19Seeder::class);
        $this->call(Product20Seeder::class);
        $this->call(Product21Seeder::class);
        $this->call(Product22Seeder::class);
        $this->call(Product23Seeder::class);
        $this->call(Product24Seeder::class);
        //$this->call(Product25Seeder::class);

        $this->call(RatingSeeder::class);


        /*        Product::factory()->count(50)->create();
                Discount_code::factory()->count(10)->create();
                Product_image::factory()->count(50)->create();
                Favourite::factory()->count(30)->create();
                Review::factory()->count(500)->create();
                Order::factory()->count(1)->create();
                Order_detail::factory()->count(5)->create();
                Shipping_address::factory()->count(1)->create();
                History_order::factory()->count(3)->create();*/
    }

}
