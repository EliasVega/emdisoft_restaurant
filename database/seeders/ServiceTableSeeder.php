<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('services')->delete();

        DB::table('services')->insert(array (
            0 =>
            array (
                'id' => 1,
                'code' => '1001',
                'name' => 'Mensajeria',
                'price' => '15000.00',
                'category_id' => 5,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            1 =>
            array (
                'id' => 2,
                'code' => '1002',
                'name' => 'Taxis',
                'price' => '20000.00',
                'category_id' => 5,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            2 =>
            array (
                'id' => 3,
                'code' => '1003',
                'name' => 'Tienda',
                'price' => '15000.00',
                'category_id' => 5,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            3 =>
            array (
                'id' => 4,
                'code' => '1004',
                'name' => 'Cafeteria',
                'price' => '1500000.00',
                'category_id' => 5,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            4 =>
            array (
                'id' => 5,
                'code' => '1005',
                'name' => 'Restaurante',
                'price' => '19000.00',
                'category_id' => 5,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            5 =>
            array (
                'id' => 6,
                'code' => '1006',
                'name' => 'Auxiliar',
                'price' => '15000.00',
                'category_id' => 5,
                'unit_measure_id' => 70,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
        ));
    }
}
