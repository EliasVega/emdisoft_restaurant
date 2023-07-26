@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    @if (Auth::user()->role_id != 5)
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3>Listado de Sucursales
                    <a href="branch/create"><button class="btn btn-celeste"><i class="fa fa-plus mr-2"></i> Agregar Sucursal</button></a>
                    <a href="{{ route('product.index') }}" class="btn btn-celeste"><i class="fas fa-undo-alt mr-2"></i>Inventario General</a>
                </h3>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="branches">
                    <thead>
                        <tr class="bg-info">
                            <th>O.P</th>
                            <th>F.V</th>
                            <th>BOX</th>
                            <th>O.C</th>
                            <th>F.C</th>
                            <th>F.G</th>
                            <th>PRO</th>
                            <th>TRF</th>
                            <th>Id</th>
                            <th>Departamento</th>
                            <th>Municipio</th>
                            <th>Sucursal</th>
                            <th>Nit</th>
                            <th>Edit</th>
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
        $('#branches').DataTable(
        {
            responsive: true,
            autoWidth: false,
            processing: true,
            serverSide: true,
            info: true,
            stateSave: true,
            ajax: '{{ route('branch.index') }}',
            columns:
            [
                {data: 'order'},
                {data: 'invoice'},
                {data: 'box'},
                {data: 'prePurchase'},
                {data: 'purchase'},
                {data: 'expense'},
                {data: 'product'},
                {data: 'transfer'},
                {data: 'id'},
                {data: 'department'},
                {data: 'municipality'},
                {data: 'name'},
                {data: 'company'},
                {data: 'edit'},
                {data: 'show'},
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
