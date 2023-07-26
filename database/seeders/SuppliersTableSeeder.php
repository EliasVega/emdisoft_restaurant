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
                'dv' => NULL,
                'address' => 'Centro empresarial chimita bodega 14',
                'phone' => '6374581',
                'email' => 'nexans@gmail.com',
                'contact' => 'LUIS EMILIO MILLAN',
                'phone_contact' => '3174576982',
                'department_id' => 21,
                'municipality_id' => 846,
                'document_id' => 6,
                'liability_id' => 1,
                'organization_id' => 1,
                'regime_id' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'BLACK&DECKER',
                'number' => '223456789-5',
                'dv' => NULL,
                'address' => 'Centro empresarial chimita bodega 15',
                'phone' => '6374582',
                'email' => 'blackdecker@gmail.com',
                'contact' => 'LUIS ANTONIO MONROY',
                'phone_contact' => '3174576983',
                'department_id' => 21,
                'municipality_id' => 846,
                'document_id' => 6,
                'liability_id' => 1,
                'organization_id' => 1,
                'regime_id' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'ASUS IMPORTACIONES',
                'number' => '323456789-6',
                'dv' => NULL,
                'address' => 'Centro empresarial chimita bodega 16',
                'phone' => '6371582',
                'email' => 'asus@gmail.com',
                'contact' => 'FABIAN CORRALES',
                'phone_contact' => '3174486983',
                'department_id' => 21,
                'municipality_id' => 846,
                'document_id' => 6,
                'liability_id' => 1,
                'organization_id' => 1,
                'regime_id' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'LENOVO COLOMBIA',
                'number' => '323456789-7',
                'dv' => NULL,
                'address' => 'Centro empresarial chimita bodega 17',
                'phone' => '6373982',
                'email' => 'lenovo@gmail.com',
                'contact' => 'FANNY OSORIO',
                'phone_contact' => '3174476983',
                'department_id' => 21,
                'municipality_id' => 846,
                'document_id' => 6,
                'liability_id' => 1,
                'organization_id' => 1,
                'regime_id' => 1,
                'created_at' => '2023-01-12 21:07:43',
                'updated_at' => '2023-01-12 21:07:43',
            ),
        ));


    }
}
