<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeDocumentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('type_documents')->delete();

        DB::table('type_documents')->insert(array (
            0 =>
            array (
                'id' => 1,
                'code' => '01',
                'name' => 'Factura de Venta Nacional',
                'prefix' => 'fv',
                'cufe_algorithm' => 'CUFE-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            1 =>
            array (
                'id' => 2,
                'code' => '02',
                'name' => 'Factura de Exportación',
                'prefix' => 'fv',
                'cufe_algorithm' => 'CUFE-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            2 =>
            array (
                'id' => 3,
                'code' => '03',
                'name' => 'Factura de Contingencia',
                'prefix' => 'fv',
                'cufe_algorithm' => 'CUDE-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            3 =>
            array (
                'id' => 4,
                'code' => '91',
                'name' => 'Nota Crédito',
                'prefix' => 'nc',
                'cufe_algorithm' => 'CUDE-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            4 =>
            array (
                'id' => 5,
                'code' => '92',
                'name' => 'Nota Débito',
                'prefix' => 'nd',
                'cufe_algorithm' => 'CUDE-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            5 =>
            array (
                'id' => 6,
                'code' => '',
                'name' => 'ZIP',
                'prefix' => 'z',
                'cufe_algorithm' => '',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            6 =>
            array (
                'id' => 7,
                'code' => '89',
                'name' => 'AttachedDocument',
                'prefix' => 'at',
                'cufe_algorithm' => '',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            7 =>
            array (
                'id' => 8,
                'code' => '88',
                'name' => 'ApplicationResponse',
                'prefix' => 'ar',
                'cufe_algorithm' => 'CUDE-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            8 =>
            array (
                'id' => 9,
                'code' => '1',
                'name' => 'Nomina Individual',
                'prefix' => 'ni',
                'cufe_algorithm' => 'CUNE-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            9 =>
            array (
                'id' => 10,
                'code' => '2',
                'name' => 'Nomina Individual de Ajuste',
                'prefix' => 'na',
                'cufe_algorithm' => 'CUNE-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            10 =>
            array (
                'id' => 11,
                'code' => '05',
                'name' => 'Documento Soporte Electrónico',
                'prefix' => 'dse',
                'cufe_algorithm' => 'CUDS-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            11 =>
            array (
                'id' => 12,
                'code' => '04',
                'name' => 'Factura electrónica de Venta - tipo 04',
                'prefix' => 'fv',
                'cufe_algorithm' => 'CUFE-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
            12 =>
            array (
                'id' => 13,
                'code' => '95',
                'name' => 'Nota de Ajuste al Documento Soporte Electrónico',
                'prefix' => 'nds',
                'cufe_algorithm' => 'CUDS-SHA384',
                'created_at' => '2023-01-12 21:07:44',
                'updated_at' => '2023-01-12 21:07:44',
            ),
        ));


    }
}
