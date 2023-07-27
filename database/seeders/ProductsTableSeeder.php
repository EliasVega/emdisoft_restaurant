<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('products')->delete();

        DB::table('products')->insert(array (
            0 =>
            array (
                'id' => 1,
                'code' => '2301',
                'name' => 'CHORIZO',
                'price' => '1500.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 1,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            1 =>
            array (
                'id' => 2,
                'code' => '2302',
                'name' => 'RELLENA',
                'price' => '2000.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 2,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            2 =>
            array (
                'id' => 3,
                'code' => '2303',
                'name' => 'CHURRASQUITO 150g',
                'price' => '6000.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 2,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            3 =>
            array (
                'id' => 4,
                'code' => '2304',
                'name' => 'PECHUGAS',
                'price' => '4000.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 3,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            4 =>
            array (
                'id' => 5,
                'code' => '2305',
                'name' => 'COSTILA 200g',
                'price' => '5000.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 3,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            5 =>
            array (
                'id' => 6,
                'code' => '2306',
                'name' => 'PAPA 250g',
                'price' => '1500.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 4,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
        ));


    }
}
