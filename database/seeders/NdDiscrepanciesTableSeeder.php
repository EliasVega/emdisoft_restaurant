<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NdDiscrepanciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('nd_discrepancies')->delete();

        DB::table('nd_discrepancies')->insert(array (
            0 =>
            array (
                'id' => 1,
                'description' => 'Intereses',
            ),
            1 =>
            array (
                'id' => 2,
                'description' => 'Gastos por cobrar',
            ),
            2 =>
            array (
                'id' => 3,
                'description' => 'Cambio de valor',
            ),
            3 =>
            array (
                'id' => 4,
                'description' => 'Otros',
            ),
        ));


    }
}
