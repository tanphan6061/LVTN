<?php

namespace Database\Seeders;

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
        DB::table('suppliers')->insert(
            [
                'name' => 'Phan Viet Tan',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345'),
                'phone' => '0923123123',
                'avatar' => 'https://cdn2.vectorstock.com/i/thumb-large/23/81/default-avatar-profile-icon-vector-18942381.jpg',
                'role' => 'admin'
            ]
        );
        DB::table('suppliers')->insert(
            [
                'name' => 'Nguyen van A',
                'email' => 'supplier@gmail.com',
                'password' => bcrypt('12345'),
                'phone' => '0945456456',
                'nameOfShop' => 'Shop cua tao',
                'slug' => 'shop-cua-tao',
                'address' => '70/10 Tô Ký, quận 12, tp. HCM',
                'avatar' => 'https://cdn1.vectorstock.com/i/thumb-large/82/55/anonymous-user-circle-icon-vector-18958255.jpg',
            ]
        );
    }
}
