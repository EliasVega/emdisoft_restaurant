@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Editar Municipio de: &nbsp;&nbsp;&nbsp;&nbsp;{{ $municipality->name }}</h3>
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
            {!!Form::model($municipality, ['method'=>'PATCH','route'=>['municipality.update', $municipality->id]])!!}
            {!!Form::token()!!}
                <div class="box-body row">
                    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <label for="department_id">Departamento</label>
                            <div class="select">
                                <select name="department_id" class="form-control">
                                    @foreach($departments as $dep)
                                    @if($dep->id == $municipality->department_id)
                                    <option value="{{ $dep->id }}" selected>{{ $dep->name }}</option>
                                    @else
                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="code">Codigo</label>
                            <input type="text" name="code" class="form-control" value="{{ $municipality->code }}" placeholder="Municipio">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="name">Municipio</label>
                            <input type="text" name="name" class="form-control" value="{{ $municipality->name }}" placeholder="municipality">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-pencil-alt"></i>&nbsp; Actualizar</button>
                            <a href="{{ url('municipality') }}" class="btn btn-danger btn-md"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
                        </div>
                    </div>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
