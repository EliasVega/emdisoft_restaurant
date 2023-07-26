@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                    <a href="{{ route('purchase.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
                    <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
            </div>
        </div>


        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="id">COMPRA #</label>
                <h6>{{ $purchase->id }}</h6>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="company">SUCURSAL</label>
                <h6>{{ $purchase->branch->name }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="payment_form">FORMA DE PAGO</label>
                <h6>{{ $purchase->paymentForm->name }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="balance">SALDO A PAGAR</label>
                <h6>{{ number_format($purchase->balance, 2) }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="nombre">PROVEEDOR</label>
                <h6>{{ $purchase->supplier->name }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="document">DOCUMENTO No.</label>
                <h6>{{ $purchase->document }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="Fecha">FECHA EMISION</label>
                <h6>{{ date('d-m-Y', strtotime($purchase->created_at)) }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="due_date">VENCE</label>
                <h6>{{ $purchase->due_date }}</h6>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="company">RESPONSABLE</label>
                <h6>{{ $purchase->user->name }}</h6>
            </div>
        </div>
    </div><br>
    <div class="box-body row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <h4>Detalle de la Compra</h4>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio ($)</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="3"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($purchase->total, 2) }}</p></th>
                            </tr>

                            <tr>
                                <th colspan="3"><p align="right">TOTAL IVA:</p></th>
                                <th><p align="right">${{ number_format($purchase->total_iva, 2) }}</p></th>
                            </tr>
                            @if ($purchase->retention > 0)
                                <tr>
                                    <th colspan="3"><p align="right">RETENCION:</p></th>
                                    <th><p align="right">${{ number_format($purchase->retention, 2) }}</p></th>
                                </tr>
                                <tr>
                                    <th colspan="3"><p align="right">TOTAL - DESC:</p></th>
                                    <th><p align="right">${{ number_format($purchase->total_pay - $purchase->retention, 2) }}</p></th>
                                </tr>

                            @endif
                            <tr>
                                <th  colspan="3"><p align="right">TOTAL PAGAR:</p></th>
                                <th><p align="right">${{ number_format($purchase->total_pay, 2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($product_purchases as $PP)
                                <tr>
                                    <td>{{ $PP->product->name }}</td>
                                    <td>{{ $PP->quantity }}</td>
                                    <td class="tdder">${{ number_format($PP->price,2) }}</td>
                                    <td class="tdder">{{ number_format($PP->subtotal,2) }}</td>
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
