<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('roles')->delete();

        DB::table('roles')->insert(array (
            0 =>
            array (
                'id' => 1,
                'role' => 'SuperAdmin',
                'description' => 'Encargado del mantenimiento del sistema',
                'created_at' => '2023-01-12 21:07:41',
                'updated_at' => '2023-01-12 21:07:41',
            ),
            1 =>
            array (
                'id' => 2,
                'role' => 'Administrador',
                'description' => 'Es el responsable del mantenimiento de la empresa',
                'created_at' => '2023-01-12 21:07:41',
                'updated_at' => '2023-01-12 21:07:41',
            ),
            2 =>
            array (
                'id' => 3,
                'role' => 'Compras Y ventas',
                'description' => 'Tiene las funciones tanto de compras como de ventas de la empresa',
                'created_at' => '2023-01-12 21:07:41',
                'updated_at' => '2023-01-12 21:07:41',
            ),
            3 =>
            array (
                'id' => 4,
                'role' => 'Compras',
                'description' => 'Ejerce funciones de las compras de la empresa',
                'created_at' => '2023-01-12 21:07:41',
                'updated_at' => '2023-01-12 21:07:41',
            ),
            4 =>
            array (
                'id' => 5,
                'role' => 'Ventas',
                'description' => 'Ejerce funciones como vendedor de la empresa',
                'created_at' => '2023-01-12 21:07:41',
                'updated_at' => '2023-01-12 21:07:41',
            ),
        ));


    }
}
