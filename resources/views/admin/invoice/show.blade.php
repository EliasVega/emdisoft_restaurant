@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="company">RESPONSABLE</label>
                <h6>{{ $invoice->customer->name }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="company">SUCURSAL</label>
                <h6>{{ $invoice->branch->name }}</h6>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="paymentForm">FORMA DE PAGO</label>
                <h6>{{ $invoice->paymentForm->name }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="paymentMethod">MEDIO DE PAGO</label>
                <h6>{{ $invoice->paymentMethod->name }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="nombre">CLIENTE</label>
                <h6>{{ $invoice->customer->name }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="invoice">FACTURA No.</label>
                <h6>{{ $invoice->id }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="Fecha">FECHA EMISION</label>
                <h6>{{ date('d-m-Y', strtotime($invoice->created_at)) }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="company">RESPONSABLE</label>
                <h6>{{ $invoice->user->name }}</h6>
            </div>
        </div>
        @if ($invoice->order->restaurant_table_id == 1)
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="company">NOMBRE</label>
                    <h6>{{ $invoice->order->homeOrder->name }}</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="company">DIRECCION</label>
                    <h6>{{ $invoice->order->homeOrder->address }}</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="company">TELEFONO</label>
                    <h6>{{ $invoice->order->homeOrder->phone }}</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="form-control-label" for="company">DOMICILIARIO</label>
                    <h6>{{ $invoice->order->homeOrder->domicialiary }}</h6>
                </div>
            </div>
        @endif
    </div><br>
    <div class="box-body row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <h4>Detalle de la venta
                        <a href="{{ route('invoice.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
                        <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
                    </h4>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Menu</th>
                                <th>Precio ($)</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tfoot>

                            <tr>
                                <th  colspan="3"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($invoice->total, 2) }}</p></th>
                            </tr>

                            <tr>
                                <th colspan="3"><p align="right">TOTAL INC:</p></th>
                                <th><p align="right">${{ number_format($invoice->total_inc, 2) }}</p></th>
                            </tr>
                            <tr>
                                <th  colspan="3"><p align="right">TOTAL PAGAR:</p></th>
                                <th><p align="right">${{ number_format($invoice->total_pay, 2) }}</p></th>
                            </tr>

                        </tfoot>
                        <tbody>
                            @foreach($invoiceMenus as $invoiceMenu)
                                <tr>
                                    <td>{{ $invoiceMenu->menu->name }}</td>
                                    <td>${{ $invoiceMenu->price }}</td>
                                    <td class="tdder">{{ $invoiceMenu->quantity }}</td>
                                    <td class="tdder">{{ number_format($invoiceMenu->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
