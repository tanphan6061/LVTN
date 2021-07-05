<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $raws = json_decode(file_get_contents('http://localhost:8000/crawl_data/categories.json'));
        foreach ($raws as $raw) {
            Category::create([
                'name' => $raw->name,
                'slug' => Str::slug($raw->name, '-') . rand(1, 10),
                'image' => $raw->image,
                'parent_category_id' => null
            ]);
        }
    }
}
