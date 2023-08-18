<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerificationCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('verification_codes')->delete();

        DB::table('verification_codes')->insert(array (
            0 =>
            array (
                'id' => 1,
                'user_id' => 3,
                'code' => 'matrix2012'
            ),
        ));
    }
}
