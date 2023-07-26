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
                'name' => 'Electricos',
                'description' => 'Todo lo relacionado con insumos electricos',
                'iva' => '19.00',
                'utility' => '30.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Ferreteria',
                'description' => 'Todo lo relacionado con Herramientas de Ferreteria',
                'iva' => '19.00',
                'utility' => '30.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Computadores',
                'description' => 'Todo lo relacionado con Computacion',
                'iva' => '19.00',
                'utility' => '30.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'tablet',
                'description' => 'Todo lo relacionado con tablets',
                'iva' => '19.00',
                'utility' => '30.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Servicios y Excentos',
                'description' => 'Gastos de la empresa',
                'iva' => '0.00',
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
                'iva' => '0.00',
                'utility' => '0.00',
                'status' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
        ));


    }
}
