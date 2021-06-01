<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::table('suppliers')->create(
            [
                'name' => 'Nguyen van A',
                'email' => 'supplier@gmail.com',
                'password' => bcrypt('12345'),
                'phone' => '0945456456',
                'nameOfShop' => 'Shop cua tao',
                'slug' => 'shop-cua-tao',
                'address' => '70/10 Tô Ký, quận 12, tp. HCM',
            ]
        );
        DB::table('suppliers')->create(
            [
                'name' => 'Phan Viet Tan',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345'),
                'nameOfShop' => 'Taka',
                'phone' => '0923123123',
                'role' => 'admin'
            ]
        );*/

        Supplier::create([
            'name' => 'Nguyen van A',
            'email' => 'supplier@gmail.com',
            'password' => bcrypt('12345'),
            'phone' => '0945456456',
            'nameOfShop' => 'Shop cua tao',
            'slug' => 'shop-cua-tao',
            'address' => '70/10 Tô Ký, quận 12, tp. HCM',
        ]);

        Supplier::create([
            'name' => 'Phan Viet Tan',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
            'nameOfShop' => 'Taka',
            'phone' => '0923123123',
            'role' => 'admin'
        ]);

    }
}
