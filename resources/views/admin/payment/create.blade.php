@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h4>Agregar Pago Anticipado
                    <a href="{{ route('payment.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
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
            {!! Form::open(['method' => 'POST', 'route' => 'payment.store', 'autocomplete' => 'off']) !!}
            {!! Form::token() !!}

                <div class="row m-1">
                    @include('admin/payment.form')
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @include('admin/payment.script')
@endsection
