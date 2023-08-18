@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h4 class="box-title">Agregar Comanda
                    <a href="{{ route('order.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
                    <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
                </h4>
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
            <form action="{{route('order.store')}}" method="POST" class="formulario">
                {{csrf_field()}}
                <div class="row m-1">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" id="createTable">
                        @include('admin/order.form_table')
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" id="homeOrder">
                        @include('admin/order.form_home_order')
                    </div>

                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        @include('admin/order.form_order')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Inicio del modal cliente-->
@include('admin/order.customer')
<!--Fin del modal-->
@endsection
@section('scripts')
    @include('admin/order.script')
@endsection
