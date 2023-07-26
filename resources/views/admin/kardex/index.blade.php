@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<main class="main">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="row input-daterange input-group" id="datepicker">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <input type="text" name="start" id="start" class="form-control" value="2021-01-01" placeholder="Fecha Inicial"/>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <input type="text" name="end" id="end" class="form-control" value="" placeholder="Fecha Final"/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a type="button" name="filter" id="filter" class="btn btn-lila">Filtrar</a>
                            <a type="button" name="refresh" id="refresh" class="btn btn-ver">Refrescar</a>
                            <a href="{{ route('product.index') }}" class="btn btn-primary ml-3"><i class="fas fa-undo-alt mr-3"></i>Regresar </a>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="kardexes">
                    <thead>
                        <tr class="bg-info">
                            <th>Pro.ID</th>
                            <th>Sucursal</th>
                            <th>Operacion</th>
                            <th>Fecha</th>
                            <th>Oper.#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
        $(document).ready(function (){
            $(".daterange").datepicker({
                todayBtn: "linked",
                //format: "yyyy-mm-dd",
                autoclose: true,
            });
            load_data();
            function load_data(start = '', end = ''){
                $('#kardexes').DataTable({
                    responsive: true,
                    autoWidth: false,
                    processing: true,
                    //serverSide: true,
                    //ajax: '{{ route('kardex.index') }}',
                    ajax:{
                        url: '{{ route('kardex.index') }}',
                        data: {
                            start: start,
                            end: end,
                        },
                    },
                    columns:[
                        {data: 'idP'},
                        {data: 'branch'},
                        {data: 'operation'},
                        {data: 'created_at'},
                        {data: 'number'},
                        {data: 'product'},
                        {data: 'quantity'},
                        {data: 'stock'},
                    ],
                    dom: '<"pull-left"B><"pull-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
                    buttons:[
                        'copy', 'csv', 'excel', 'print',
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LEGAL'
                        },
                    ],
                    lengthMenu:[
                        [
                            10, 25, 50, -1
                        ],
                        [
                            '10 rows', '25 rows', '50 rows', 'Show all'
                        ],
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
                        "buttons":
                        {
                            "copy": "Copiar",
                            "print": "Imprimir"
                        },
                    },
                });
            }
            $('#filter').click(function () {
                start = $('#start').val();
                end = $('#end').val();
                if (start != '' && end != '') {
                    $('#kardexes').DataTable().destroy();
                    load_data(start, end);
                } else {
                    alert('Los campos de fecha son requeridos.');
                }
            });
            $('#refresh').click(function () {
                $('#start').val('');
                $('#end').val();
                $('#kardexes').DataTable().destroy();
                load_data();
            });
        });
        </script>
    @endpush
</main>
@endsection

