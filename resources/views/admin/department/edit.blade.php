@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Editar el Departamento: &nbsp;&nbsp;&nbsp;&nbsp;{{ $department->name }}</h3>
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
            {!!Form::model($department, ['method'=>'PATCH','route'=>['department.update', $department->id]])!!}
            {!!Form::token()!!}
            <div class="box-body row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="dane_code">Codigo</label>
                        <input type="text" name="dane_code" value="{{ $department->dane_code }}" class="form-control">
                    </div>
                </div>
                <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12">
                    <div class="form-group">
                        <label for="name">Departamento</label>
                        <input type="text" name="name" value="{{ $department->name }}" class="form-control">
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="iso_code">Codigo ISO</label>
                        <input type="text" name="iso_code" value="{{ $department->iso_code }}" class="form-control">
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
                        <a href="{{url('department')}}" class="btn btn-danger"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
