@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Editar Sucursal de: &nbsp;&nbsp;&nbsp;{{ $branch->name }}</h3>
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
            {!!Form::model($branch, ['method'=>'PATCH','route'=>['branch.update', $branch->id]])!!}
            {!!Form::token()!!}
                <div class="box-body row">

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                        <label for="department_id">departments</label>
                            <select name="department_id" class="form-control" id="department_id">
                                @foreach($departments as $dep)
                                    @if($dep->id == $branch->department_id)
                                        <option value="{{ $dep->id }}" selected>{{ $dep->name }}</option>
                                    @else
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="municipality_id">Municipio</label>
                            <select name="municipality_id" class="form-control" id="municipality_id" required>
                                @foreach($municipalities as $mun)
                                    @if($mun->id == $branch->municipality_id)
                                        <option value="{{ $mun->id }}" selected>{{ $mun->name }}</option>
                                    @else
                                        <option value="{{ $mun->id }}">{{ $mun->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" value="{{ $branch->name }}" class="form-control" placeholder="Nombre" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="address">Direccion Sucursal</label>
                            <input type="text" name="address" value="{{ $branch->address }}" class="form-control" placeholder="Ingrese La Direccion" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ $branch->email }}" class="form-control" placeholder="Ingrese el correo electronico">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="manager">Gerente o Administrador</label>
                            <input type="text" name="manager" value="{{ $branch->manager }}" class="form-control" placeholder="name del Gerente o Administrador" required>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="phone">Telefono branch</label>
                            <input type="text" name="phone" value="{{ $branch->phone }}" class="form-control" placeholder="Ingrese el numero de telefono fijo" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="mobile">Celular branch</label>
                            <input type="text" name="mobile" value="{{ $branch->mobile }}" class="form-control" placeholder="Ingrese el numero Celular" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-celeste btn-md" type="submit"><i class="fa fa-pencil-alt"></i>&nbsp; Actualizar</button>
                            <a href="{{ url('branch') }}" class="btn btn-gris btn-md"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
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
            });
        });

    </script>
@endsection
