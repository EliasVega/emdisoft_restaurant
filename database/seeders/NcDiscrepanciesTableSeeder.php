<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NcDiscrepanciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('nc_discrepancies')->delete();

        DB::table('nc_discrepancies')->insert(array (
            0 =>
            array (
                'id' => 1,
                'description' => 'Devolución parcial de los bienes y/o no aceptación parcial del servicio',
            ),
            1 =>
            array (
                'id' => 2,
                'description' => 'Anulación de factura electrónica',
            ),
            2 =>
            array (
                'id' => 3,
                'description' => 'Rebaja o descuento parcial o total',
            ),
            3 =>
            array (
                'id' => 4,
                'description' => 'Ajuste de precio',
            ),
            4 =>
            array (
                'id' => 5,
                'description' => 'Otros',
            ),
        ));


    }
}
