<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('payment_methods')->delete();

        DB::table('payment_methods')->insert(array (
            0 =>
            array (
                'id' => 1,
                'code' => '1',
                'name' => 'Instrumento no definido',
            ),
            1 =>
            array (
                'id' => 10,
                'code' => '10',
                'name' => 'Efectivo',
            ),
            2 =>
            array (
                'id' => 47,
                'code' => '47',
                'name' => 'Transferencia Débito Bancaria',
            ),
            3 =>
            array (
                'id' => 48,
                'code' => '48',
                'name' => 'Tarjeta Crédito',
            ),
            4 =>
            array (
                'id' => 49,
                'code' => '49',
                'name' => 'Tarjeta Débito',
            ),
            5 =>
            array (
                'id' => 99,
                'code' => 'ZZZ',
                'name' => 'Otro*',
            ),
        ));


    }
}
