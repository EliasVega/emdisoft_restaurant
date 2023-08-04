<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('categories')->delete();

        DB::table('categories')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Carnes',
                'description' => 'Todo lo relacionado con Carnes',
                'iva' => '19.00',
                'utility' => '30.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Carnes Frias',
                'description' => 'Todo lo relacionado con Carnes frias',
                'iva' => '19.00',
                'utility' => '30.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Legumbres',
                'description' => 'Todo lo relacionado con Legumbres',
                'iva' => '19.00',
                'utility' => '30.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Bebidas',
                'description' => 'Todo lo relacionado con Bebidas',
                'iva' => '8.00',
                'utility' => '30.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Bar',
                'description' => 'Bebidas Alcoholicas',
                'iva' => '8.00',
                'utility' => '0.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Materias Primas',
                'description' => 'Materias Primas',
                'iva' => '8.00',
                'utility' => '0.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
        ));


    }
}
