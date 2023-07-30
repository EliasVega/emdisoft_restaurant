@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4>Listado de Cajas <a href="sale_box/create" class="btn btn-celeste btn-sm mb-2"><i class="fa fa-plus mr-2"></i> Agregar Caja</a>
                    <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
                        <a href="{{ route('cash_out.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>salidas efectivo</a>
                        <a href="{{ route('cash_in.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Entrada Efectivo</a>
                </h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="sale_boxes">
                    <thead>
                        <tr class="bg-info">
                            <th>Id</th>
                            <th>Usuario</th>
                            <th>Sucursal</th>
                            <th>Abre</th>
                            <th>Ing. Efectivo</th>
                            <th>Sal. Efectivo</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha</th>
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
        $('#sale_boxes').DataTable(
        {
            responsive: true,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: '{{ route('sale_box.index') }}',
            order: [[ 0, "desc" ]],
            columns:
            [
                {data: 'id'},
                {data: 'user'},
                {data: 'branch'},
                {data: 'cash_box', className: 'dt-body-right', render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: 'cash', className: 'dt-body-right', render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: 'departure', className: 'dt-body-right', render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: 'total', className: 'dt-body-right', render: $.fn.dataTable.render.number('.', ',', 2)},
                {data: 'status'},
                {data: 'created_at'},
                {data: 'btn'},
            ],
            dom: 'Blfrtips',
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



