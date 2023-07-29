<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_products')->delete();

        DB::table('menu_products')->insert(array (
            0 =>
            array (
                'id' => 1,
                'quantity' => '2',
                'consumer_price' => '1500',
                'subtotal' => '3000.00',
                'menu_id' => 1,
                'product_id' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            1 =>
            array (
                'id' => 2,
                'quantity' => '2',
                'consumer_price' => '2000',
                'subtotal' => '4000.00',
                'menu_id' => 1,
                'product_id' => 2,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            2 =>
            array (
                'id' => 3,
                'quantity' => '3',
                'consumer_price' => '6000',
                'subtotal' => '18000.00',
                'menu_id' => 1,
                'product_id' => 3,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            3 =>
            array (
                'id' => 4,
                'quantity' => '1',
                'consumer_price' => '4000',
                'subtotal' => '4000.00',
                'menu_id' => 1,
                'product_id' => 4,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            4 =>
            array (
                'id' => 5,
                'quantity' => '3',
                'consumer_price' => '1500',
                'subtotal' => '4500.00',
                'menu_id' => 2,
                'product_id' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            5 =>
            array (
                'id' => 6,
                'quantity' => '3',
                'consumer_price' => '2000',
                'subtotal' => '6000.00',
                'menu_id' => 2,
                'product_id' => 2,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            6 =>
            array (
                'id' => 7,
                'quantity' => '3',
                'consumer_price' => '6000',
                'subtotal' => '18000.00',
                'menu_id' => 2,
                'product_id' => 3,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            7 =>
            array (
                'id' => 8,
                'quantity' => '2',
                'consumer_price' => '4000',
                'subtotal' => '8000.00',
                'menu_id' => 2,
                'product_id' => 4,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            8 =>
            array (
                'id' => 9,
                'quantity' => '2',
                'consumer_price' => '5000',
                'subtotal' => '10000.00',
                'menu_id' => 2,
                'product_id' => 5,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            9 =>
            array (
                'id' => 10,
                'quantity' => '2',
                'consumer_price' => '1500',
                'subtotal' => '3000.00',
                'menu_id' => 2,
                'product_id' => 6,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
        ));
    }
}
