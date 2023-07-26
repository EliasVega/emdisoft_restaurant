@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="company">RESPONSABLE</label>
                <h4>{{ $ndpurchase->user->name }}</h4>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="company">SUCURSAL</label>
                <h4>{{ $ndpurchase->branch->name }}</h4>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="nombre">PROVEEDOR</label>
                <h4>{{ $ndpurchase->supplier->name }}</h4>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="nc#">NOTA DEBITO N°.</label>
                <h4>{{ $ndpurchase->id }}</h4>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="purchase">APLICA COMPRAQ No.</label>
                <h4>{{ $ndpurchase->purchase }}</h4>
            </div>
        </div>

        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="Fecha">FECHA EMISION</label>
                <h4>{{ $ndpurchase->created_at }}</h4>
            </div>
        </div>

    </div><br>
    <div class="box-body row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <h3>Detalle de la Nota DEBITO
                        <a href="{{ route('ndpurchase.index') }}" class="btn btn-redeco"><i class="fas fa-undo-alt mr-2"></i>Regresar</a></h3>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th>Producto</th>
                                <th>Precio ($)</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tfoot>

                            <tr>
                                <th  colspan="3"><p align="right">TOTAL:</p></th>
                                <th><p align="right">${{ $ndpurchase->total }}</p></th>
                            </tr>

                            <tr>
                                <th colspan="3"><p align="right">TOTAL IVA:</p></th>
                                <th><p align="right">${{ $ndpurchase->total_iva }}</p></th>
                            </tr>

                            <tr>
                                <th  colspan="3"><p align="right">TOTAL PAGAR:</p></th>
                                <th><p align="right">${{ $ndpurchase->total_pay }}</p></th>
                            </tr>

                        </tfoot>
                        <tbody>
                            @foreach($ndpurchaseProducts as $ndpurchaseProduct)
                                <tr>
                                    <td>{{ $ndpurchaseProduct->product->name }}</td>
                                    <td>${{ $ndpurchaseProduct->price }}</td>
                                    <td>{{ $ndpurchaseProduct->quantity }}</td>
                                    <td>${{ number_format($ndpurchaseProduct->quantity * $ndpurchaseProduct->price,2) }}</td>
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
