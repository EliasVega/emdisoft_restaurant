<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('raw_materials')->delete();

        DB::table('raw_materials')->insert(array (
            0 =>
            array (
                'id' => 1,
                'code' => '5301',
                'name' => 'CHORIZO DE PARRILLA',
                'price' => '1500.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 6,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            1 =>
            array (
                'id' => 2,
                'code' => '5302',
                'name' => 'CARNE DE ASAR',
                'price' => '40.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 6,
                'unit_measure_id' => 692,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            2 =>
            array (
                'id' => 3,
                'code' => '5303',
                'name' => 'RELLENAS',
                'price' => '1500.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 6,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            3 =>
            array (
                'id' => 4,
                'code' => '5304',
                'name' => 'PAPA CRIOLLA',
                'price' => '3000.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 6,
                'unit_measure_id' => 692,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            4 =>
            array (
                'id' => 5,
                'code' => '5305',
                'name' => 'PAPA PASTUSA',
                'price' => '3000.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 6,
                'unit_measure_id' => 692,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            5 =>
            array (
                'id' => 6,
                'code' => '5306',
                'name' => 'CARNE DE COSTILLA',
                'price' => '15000.00',
                'stock' => 0,
                'status' => 'active',
                'category_id' => 6,
                'unit_measure_id' => 692,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
        ));
    }
}
