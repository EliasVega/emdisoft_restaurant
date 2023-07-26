<?php

namespace Database\Seeders;

use App\Models\Voucher_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $voucherTypes = [
            [
                'code' => 'FVN',
                'name' => 'Factura de Venta Nacional',
                'state' => 'locked'
            ],
            [
                'code' => 'FVP',
                'name' => 'Factura de Venta Pos',
                'state' => 'locked'
            ],
            [
                'code' => 'FVE',
                'name' => 'Factura de Exportación',
                'state' => 'locked'
            ],
            [
                'code' => 'FVC',
                'name' => 'Factura de venta Contingencia',
                'state' => 'locked'
            ],
            [
                'code' => 'NCV',
                'name' => 'Nota Crédito venta',
                'state' => 'locked'
            ],
            [
                'code' => 'NDV',
                'name' => 'Nota debito venta',
                'state' => 'locked'
            ],
            [
                'code' => 'FCN',
                'name' => 'Factura de compra Nacional',
                'state' => 'locked'
            ],
            [
                'code' => 'FCE',
                'name' => 'Factura de Importacion',
                'state' => 'locked'
            ],
            [
                'code' => 'FCC',
                'name' => 'Factura de compra Contingencia',
                'state' => 'locked'
            ],
            [
                'code' => 'NCC',
                'name' => 'Nota Crédito compra',
                'state' => 'locked'
            ],
            [
                'code' => 'NDC',
                'name' => 'Nota debito compra',
                'state' => 'locked'
            ],
            [
                'code' => 'DSE',
                'name' => 'Documento Soporte electronico',
                'state' => 'locked'
            ],
            [
                'code' => 'NDS',
                'name' => 'Nota de ajuste Documento soporte',
                'state' => 'locked'
            ],
            [
                'code' => 'NIE',
                'name' => 'Nomina Individual electronica',
                'state' => 'locked'
            ],
            [
                'code' => 'NNI',
                'name' => 'Nota de ajuste Nomina Individual',
                'state' => 'locked'
            ],
            [
                'code' => 'RC',
                'name' => 'Recibo de caja',
                'state' => 'active'
            ],
            [
                'code' => 'CE',
                'name' => 'Comprobante de egreso',
                'state' => 'active'
            ],
            [
                'code' => 'OP',
                'name' => 'Orden de Pedido',
                'state' => 'active'
            ],
            [
                'code' => 'CG',
                'name' => 'Comprobante de Gastos',
                'state' => 'active'
            ]
        ];

        foreach ($voucherTypes as $voucherType) {
            Voucher_type::create($voucherType);
        }
    }
}
