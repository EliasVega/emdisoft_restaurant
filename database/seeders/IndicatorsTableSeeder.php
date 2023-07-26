<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndicatorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('indicators')->delete();

        DB::table('indicators')->insert(array (
            0 =>
            array (
                'id' => 1,
                'restaurant' => 'off',
                'created_at' => '2023-01-12 21:07:40',
                'updated_at' => '2023-01-12 21:07:40',
            ),
        ));
    }
}
