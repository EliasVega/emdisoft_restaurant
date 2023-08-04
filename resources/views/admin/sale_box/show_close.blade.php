@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <a href="{{ route('sale_box.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
            <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <p> <Strong>Responsable:</Strong>  {{ $sale_box->user->name }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="nombre">Caja #</label>
                <p>{{ $sale_box->id }}</p>
            </div>
        </div>
        @if ($sale_box->cash_box > 0)
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="cash_open">Efectivo Inicial</label>
                    <p>${{ number_format($sale_box->cash_box,2) }}</p>
                </div>
            </div>
        @endif
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="open">Abierta</label>
                <p>{{ $sale_box->created_at }}</p>
            </div>
        </div>
        @if ($sale_box->status == 'close')
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="close">Cerrada</label>
                    <p>{{ $sale_box->updated_at }}</p>
                </div>
            </div>
        @else
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="close"><strong>Caja Activa</strong></label>
                </div>
            </div>
        @endif
        @if ($sale_box->purchase > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="abono">Total Compras</label>
                    <p>${{ number_format($sale_box->purchase,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->out_purchase > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="abono">Egreso X Compras</label>
                    <p>${{ number_format($sale_box->out_purchase,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->out_purchase_cash > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="in_purchase_cash">Compras En Efectivo</label>
                    <p>${{ number_format($sale_box->out_purchase_cash,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->expense > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="in_invoice_cash">Total Gastos</label>
                    <p>${{ number_format($sale_box->expense,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->out_expense > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="abono">Salida X Gastos</label>
                    <p>${{ number_format($sale_box->out_expense,2) }}</p>
                </div>
            </div>
        @endif

        @if ($sale_box->out_expense_cash > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="in_invoice_cash">Gastos Efectivo</label>
                    <p>${{ number_format($sale_box->out_expense_cash,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->invoice > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="abono">Total ventas</label>
                    <p>${{ number_format($sale_box->invoice,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->in_invoice > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="abono">Ingresos X ventas</label>
                    <p>${{ number_format($sale_box->in_invoice,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->in_invoice_cash > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="in_invoice_cash">Ventas Efectivo</label>
                    <p>${{ number_format($sale_box->in_invoice_cash,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->order > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="in_order_cash">Total Comandas</label>
                    <p>${{ number_format($sale_box->order,2) }}</p>
                </div>
            </div>
        @endif

        @if ($sale_box->cash > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="in_pay_cash">INGRESOS EFECTIVO</label>
                    <p>${{ number_format($sale_box->cash,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->departure > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="cash_out">SALIDA EFECTIVO</label>
                    <p>${{ number_format($sale_box->departure,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->cash - $sale_box->departure != 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="balance">EFECTIVO EN CAJA</label>
                    <p>${{ number_format($sale_box->cash - $sale_box->departure,2) }}</p>
                </div>
            </div>
        @endif
        @if ($sale_box->in_total > 0)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="pay">TOTAL INGRESOS</label>
                    <p>${{ number_format($sale_box->in_total,2) }}</p>
                </div>
            </div>
        @endif
    </div>
    <div class="box-body row">
        @if ($sale_box->purchase > 0)
            <div class="box-body row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <strong class="tpdf">Articulos Comprados</strong>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>id</th>
                                    <th>Producto</th>
                                    <th>cantidad</th>
                                    <th>inc</th>
                                    <th>subtotal</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th  colspan="3"><p align="right">TOTALES:</p></th>
                                    <th><p align="right">${{ number_format($incTotalPurchases,2) }}</p></th>
                                    <th><p align="right">${{ number_format($sumSubtotalPurchases,2) }}</p></th>
                                    <th><p align="right">${{ number_format($incTotalPurchases + $sumSubtotalPurchases,2) }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($productPurchases as $produtPurchase)
                                    <tr>
                                        <td>{{ $produtPurchase->id }}</td>
                                        <td>{{ $produtPurchase->name }}</td>
                                        <td>{{ $produtPurchase->stock }}</td>
                                        <td class="tdder">$ {{ number_format($produtPurchase->price,2) }}</td>
                                        <td class="tdder">$ {{ number_format($produtPurchase->salePrice,2) }}</td>
                                        <td class="tdder">$ {{ number_format($produtPurchase->price + $produtPurchase->salePrice,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($sale_box->invoice > 0)
            <div class="box-body row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <strong class="tpdf">Articulos Vendidos</strong>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>id</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Iva</th>
                                    <th>Subtotal</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th  colspan="3"><p align="right">TOTALES:</p></th>
                                    <th><p align="right">${{ number_format($incTotalInvoices,2) }}</p></th>
                                    <th><p align="right">${{ number_format($sumSubtotalInvoices,2) }}</p></th>
                                    <th><p align="right">${{ number_format($incTotalInvoices + $sumSubtotalInvoices,2) }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($invoiceMenus as $invoiceMenu)
                                    <tr>
                                        <td>{{ $invoiceMenu->id }}</td>
                                        <td>{{ $invoiceMenu->name }}</td>
                                        <td>{{ $invoiceMenu->stock }}</td>
                                        <td class="tdder">$ {{ number_format($invoiceMenu->price,2) }}</td>
                                        <td class="tdder">$ {{ number_format($invoiceMenu->salePrice,2) }}</td>
                                        <td class="tdder">$ {{ number_format($invoiceMenu->price + $invoiceMenu->salePrice,2) }}</td>
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
                        <strong class="tpdf">Detalle de Compras</strong>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>Fecha</th>
                                    <th>N°.F</th>
                                    <th>Proveedor</th>
                                    <th>Estado</th>
                                    <th>Abonos</th>
                                    <th>Saldo</th>
                                    <th>Compras</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th  colspan="4"><p align="right">TOTAL:</p></th>
                                    <th><p align="right">${{ number_format($purchase_pay,2) }}</p></th>
                                    <th><p align="right">${{ number_format($purchase_balance,2) }}</p></th>
                                    <th><p align="right">${{ number_format($sale_box->purchase,2) }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($purchases as $purchase)
                                    <tr>
                                        <td>{{ $purchase->created_at }}</td>
                                        <td>{{ $purchase->document }}</td>
                                        <td>{{ $purchase->supplier->name }}</td>
                                        <td>{{ $purchase->status }}</td>
                                        <td class="tdder">$ {{ number_format($purchase->pay,2) }}</td>
                                        <td class="tdder">$ {{ number_format($purchase->balance,2) }}</td>
                                        <td class="tdder">$ {{ number_format($purchase->total_pay,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($sale_box->expense > 0)
            <div class="box-body row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <strong class="tpdf">Detalle de Gastos</strong>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>Fecha</th>
                                    <th>N°.G</th>
                                    <th>Proveedor</th>
                                    <th>Abonos</th>
                                    <th>Saldo</th>
                                    <th>Compras</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th  colspan="3"><p align="right">TOTAL:</p></th>
                                    <th><p align="right">${{ number_format($expense_pay,2) }}</p></th>
                                    <th><p align="right">${{ number_format($expense_balance,2) }}</p></th>
                                    <th><p align="right">${{ number_format($sale_box->expense,2) }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->created_at }}</td>
                                        <td>{{ $expense->document }}</td>
                                        <td>{{ $expense->supplier->name }}</td>
                                        <td class="tdder">$ {{ number_format($expense->pay,2) }}</td>
                                        <td class="tdder">$ {{ number_format($expense->balance,2) }}</td>
                                        <td class="tdder">$ {{ number_format($expense->total_pay,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($sale_box->invoice > 0)
            <div class="box-body row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <strong class="tpdf">Detalle de Ventas</strong>
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
                                    <th  colspan="4"><p align="right">TOTAL:</p></th>
                                    <th><p align="right">${{ number_format($invoice_pay,2) }}</p></th>
                                    <th><p align="right">${{ number_format($invoice_balance,2) }}</p></th>
                                    <th><p align="right">${{ number_format($sale_box->invoice,2) }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->created_at }}</td>
                                        <td>{{ $invoice->document }}</td>
                                        <td>{{ $invoice->customer->name }}</td>
                                        <td>{{ $invoice->status }}</td>
                                        <td class="tdder">$ {{ number_format($invoice->pay,2) }}</td>
                                        <td class="tdder">$ {{ number_format($invoice->balance,2) }}</td>
                                        <td class="tdder">$ {{ number_format($invoice->total_pay,2) }}</td>
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
                        <strong class="tpdf">Detalle Comandas</strong>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>Fecha</th>
                                    <th>Comanda</th>
                                    <th>Estado</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th  colspan="3"><p align="right">TOTAL:</p></th>
                                    <th><p align="right">${{ number_format($sale_box->order,2) }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td class="tdder">$ {{ number_format($order->total_pay,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if ($sale_box->in_invoice > 0)
            <div class="box-body row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <strong class="tpdf">Detalle Abonos a Ventas</strong>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>Fecha</th>
                                    <th>ID</th>
                                    <th>N° Factura</th>
                                    <th>Cliente</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th  colspan="4"><p align="right">TOTAL:</p></th>
                                    <th><p align="right">${{ number_format($sum_pay_invoices,2) }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($pay_invoices as $pay_invoice)
                                    <tr>
                                        <td>{{ $pay_invoice->created_at }}</td>
                                        <td>{{ $pay_invoice->id }}</td>
                                        <td>{{ $pay_invoice->invoice->document }}</td>
                                        <td>{{ $pay_invoice->invoice->customer->name }}</td>
                                        <td class="tdder">$ {{ number_format($pay_invoice->pay,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($sale_box->out_purchase > 0)
            <div class="box-body row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <strong class="tpdf">Detalle Pagos por Compras</strong>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>Fecha</th>
                                    <th>ID</th>
                                    <th>N° Factura</th>
                                    <th>Proveedor</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th  colspan="4"><p align="right">TOTAL:</p></th>
                                    <th><p align="right">${{ number_format($sum_pay_purchases,2) }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($pay_purchases as $pay_purchase)
                                    <tr>
                                        <td>{{ $pay_purchase->created_at }}</td>
                                        <td>{{ $pay_purchase->id }}</td>
                                        <td>{{ $pay_purchase->purchase->document }}</td>
                                        <td>{{ $pay_purchase->purchase->supplier->name }}</td>
                                        <td class="tdder">$ {{ number_format($pay_purchase->pay,2) }}</td>
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
                        <strong class="tpdf">Detalle Pagos por Gastos</strong>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr class="bg-info">
                                    <th>Fecha</th>
                                    <th>ID</th>
                                    <th>N° Factura</th>
                                    <th>Proveedor</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th  colspan="4"><p align="right">TOTAL:</p></th>
                                    <th><p align="right">${{ number_format($sum_pay_expenses,2) }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($pay_expenses as $pay_expense)
                                    <tr>
                                        <td>{{ $pay_expense->created_at }}</td>
                                        <td>{{ $pay_expense->id }}</td>
                                        <td>{{ $pay_expense->expense->document }}</td>
                                        <td>{{ $pay_expense->expense->supplier->name }}</td>
                                        <td class="tdder">$ {{ number_format($pay_expense->pay,2) }}</td>
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
                                    <th><p align="right">${{ $sum_pay_cashOuts }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($cash_outs as $cas)
                                    <tr>
                                        <td>{{ $cas->created_at }}</td>
                                        <td>{{ $cas->id }}</td>
                                        <td>{{ $cas->name }}</td>
                                        <td class="tdder">$ {{ $cas->payment }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($sale_box->in_cash > 0)
            <div class="box-body row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <strong class="tpdf">Detalle Ingresos de efectivo</strong>
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
                                    <th><p align="right">${{ $sum_pay_cashIns }}</p></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($cash_ins as $cas)
                                    <tr>
                                        <td>{{ $cas->created_at }}</td>
                                        <td>{{ $cas->id }}</td>
                                        <td>{{ $cas->name }}</td>
                                        <td class="tdder">$ {{ $cas->payment }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>
@endsection
