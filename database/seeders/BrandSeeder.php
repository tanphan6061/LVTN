<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $raws = json_decode(file_get_contents('http://localhost:8000/crawl_data/brands.json'));
        foreach ($raws as $raw) {
            Brand::create([
                'name' => $raw,
                'slug' => Str::slug($raw, '-') . rand(1, 10)
            ]);
        }
    }
}
