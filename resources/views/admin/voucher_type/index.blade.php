@extends('layouts.admin')
@section('title')
    Tipos de comprobantes |
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Listado de tipos de comprobantes
                            </h3>
                        </div>
                        <div class="card-body">
                            @include('includes.alerts.success_message')
                            @include('includes.alerts.error_message')
                            <div class="row mb-2">
                                <div class="col-12 col-md-6">
                                    <a class="btn btn-success d-block d-md-inline-block mb-3 mb-md-0" href="{{ route('voucher_types.create') }}">
                                        Registrar tipo de comprobante
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed w-100" id="voucher_types">
                                    <thead class="bg-light">
                                    <tr>
                                        <th hidden>Id</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Secuencial</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.Main content -->
    @push('scripts')
        <script>
            $(document).ready(function () {
                var table = $('#voucher_types').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('voucher_types.index') }}",
                    order: [[ 0, "desc" ]],
                    columns: [
                        { data: 'id', visible:false, searchable:false },
                        { data: 'code' },
                        { data: 'name' },
                        { data: 'consecutive' },
                        { data: 'state' },
                        { data: 'actions', orderable:false, searchable:false },
                    ],
                    dom: 'lBfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [ 1, 2, 3, 4 ]
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [ 1, 2, 3, 4 ]
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: [ 1, 2, 3, 4 ]
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [ 1, 2, 3, 4 ]
                            }
                        },
                    ],
                });
                setInterval(function () {
                    table.ajax.reload();
                }, 300000);
            });
        </script>
    @endpush
@endsection
