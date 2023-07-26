@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Listado de Resoluciones
                <a href="resolution/create"><button class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;&nbsp; Agregar Resolucion</button></a>
                    <a href="{{ route('company.index') }}" class="btn btn-limon"><i class="fas fa-trash-restore-alt mr-2"></i>Regresar</a>

            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="resolutions">
                    <thead>
                        <tr class="bg-info">
                            <th>Id</th>
                            <th>Compañia</th>
                            <th>Documento</th>
                            <th>Resolucion</th>
                            <th>Pref.</th>
                            <th>Fecha</th>
                            <th>Numeracion</th>
                            <th>Generadas</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Clave Tecnica</th>
                            <th>estado</th>
                            <th>Acciones</th>
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
        $('#resolutions').DataTable(
        {
            responsive: true,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: '{{ route('resolution.index') }}',
            columns:
            [
                {data: 'id'},
                {data: 'company'},
                {data: 'document'},
                {data: 'resolution'},
                {data: 'prefix'},
                {data: 'resolution_date'},
                {data: 'numeration'},
                {data: 'consecutive'},
                {data: 'start_date'},
                {data: 'end_date'},
                {data: 'technical_key'},
                {data: 'status'},
                {data: 'edit'},
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





