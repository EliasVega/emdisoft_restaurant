@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
REPORTE GENERAL DE CARTERA
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Listado de Ventas
                <a href="{{ route('company.index') }}" class="btn btn-limon"><i class="fas fa-undo-alt mr-2"></i>Regresar</a></h3>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="portfolio">Cartera</label>
                <a href="{{ route('portfolio') }}" class="btn btn-gris">{{ $portfolio }}</a>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="past_due_portfolio">Cartera Vencida</label>
                <a href="{{ route('past_due_portfolio') }}" class="btn btn-gris">{{ $past_due_portfolio }}</a>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="portfolio_thirty">Cartera + 30 dias</label>
                <a href="{{ route('portfolio_thirty') }}" class="btn btn-gris">{{ $portfolio_thirty }}</a>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="portfolio_sixty">Cartera + 60 dias</label>
                <a href="{{ route('portfolio_sixty') }}" class="btn btn-gris">{{ $portfolio_sixty }}</a>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="reports">
                    <thead>
                        <tr class="bg-info">
                            <th>Id</th>
                            <th>Vendedor</th>
                            <th>Sede</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Saldo</th>
                            <th>Fecha</th>
                            <th>Vence</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@push('scripts')
    <script type="text/javascript">
    $(document).ready(function ()
    {
        $('#reports').DataTable({
            responsive: true,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: '{{ route('portfolio') }}',
            columns:
            [
                {data: 'id'},
                {data: 'name'},
                {data: 'nameB'},
                {data: 'nameC'},
                {data: 'total_pay'},
                {data: 'balance'},
                {data: 'created_at'},
                {data: 'due_date'},
                {data: 'status'},
            ],
            dom: '<"pull-left"B><"pull-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
            buttons:
            [
                'copy', 'csv', 'excel', 'print',
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
            lengthMenu:
            [
                [
                    10, 25, 50, -1
                ],
                [
                    '10 rows', '25 rows', '50 rows', 'Show all'
                ]
            ],
            "language":{
                "processing": "Cargando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "loadingRecords": "Cargando...",
                "paginate":{
                    "next": "Siguiente",
                    "previous": "Anterior",
                },
                "buttons":{
                    "copy": "Copiar",
                    "print": "Imprimir"
                },
            },
        });


    });
    </script>
@endpush
</main>
@endsection




