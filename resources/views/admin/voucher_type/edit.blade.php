@extends('layouts.admin')
@section('title')
    Editar tipo de comprobante |
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                Editar tipo de comprobante
                            </h3>
                        </div>
                        {!! Form::open(['method' => 'PATCH', 'route' => ['voucher_type.update', $voucherType->id], 'autocomplete' => 'off']) !!}
                        {!! Form::token() !!}
                            @include('admin.voucher_type.form')
                        {!! Form::close() !!}
                    </div>
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
