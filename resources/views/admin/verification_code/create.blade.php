@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Nuevo </h3>
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
            {!!Form::open(array('url'=>'verification_code', 'method'=>'POST', 'autocomplete'=>'off'))!!}
            {!!Form::token()!!}
            <div class="box-body row">
                <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="user_id">Usuario</label>
                        <select name="user_id" class="form-control" data-live-search="true" id="user_id" required>
                            <option value="{{ old('user_id') }}" disabled selected>Seleccionar.</option>
                            @foreach($users as $use)
                                <option value="{{ $use->id }}">{{ $use->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="code">Codigo Admin</label>
                        <input type="password" name="code" value="{{ old('code') }}" class="form-control" placeholder="Codigo">
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
                        <a href="{{url('verification_code')}}" class="btn btn-danger"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
