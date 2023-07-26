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
                <h4>{{ $ncinvoices->name }}</h4>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="company">SUCURSAL</label>
                <h4>{{ $ncinvoices->nameB }}</h4>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="nombre">CLIENTE</label>
                <h4>{{ $ncinvoices->nameC }}</h4>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="nc#">NOTA CREDITO N°.</label>
                <h4>{{ $ncinvoices->id }}</h4>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="invoice">APLICA FACTURA No.</label>
                <h4>{{ $ncinvoices->nf }}</h4>
            </div>
        </div>

        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="form-control-label" for="Fecha">FECHA EMISION</label>
                <h4>{{ $ncinvoices->created_at }}</h4>
            </div>
        </div>

    </div><br>
    <div class="box-body row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <h3>Detalle de la Nota Credito
                        <a href="{{ route('ncinvoice.index') }}" class="btn btn-limon"><i class="fas fa-undo-alt mr-2"></i>Regresar</a></h3>
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
                                <th><p align="right">${{ $ncinvoices->total }}</p></th>
                            </tr>

                            <tr>
                                <th colspan="3"><p align="right">TOTAL IVA:</p></th>
                                <th><p align="right">${{ $ncinvoices->total_iva }}</p></th>
                            </tr>

                            <tr>
                                <th  colspan="3"><p align="right">TOTAL PAGAR:</p></th>
                                <th><p align="right">${{ $ncinvoices->total_pay }}</p></th>
                            </tr>

                        </tfoot>
                        <tbody>
                            @foreach($ncinvoice_products as $nc)
                                <tr>
                                    <td>{{ $nc->name }}</td>
                                    <td>${{ $nc->price }}</td>
                                    <td>{{ $nc->quantity }}</td>
                                    <td>${{ number_format($nc->quantity*$nc->price,2) }}</td>
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
