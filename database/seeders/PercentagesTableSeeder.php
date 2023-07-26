<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PercentagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('percentages')->delete();

        DB::table('percentages')->insert(array (
            0 =>
            array (
                'id' => 1,
                'percentage' => '0.00',
                'base' => 0,
            ),
            1 =>
            array (
                'id' => 2,
                'percentage' => '0.10',
                'base' => 0,
            ),
            2 =>
            array (
                'id' => 3,
                'percentage' => '0.50',
                'base' => 0,
            ),
            3 =>
            array (
                'id' => 4,
                'percentage' => '1.00',
                'base' => 0,
            ),
            4 =>
            array (
                'id' => 5,
                'percentage' => '1.50',
                'base' => 0,
            ),
            5 =>
            array (
                'id' => 6,
                'percentage' => '2.00',
                'base' => 0,
            ),
            6 =>
            array (
                'id' => 7,
                'percentage' => '2.50',
                'base' => 0,
            ),
            7 =>
            array (
                'id' => 8,
                'percentage' => '3.00',
                'base' => 0,
            ),
            8 =>
            array (
                'id' => 9,
                'percentage' => '3.50',
                'base' => 0,
            ),
            9 =>
            array (
                'id' => 10,
                'percentage' => '4.00',
                'base' => 0,
            ),
            10 =>
            array (
                'id' => 11,
                'percentage' => '5.00',
                'base' => 0,
            ),
            11 =>
            array (
                'id' => 12,
                'percentage' => '6.00',
                'base' => 0,
            ),
            12 =>
            array (
                'id' => 13,
                'percentage' => '7.00',
                'base' => 0,
            ),
            13 =>
            array (
                'id' => 14,
                'percentage' => '10.00',
                'base' => 0,
            ),
            14 =>
            array (
                'id' => 15,
                'percentage' => '11.00',
                'base' => 0,
            ),
            15 =>
            array (
                'id' => 16,
                'percentage' => '15.00',
                'base' => 0,
            ),
            16 =>
            array (
                'id' => 17,
                'percentage' => '20.00',
                'base' => 0,
            ),
            17 =>
            array (
                'id' => 18,
                'percentage' => '33.00',
                'base' => 0,
            ),
        ));
    }
}
