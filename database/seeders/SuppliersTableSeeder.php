<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('suppliers')->delete();

        DB::table('suppliers')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'NEXANS COLOMBIA',
                'number' => '223456789-4',
                'email' => 'nexans@gmail.com',
                'document_id' => 6,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'BLACK&DECKER',
                'number' => '223456789-5',
                'email' => 'blackdecker@gmail.com',
                'document_id' => 6,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'ASUS IMPORTACIONES',
                'number' => '323456789-6',
                'email' => 'asus@gmail.com',
                'document_id' => 6,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'LENOVO COLOMBIA',
                'number' => '323456789-7',
                'email' => 'lenovo@gmail.com',
                'document_id' => 6,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
        ));


    }
}
