<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('taxes')->delete();

        DB::table('taxes')->insert(array (
            0 =>
            array (
                'id' => 1,
                'code' => '01',
                'name' => 'IVA',
                'description' => 'Impuesto sobre las ventas',
            ),
            1 =>
            array (
                'id' => 2,
                'code' => '02',
                'name' => 'IC',
                'description' => 'Impuesto al Consumo Departamental Nominal',
            ),
            2 =>
            array (
                'id' => 3,
                'code' => '03',
                'name' => 'ICA',
                'description' => 'Impuesto de Industria, Comercio y Aviso',
            ),
            3 =>
            array (
                'id' => 4,
                'code' => '04',
                'name' => 'INC',
                'description' => 'Impuesto Nacional al Consumo',
            ),
            4 =>
            array (
                'id' => 5,
                'code' => '05',
                'name' => 'ReteIVA',
                'description' => 'Retención sobre el IVA',
            ),
            5 =>
            array (
                'id' => 6,
                'code' => '06',
                'name' => 'ReteRenta',
                'description' => 'Retención sobre Renta',
            ),
            6 =>
            array (
                'id' => 7,
                'code' => '07',
                'name' => 'ReteICA',
                'description' => 'Retención sobre el ICA',
            ),
            7 =>
            array (
                'id' => 8,
                'code' => '08',
                'name' => 'IC Porcentual',
                'description' => 'Impuesto al consumo Departamental Porcentual',
            ),
            8 =>
            array (
                'id' => 9,
                'code' => '20',
                'name' => 'FtoHorticultura',
                'description' => 'Cuota de Fomento Hortifrutícula',
            ),
            9 =>
            array (
                'id' => 10,
                'code' => '21',
                'name' => 'Timbre',
                'description' => 'Impuesto al Timbre',
            ),
            10 =>
            array (
                'id' => 11,
                'code' => '22',
                'name' => 'INC Bolsas',
                'description' => 'Impueto nacional al consumo de bolsas plasticas',
            ),
            11 =>
            array (
                'id' => 12,
                'code' => '23',
                'name' => 'INCarbono',
                'description' => 'Impuesto nacional al Carbono',
            ),
            12 =>
            array (
                'id' => 13,
                'code' => '24',
                'name' => 'INCombustibles',
                'description' => 'Impuesto nacional a los combustibles',
            ),
            13 =>
            array (
                'id' => 14,
                'code' => '25',
                'name' => 'Sobretasa Combustibles',
                'description' => 'Sobretasa a los combustibles',
            ),
            14 =>
            array (
                'id' => 15,
                'code' => '26',
                'name' => 'Sordicom',
            'description' => 'Contribucion minoristas (combustibles)',
            ),
            15 =>
            array (
                'id' => 16,
                'code' => '30',
                'name' => 'IC Datos',
                'description' => 'Impuesto al consumo de datos',
            ),
        ));


    }
}
