@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ route('sale_box.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
            <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
        </div>
        <div class="col-12 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="form-control-label" for="nombre"># caja</label>
                <p>{{ $sale_box->id }}</p>
            </div>
        </div>

        <div class="col-12 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="form-control-label" for="open">fecha de apertura</label>
                <p>{{ $sale_box->created_at }}</p>
            </div>
        </div>
        @if ($sale_box->status == 'close')
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="close">Cerrada</label>
                    <p>{{ $sale_box->updated_at }}</p>
                </div>
            </div>
        @endif
        <div class="col-12 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="form-control-label" for="cash_open">Efectivo apertura</label>
                <p>{{ number_format($sale_box->cash_box,2) }}</p>
            </div>
        </div>
        <div class="col-12 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="form-control-label" for="abono">total entradas</label>
                <p>{{ number_format($sale_box->in_total,2) }}</p>
            </div>
        </div>
        <div class="col-12 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="form-control-label" for="abono">Total salidas</label>
                <p>{{ number_format($sale_box->out_total,2) }}</p>
            </div>
        </div>
        <div class="col-12 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="form-control-label" for="abono">Entrada de efectivo</label>
                <p>{{ number_format($sale_box->cash,2) }}</p>
            </div>
        </div>

        <div class="col-12 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="form-control-label" for="pay">Salida de efectivo</label>
                <p>{{ number_format($sale_box->departure,2) }}</p>
            </div>
        </div>
        <div class="col-12 col-md-4 col-sm-6">
            <div class="form-group">
                <label class="form-control-label" for="balance">Saldo en caja</label>
                <p>{{ number_format(($sale_box->cash - $sale_box->departure),2) }}</p>
            </div>
        </div>
    </div>

    @if ($sale_box->invoice > 0)
        <div class="box-body row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <strong class="tpdf">Detalle Facturas</strong>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Fecha</th>
                                <th>N°.F</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th>Abonos</th>
                                <th>Saldo</th>
                                <th>Ventas</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="6"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($sale_box->invoice,2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($invoices as $inv)
                                <tr>
                                    <td>{{ $inv->created_at }}</td>
                                    <td>{{ $inv->document }}</td>
                                    <td>{{ $inv->customer->name }}</td>
                                    <td>{{ $inv->status }}</td>
                                    <td class="tdder">$ {{ number_format($inv->pay,2) }}</td>
                                    <td class="tdder">$ {{ number_format($inv->balance,2) }}</td>
                                    <td class="tdder">$ {{ number_format($inv->total_pay,2) }}</td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if ($sale_box->purchase > 0)
        <div class="box-body row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <strong class="tpdf">Detalle Compras</strong>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Fecha</th>
                                <th>N°.P</th>
                                <th>Proveedor</th>
                                <th>Estado</th>
                                <th>Abonos</th>
                                <th>Saldo</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="6"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($sale_box->purchase,2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($purchases as $pur)
                                <tr>
                                    <td>{{ $pur->created_at }}</td>
                                    <td>{{ $pur->id }}</td>
                                    <td>{{ $pur->supplier->name }}</td>
                                    <td>{{ $pur->status }}</td>
                                    <td class="tdder">$ {{ number_format($pur->pay,2) }}</td>
                                    <td class="tdder">$ {{ number_format($pur->balance,2) }}</td>
                                    <td class="tdder">$ {{ number_format($pur->total_pay,2) }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if ($sale_box->out_expense > 0)
        <div class="box-body row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <strong class="tpdf">Detalle Gastos</strong>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Fecha</th>
                                <th>N°.P</th>
                                <th>Proveedor</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="3"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($exppay,2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($expenses as $exp)
                                <tr>
                                    <td>{{ $exp->created_at }}</td>
                                    <td>{{ $exp->id }}</td>
                                    <td>{{ $exp->supplier->name }}</td>
                                    <td class="tdder">$ {{ number_format($exp->total_pay,2) }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if ($sale_box->order > 0)
        <div class="box-body row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <strong class="tpdf">Detalle Pedidos</strong>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Fecha</th>
                                <th>N°.P</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th>Abonos</th>
                                <th>Saldo</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="6"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($sale_box->order,2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td class="tdder">$ {{ number_format($order->pay,2) }}</td>
                                    <td class="tdder">$ {{ number_format($order->balance,2) }}</td>
                                    <td class="tdder">$ {{ number_format($order->total_pay,2) }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if ($sale_box->ndinvoice > 0)
        <div class="box-body row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <strong class="tpdf">Detalle Notas Debito Ventas</strong>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Fecha</th>
                                <th>N°.P ND</th>
                                <th>N°. Fact</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="4"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($ndipay,2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($ndinvoices as $nd)
                                <tr>
                                    <td>{{ $nd->created_at }}</td>
                                    <td>{{ $nd->id }}</td>
                                    <td>{{ $nd->invoice }}</td>
                                    <td>{{ $nd->name }}</td>
                                    <td class="tdder">$ {{ number_format($nd->total_pay,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if ($sale_box->ncinvoice > 0)
        <div class="box-body row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <strong class="tpdf">Detalle Notas Credito Venta</strong>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Fecha</th>
                                <th>N°.NC</th>
                                <th>N° Factura</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="4"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($ncipay,2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($ncinvoices as $nc)
                                <tr>
                                    <td>{{ $nc->created_at }}</td>
                                    <td>{{ $nc->id }}</td>
                                    <td>{{ $nc->invoice }}</td>
                                    <td>{{ $nc->name }}</td>
                                    <td class="tdder">$ {{ number_format($nc->total_pay,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if ($sale_box->ndpurchase > 0)
        <div class="box-body row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <strong class="tpdf">Detalle Notas Debito Compras</strong>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Fecha</th>
                                <th>N°.P ND</th>
                                <th>N°. Fact</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="4"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($ndppay,2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($ndpurchases as $nd)
                                <tr>
                                    <td>{{ $nd->created_at }}</td>
                                    <td>{{ $nd->id }}</td>
                                    <td>{{ $nd->invoice }}</td>
                                    <td>{{ $nd->name }}</td>
                                    <td class="tdder">$ {{ number_format($nd->total_pay,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if ($sale_box->ncpurchase > 0)
        <div class="box-body row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <strong class="tpdf">Detalle Notas Credito Compras</strong>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Fecha</th>
                                <th>N°.NC</th>
                                <th>N° Factura</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="4"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($ndppay,2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($ncpurchases as $nc)
                                <tr>
                                    <td>{{ $nc->created_at }}</td>
                                    <td>{{ $nc->id }}</td>
                                    <td>{{ $nc->invoice }}</td>
                                    <td>{{ $nc->name }}</td>
                                    <td class="tdder">$ {{ number_format($nc->total_pay,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if ($sale_box->out_cash > 0)
        <div class="box-body row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <strong class="tpdf">Detalle Entregas de efectivo</strong>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Fecha</th>
                                <th>ID</th>
                                <th>Recibe Administrador</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="3"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($sum_cash_outs,2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($cashOuts as $out)
                                <tr>
                                    <td>{{ $out->created_at }}</td>
                                    <td>{{ $out->id }}</td>
                                    <td>{{ $out->name }}</td>
                                    <td class="tdder">$ {{ number_format($out->payment,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if ($sale_box->sum_cash_in > 0)
    <div class="box-body row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <strong class="tpdf">Detalle Recarga de efectivo</strong>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr class="bg-info">
                            <th>Fecha</th>
                            <th>ID</th>
                            <th>Recibe</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th  colspan="3"><p align="right">TOTAL:</p></th>
                            <th><p align="right">${{ number_format($sum_cash_ins,2) }}</p></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($cashIns as $cash)
                            <tr>
                                <td>{{ $cash->created_at }}</td>
                                <td>{{ $cash->id }}</td>
                                <td>{{ $cash->name }}</td>
                                <td class="tdder">$ {{ number_format($cash->payment,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
</main>
@endsection
