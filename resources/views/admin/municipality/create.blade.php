@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar Municipio</h3>
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
            {!!Form::open(array('url'=>'municipality', 'method'=>'POST', 'autocomplete'=>'off'))!!}
            {!!Form::token()!!}
                <div class="box-body row">
                    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <label for="department_id">Departamento</label>
                            <div class="select">
                                <select name="department_id" class="form-control selectpicker" data-live-search="true" id="department_id" required>
                                    <option value="" disabled selected>Seleccionar.</option>
                                    @foreach($departments as $dep)
                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="code">Codigo</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="code">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="name">Municipio</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="municipality">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-save fa-2x"></i>&nbsp; Guardar</button>
                        <a href="{{url('municipality')}}" class="btn btn-danger btn-md"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
                    </div>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        /*$(document).ready(function(){
            alert('estoy funcionando correctamanete colegio');
        });*/
        jQuery(document).ready(function($){
            $(document).ready(function() {
                $('#department_id').select2({
                    theme: "classic",
                    width: "100%",
                });
            });
        });

    </script>
@endsection
