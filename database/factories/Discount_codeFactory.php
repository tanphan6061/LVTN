<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Discount_code;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class Discount_codeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount_code::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */


    public function definition()
    {
        $ids = Category::where('parent_category_id','!=',null)->pluck('id')->toArray();
        array_push($ids,null);

        return [
            'code' => Str::random(16),
            'supplier_id'=> rand(1, Supplier::count()),
            'start_date'=>'2021-02-03',
            'end_date'=>'2021-03-09',
            'amount'=>rand(0,20),
            'percent'=>rand(0,20),
            'from_price'=>rand(1,50)*1000,
            'max_price'=>rand(1,90)*1000,
            'category_id'=> $ids[rand(0,count($ids)-1)]
        ];
    }
}
