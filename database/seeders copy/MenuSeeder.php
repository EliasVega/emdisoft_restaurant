<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->delete();

        DB::table('menus')->insert(array (
            0 =>
            array (
                'id' => 1,
                'code' => '2301',
                'name' => 'PICADA X 1',
                'price' => '29000.00',
                'sale_price' => '45000.00',
                'stock' => 0,
                'status' => 'active',
                'image' => 'noimagen.jpg',
                'category_id' => 1,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            1 =>
            array (
                'id' => 2,
                'code' => '2302',
                'name' => 'PICADA X2',
                'price' => '49500.00',
                'sale_price' => '80000.00',
                'stock' => 0,
                'status' => 'active',
                'image' => 'noimagen.jpg',
                'category_id' => 2,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
        ));
    }
}
