<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Product21Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        //64 66
        //$temp = json_decode(file_get_contents(''));
        $temp = json_decode(file_get_contents('http://localhost:8000/crawl_data/thi-trang-tr-em.json'));
        foreach ($temp as $raw) {
            $product = Product::create([
                'category_id' => 22,
                'brand_id' => rand(64,66),
                'supplier_id' => rand(1, Supplier::count()),
                'name' => $raw->name,
                'slug' => Str::random(16),
                'price' => $raw->price_max_before_discount,
                'amount' => rand(0, 50),
                'description' => $raw->description,
                'status' => 'available',
                'discount' => $raw->price_max_before_discount > $raw->price_min ? floor(100 - ($raw->price_min * 100 / $raw->price_max_before_discount)) : 0
            ]);
            foreach ($raw->images as $image) {
                $product->images()->create([
                    'url' => 'https://cf.shopee.vn/file/' . $image
                ]);
            }
        }
    }


}
