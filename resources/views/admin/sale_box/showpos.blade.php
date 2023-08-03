<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('css/post_box.css') }}">
        <title>Reporte de Caja</title>
    </head>
    <body>
        <header>
            <div class="center">
                <div id="logo">
                    <img src="{{asset($company->logo) }}" alt="{{ $company->name }}" width="120px" height="60px" class="app-logo">
                </div>
            </div>

            <div class="clearfix"></div>
        </header>
        <section>
            <div class="unicos">
                <div class="cliente">
                    <p>
                        Nombre: {{ $sale_box->user->name }}:</p>
                </div>
            </div>
            @if ($sale_box->purchase > 0)
                <div class="unicos">
                    <p>REPORTE DE ARTICULOS COMPRAS</p>
                    <table>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Articulo</th>
                                <th>Cant</th>
                                <th>Precio</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($productPurchases as $produtPurchase)
                            <tr>
                                <td class="id">{{ $produtPurchase->id }}</td>
                                <td class="name">{{ $produtPurchase->name }}</td>
                                <td class="quantity">{{ $produtPurchase->stock }}</td>
                                <td class="price" align="right">${{ number_format($produtPurchase->price) }}</td>
                                <td class="subtotal" align="right">${{ number_format($produtPurchase->sale_price) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sale_box->purchase)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
            @if ($sale_box->invoice > 0)
                <div class="unicos">
                    <p>REPORTE DE ARTICULOS VENTAS</p>
                    <table>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Articulo</th>
                                <th>Cant</th>
                                <th>Precio</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($invoiceMenus as $invoiceMenu)
                            <tr>
                                <td class="id">{{ $invoiceMenu->id }}</td>
                                <td class="name">{{ $invoiceMenu->name }}</td>
                                <td class="quantity">{{ $invoiceMenu->stock }}</td>
                                <td class="price" align="right">${{ number_format($invoiceMenu->price) }}</td>
                                <td class="subtotal" align="right">${{ number_format($invoiceMenu->sale_price) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>

                            <tr>
                                <th colspan="4" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sale_box->invoice)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
            @if ($sale_box->purchase > 0)
                <div class="unicos">
                    <p>REPORTE DE COMPRAS</p>
                    <table>
                        <thead>
                            <tr>
                                <th>N°.Compra</th>
                                <th>Proveedor</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($purchases as $purchase)
                            <tr>
                                <td class="document">{{ $purchase->document }}</td>
                                <td class="third">{{ $purchase->supplier->name }}</td>
                                <td class="totals" align="right">$ {{ number_format($purchase->total_pay) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sale_box->purchase)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
            @if ($sale_box->invoice > 0)
                <div class="unicos">
                    <p>REPORTE DE FACTURAS DE VENTA</p>
                    <table>
                        <thead>
                            <tr>
                                <th>N°.Venta</th>
                                <th>Cliente</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td class="document">{{ $invoice->document }}</td>
                                <td class="third">{{ $invoice->customer->name }}</td>
                                <td class="totals" align="right">$ {{ number_format($invoice->total_pay) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sale_box->invoice)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif

            @if ($sale_box->expense > 0)
                <div class="unicos">
                    <p>REPORTE DE GASTOS</p>
                    <table>
                        <thead>
                            <tr>
                                <th>N°.Gasto</th>
                                <th>Proveedor</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($expenses as $expense)
                            <tr>
                                <td class="document">{{ $expense->document }}</td>
                                <td class="third">{{ $expense->supplier->name }}</td>
                                <td class="totals" align="right">$ {{ number_format($expense->total_pay, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sale_box->expense)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
            @if ($sale_box->order > 0)
                <div class="unicos">
                    <p>REPORTE DE COMANDAS</p>
                    <table>
                        <thead>
                            <tr>
                                <th>N°.Comanda</th>
                                <th>Mesa #</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($orders as $order)
                            <tr>
                                <td class="document">{{ $order->id }}</td>
                                <td class="third">{{ $order->restaurantTable->name }}</td>
                                <td class="totals" align="right">$ {{ number_format($order->total_pay, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sale_box->order)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif


            @if ($sum_pay_invoices > 0)
                <div class="unicos">
                    <p>REPORTE DE ABONOS A FACTURAS</p>
                    <table>
                        <thead>
                            <tr>
                                <th>N°.Factura</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($pay_invoices as $payInvoice)
                            <tr>
                                <td class="document">{{ $payInvoice->invoice->document }}</td>
                                <td class="third">{{ $payInvoice->invoice->customer->name }}</td>
                                <td class="totals" align="right">$ {{ $payInvoice->pay }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sum_pay_invoices)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
            @if ($sum_pay_purchases > 0)
                <div class="unicos">
                    <p>REPORTE DE PAGOS A COMPRAS</p>
                    <table>
                        <thead>
                            <tr>
                                <th>N°.Compra</th>
                                <th>Proveedor</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($pay_purchases as $payPurchase)
                            <tr>
                                <td class="document">{{ $payPurchase->purchase->id }}</td>
                                <td class="third">{{ $payPurchase->purchase->supplier->name }}</td>
                                <td class="totals" align="right">$ {{ $payPurchase->pay }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sum_pay_purchases)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
            @if ($sum_pay_expenses > 0)
                <div class="unicos">
                    <p>REPORTE DE PAGOS Y GASTOS</p>
                    <table>
                        <thead>
                            <tr>
                                <th>N°.Gasto</th>
                                <th>Proveedor</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($pay_expenses as $payExpense)
                            <tr>
                                <td class="document">{{ $payExpense->expense->id }}</td>
                                <td class="third">{{ $payExpense->expense->supplier->name }}</td>
                                <td class="totals" align="right">$ {{ $payExpense->pay }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sum_pay_expenses)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
            @if ($sum_cash_ins > 0)
                <div class="unicos">
                    <p>REPORTE DE ENTRADAS EFECTIVO</p>
                    <table>
                        <thead>
                            <tr>
                                <th>Autoriza</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($cashIns as $cashIn)
                            <tr>
                                <td>{{ $cashIn->name }}</td>
                                <td>$ {{ $cashIn->payment }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sum_cash_ins)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
            @if ($sum_cash_outs > 0)
                <div class="unicos">
                    <p>REPORTE DE SALIDAS EFECTIVO</p>
                    <table>
                        <thead>
                            <tr>
                                <th>Autoriza</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody class="fact">
                            @foreach ($cashOuts as $cashOut)
                            <tr>
                                <td>{{ $cashOut->name }}</td>
                                <td>$ {{ $cashOut->payment }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" ><p align="right" >TOTAL:</p></th>
                                <td><p align="right" >${{number_format($sum_cash_outs)}}</p></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
            <div class="unicos">
                <p>REPORTE DE TOTALES</p>
                <table>
                    <thead>
                        <th class="totalreportname"></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @if ($sale_box->purchase > 0)
                            <tr>
                                <th colspan="4" ><p align="left" >TOTAL COMPRAS:</p></th>
                                <td align="right"><p  ><h2>${{number_format($sale_box->purchase,2)}}</h2></td>
                            </tr>
                        @endif
                        @if ($sale_box->expense > 0)
                            <tr>
                                <th colspan="4" ><p align="left" >TOTAL GASTOS:</p></th>
                                <td align="right"><h2>${{number_format($sum_pay_expenses,2)}}</h2></td>
                            </tr>
                        @endif
                        @if ($sale_box->invoice > 0)
                            <tr>
                                <th colspan="4" ><p align="left" >TOTAL VENTAS:</p></th>
                                <td align="right"><h2>${{number_format($sale_box->invoice,2)}}</h2></td>
                            </tr>
                        @endif
                        @if ($sale_box->order > 0)
                            <tr>
                                <th colspan="4"><p align="left" >TOTAL COMANDAS:</p></th>
                                <td align="right"><h2>${{number_format($sale_box->order,2)}}</h2></td>
                            </tr>
                        @endif

                        @if ($sale_box->out_purchase > 0)
                        <tr>
                            <th colspan="4" ><p align="left" >EGRESOS COMPRAS:</p></th>
                            <td align="right"><h2>${{number_format($sale_box->out_purchase,2)}}</h2></td>
                        </tr>
                        @endif
                        @if ($sale_box->out_expense > 0)
                        <tr>
                            <th colspan="4" ><p align="left" >EGRESOS GASTOS:</p></th>
                            <td align="right"><h2>${{number_format($sale_box->out_expense,2)}}</h2></td>
                        </tr>
                        @endif
                        @if ($sale_box->in_invoice > 0)
                        <tr>
                            <th colspan="4" ><p align="left" >INGRESOS VENTAS:</p></th>
                            <td align="right"><h2>${{number_format($sale_box->in_invoice,2)}}</h2></td>
                        </tr>
                        @endif
                        @if ($sale_box->out_total > 0)
                            <tr>
                                <th colspan="4" ><p align="left" >TOTAL EGRESOS:</p></th>
                                <td align="right"><h2>${{number_format($sale_box->out_total,2)}}</h2></td>
                            </tr>
                        @endif
                        @if ($sale_box->in_total > 0)
                            <tr>
                                <th colspan="4" ><p align="left" >TOTAL INGRESOS:</p></th>
                                <td align="right"><h2>${{number_format($sale_box->in_total,2)}}</h2></td>
                            </tr>
                        @endif
                        @if ($sale_box->cash_box > 0)
                        <tr>
                            <th colspan="4" ><p align="left" >EFECTIVO INICIAL:</p></th>
                            <td align="right"><h2>${{number_format($sale_box->cash_box,2)}}</h2></td>
                        </tr>
                        @endif
                        @if ($sale_box->out_purchase_cash > 0)
                        <tr>
                            <th colspan="4" ><p align="left" >EFECTIVO COMPRAS:</p></th>
                            <td align="right"><h2>${{number_format($sale_box->out_purchase_cash,2)}}</h2></td>
                        </tr>
                        @endif
                        @if ($sale_box->out_expense_cash > 0)
                        <tr>
                            <th colspan="4" ><p align="left" >EFECTIVO GASTOS:</p></th>
                            <td align="right"><h2>${{number_format($sale_box->out_expense_cash,2)}}</h2></td>
                        </tr>
                        @endif
                        @if ($sale_box->in_invoice_cash > 0)
                        <tr>
                            <th colspan="4" ><p align="left" >EFECTIVO VENTAS:</p></th>
                            <td align="right"><h2>${{number_format($sale_box->in_invoice_cash,2)}}</h2></td>
                        </tr>
                        @endif

                        @if ($sale_box->cash > 0)
                            <tr>
                                <th colspan="4" ><p align="left" >TOTAL EFECTIVO:</p></th>
                                <td><h2>${{number_format($sale_box->cash,2)}}</h2></td>
                            </tr>
                        @endif
                        @if ($sale_box->departure > 0)
                            <tr>
                                <th colspan="4" ><p align="left" >SALIDA EFECTIVO:</p></th>
                                <td align="right"><h2>${{number_format($sale_box->departure,2)}}</h2></td>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="4" ><p align="left" >SALDO EN CAJA:</p></th>
                            <td align="right"><h2>${{number_format($sale_box->cash - $sale_box->departure ,2)}}</h2></td>
                        </tr>
                    </tbody>
                    <tfoot>


                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            Reporte cierre de Caja
        </footer>
    </body>
</html>



