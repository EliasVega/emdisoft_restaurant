<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('customers')->delete();

        DB::table('customers')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'CLIENTE UNO',
                'number' => '123456788',
                'email' => 'clienteuno@gmail.com',
                'document_id' => 6,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            /*
            1 =>
            array (
                'id' => 2,
                'name' => 'CLIENTE DOS',
                'number' => '123456787',
                'email' => 'ferresander@gmail.com',
                'document_id' => 6,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'CLIENTE TRES',
                'number' => '523456786',
                'email' => 'colsalle@gmail.com',
                'document_id' => 6,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'CLIENTE CUATRO',
                'number' => '723456785',
                'email' => 'americomp@gmail.com',
                'document_id' => 6,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),*/
        ));
    }
}
