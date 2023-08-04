@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h5 class="box-title">Agregar Venta
                    <a href="{{ route('invoice.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
                    <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
                </h5>
            </div>
            @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{route('invoice.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row m-1">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @include('admin/invoice.form_invoice')
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        @include('admin/invoice.form_table')
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        @include('admin/invoice.form_pay')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Inicio del modal cliente-->
@include('admin/invoice.customer')
<!--Fin del modal-->
@endsection
@section('scripts')
    @include('admin/invoice.script')
    @include('admin/invoice.script_pay')
@endsection
