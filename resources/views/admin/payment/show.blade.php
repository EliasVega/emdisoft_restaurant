@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <a href="{{ route('payment.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
                <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="supplier">Proveedor</label>
                <p>{{ $payments->supplier->name }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="branch">Sucursal</label>
                <p>{{ $payments->branch->name }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="user">Recibido</label>
                <p>{{ $payments->user->name }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="origin">Origen</label>
                <p>{{ $payments->origin }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="destination">Origen</label>
                <p>{{ $payments->origin }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="pay">Abono</label>
                <p>{{ number_format($payments->pay, 2) }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="balance">Saldo Actual</label>
                <p>{{ number_format($payments->balance, 2) }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="date">Fecha</label>
                <p>{{ $payments->created_at }}</p>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="note">Nota</label>
                <p>{{ $payments->note }}</p>
            </div>
        </div>
    </div>
    <div class="box-body row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <strong class="tpdf">Detalle de Abonos</strong>

            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-6">
                <a href="{{ route('payment.index') }}" class="btn btn-celeste"><i class="fa fa-plus mr-2"></i>Regresar</a>

        </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Medio de Pago</th>
                                <th>Banco</th>
                                <th>Tarjeta</th>
                                <th>Transaccion</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="4"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ number_format($payments->pay, 2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($paymentPaymentMethods as $pp)
                                <tr>
                                    <td>{{ $pp->nameM }}</td>
                                    <td>{{ $pp->nameB }}</td>
                                    <td>{{ $pp->nameT }}</td>
                                    <td>{{ $pp->transaction }}</td>
                                    <td class="tdder">$ {{ number_format($pp->payment, 2) }}</td>
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
