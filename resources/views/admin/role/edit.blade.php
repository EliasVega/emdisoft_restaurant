@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Editar el Rol :&nbsp;&nbsp;&nbsp;&nbsp;  {{ $role->rol }}</h3>
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
            {!!Form::model($role, ['method'=>'PATCH','route'=>['role.update', $role->id]])!!}
            {!!Form::token()!!}
                <div class="box-body">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <label for="role">Rol</label>
                            <input type="text" name="role" class="form-control" value="{{ $role->role }}"
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <label for="description">Descripcion</label>
                            <input type="text" name="description" class="form-control" value="{{ $role->description }}"
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-pencil-alt"></i>&nbsp; Actualizar</button>
                            <a href="{{ url('role') }}" class="btn btn-danger"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
                        </div>
                    </div>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
