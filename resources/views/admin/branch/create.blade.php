@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection

@section('content')
@if (session('info'))
    <div class="alert alert-success"></div>
    <strong>{{ session('info') }}</strong>
@endif
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar Sucursal</h3>
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
            {!!Form::open(array('url'=>'branch', 'method'=>'POST', 'autocomplete'=>'off', 'files' => 'true')) !!}
            {!!Form::token()!!}
                <div class="box-body row">

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="department_id">Departamento</label>
                            <div class="select">
                                <select name="department_id" class="form-control selectpicker" data-live-search="true" id="department_id" required>
                                    <option value="{{ old('department_id') }}" disabled selected>Seleccionar.</option>
                                    @foreach($departments as $dep)
                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="municipality_id">Municipio</label>
                            <div class="select">
                                <select name="municipality_id" class="form-control" id="municipality_id" required>
                                    <option value ="#" disabled selected>Seleccionar...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="nombre" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="address">Direccion Sucursal</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control" placeholder="Direccion" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Ingrese el correo electronico">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="manager">Gerente o Administrador</label>
                            <input type="text" name="manager" value="{{ old('manager') }}" class="form-control" placeholder="name del Gerente o Administrador" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="phone">Telefono Sucursal</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Telefono" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="mobile">Celular Sucursal</label>
                            <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="Celular" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-celeste btn-md" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
                            <a href="{{url('branch')}}" class="btn btn-gris"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
                        </div>
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
        jQuery(document).ready(function($){
            $(document).ready(function() {
                $('#municipality_id').select2({
                    theme: "classic",
                    width: "100%",
                });
            });
        });
        $("#department_id").change(function(event){
            $.get("create/" + event.target.value + "", function(response){
                $("#municipality_id").empty();
                $("#municipality_id").append("<option value = '#' disabled selected>Seleccionar ...</option>");
                for(i = 0; i < response.length; i++){
                    $("#municipality_id").append("<option value = '" + response[i].id +"'>" + response[i].name + "</option>");
                }
                $("#municipality_id").selectpicker('refresh');
            });
        });

    </script>
@endsection
