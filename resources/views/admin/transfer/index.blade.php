@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4>Listado de Traslados  <a href="transfer/create"><button class="btn btn-celeste"><i class="fa fa-plus"></i>&nbsp;&nbsp; Agregar Traslado</button></a>
                <a href="{{ route('branch.index') }}" class="btn btn-redeco"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
                <a href="{{ route('product_branch.index') }}" class="btn btn-gris"><i class="fas fa-undo-alt mr-2"></i>Ver Movimientos</a>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="transfer">
                    <thead>
                        <tr class="bg-info">
                            <th>Id</th>
                            <th>Origen</th>
                            <th>destino</th>
                            <th>Responsable</th>
                            <th>Fecha</th>
                            <th>Ver</th>
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
        $('#transfer').DataTable(
        {
            responsive: true,
            autoWidth: false,
            processing: true,
            serverSide: true,
            info: true,
            stateSave: true,
            ajax: '{{ route('transfer.index') }}',
            order: [[ 0, "desc" ]],
            columns:
            [
                {data: 'id'},
                {data: 'origin_branch'},
                {data: 'branch'},
                {data: 'name'},
                {data: 'created_at'},
                {data: 'btn'},
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
            "language":
            {
                "processing": "Cargando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "loadingRecords": "Cargando...",
                "paginate":
                {
                    "next": "Siguiente",
                    "previous": "Anterior",
                },

                "buttons":
                {
                    "copy": "Copiar",
                    "print": "Imprimir"
                },
            }
        });
    });
</script>
@endpush
</main>
@endsection



