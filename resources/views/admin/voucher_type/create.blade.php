@extends('layouts.admin')
@section('title')
    Registrar tipo de comprobante |
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                Registrar tipo de comprobante
                            </h3>
                        </div>
                        {!! Form::open(['method' => 'POST', 'route' => 'voucher_types.store', 'autocomplete' => 'off']) !!}
                        {!! Form::token() !!}
                            @include('admin.voucher_type.form')
                        {!! Form::close() !!}
                    </div>
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
