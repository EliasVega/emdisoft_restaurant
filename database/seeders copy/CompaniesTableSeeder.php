<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('companies')->delete();

        DB::table('companies')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Restaurante',
                'nit' => '123456789',
                'dv' => '3',
                'email' => 'ecounts@gmail.com',
                'logo' => '1687435626.jpg',
                'department_id' => 21,
                'municipality_id' => 846,
                'created_at' => '2023-01-12 21:07:42',
                'updated_at' => '2023-01-12 21:07:42',
            ),
        ));


    }
}
