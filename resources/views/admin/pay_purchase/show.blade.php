@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="name">CLIENTE</label>
                <p>{{ $payPurchase->purchase->supplier->name }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="order">Compra #</label>
                <p><strong>{{ $payPurchase->purchase->id }}</strong></p>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="abono">ABONO</label>
                <p>{{ number_format($payPurchase->pay, 2) }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="vece">VENCE</label>
                <p>{{ $payPurchase->purchase->due_date }}</p>
            </div>
        </div>
    </div>
    <div class="box-body row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <h4>Detalle de Abonos</h4>

            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-2">
                <a href="{{ route('pay_purchase.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
                <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>

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
                                <th><p align="right">${{ number_format($payPurchase->pay, 2) }}</p></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($payPurchase_paymentMethods as $pp)
                                <tr>
                                    <td>{{ $pp->paymentMethod->name }}</td>
                                    <td>{{ $pp->bank->name }}</td>
                                    <td>{{ $pp->card->name }}</td>
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
