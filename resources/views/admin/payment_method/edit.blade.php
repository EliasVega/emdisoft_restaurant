@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Editar Medio de Pago:&nbsp;&nbsp;&nbsp;&nbsp;  {{ $payment_method->name }}</h3>
            </div>
            @if (count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                         @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!!Form::model($payment_method, ['method'=>'PATCH','route'=>['payment_method.update', $payment_method->id]])!!}
            {!!Form::token()!!}
                <div class="box-body row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label for="code">Codigo</label>
                            <input type="number" name="code" class="form-control" value="{{ $payment_method->code }}">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="name">Medio de Pago</label>
                            <input type="text" name="name" class="form-control" value="{{ $payment_method->name }}">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-pencil-alt"></i>&nbsp; Actualizar</button>
                            <a href="{{ url('payment_method') }}" class="btn btn-danger"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
                        </div>
                    </div>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
