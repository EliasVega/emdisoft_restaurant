
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-body row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="form-control" placeholder="Nombre" required>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="departamento_id">Departamentos</label>
                    <div class="select">
                        <select name="departamento_id" id="departamento_id"class="form-control selectpicker" data-live-search="true"  required>
                            <option value="{{ old('departamento') }}" disabled selected>Seleccionar.</option>
                            @foreach($departamentos as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="municipio_id">Municipio</label>
                    <div class="select">
                        <select name="municipio_id" id="municipio_id" class="form-control"  required>
                            <option value ="#" disabled selected>Seleccionar...</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="direccion">Direccion Sede</label>
                    <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}" class="form-control" placeholder="Ingrese La Direccion" required>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="nit">Nit</label>
                    <input type="text" name="nit" id="nit" value="{{ old('nit') }}" class="form-control" placeholder="Nit" required>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="actividad_economica_id">Actividades Economicas</label>
                    <div class="select">
                        <select name="actividad_economica_id" id="actividad_economica_id" class="form-control selectpicker" data-live-search="true"  required>
                            <option value="{{ old('actividad_economica') }}" disabled selected>Seleccionar.</option>
                            @foreach($actividad_economicas as $act)
                            <option value="{{ $act->codigo }}">{{ $act->codigo }}&nbsp;  {{ $act->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="arl_id">Arl</label>
                    <div class="select">
                        <select name="arl_id" id="arl_id" class="form-control selectpicker" data-live-search="true"  required>
                            <option value="{{ old('arl') }}" disabled selected>Seleccionar.</option>
                            @foreach($arls as $arl)
                            <option value="{{ $arl->id }}">{{ $arl->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="nivel_riesgo">Nivel de riesgo</label>
                    <div class="select">
                        <select name="nivel_riesgo" id="nivel_riesgo" class="form-control">
                            <option value="">Seleccionar.</option>
                            <option value="1">Muy bajo</option>
                            <option value="2">Bajo</option>
                            <option value="3">Medio</option>
                            <option value="4">Alto</option>
                            <option value="5">Muy Alto</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="telefono">Telefono Sede</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" class="form-control" placeholder="Ingrese el numero de telefono fijo" required>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="celular">Celular Sede</label>
                    <input type="text" name="celular" id="celular" value="{{ old('celular') }}" class="form-control" placeholder="Ingrese el numero Celular" required>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="gerente">Gerente o Administrador</label>
                    <input type="text" name="gerente" id="gerente" value="{{ old('gerente') }}" class="form-control" placeholder="Nombre del Gerente o Administrador" required>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <button class="btn btn-celeste btn-md" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
                    <a href="{{url('admin/sede')}}" class="btn btn-gris"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        $(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });
        $("#departamento").change(function(event){
            $.get("create/" + event.target.value + "", function(response){
                $("#municipio").empty();
                $("#municipio").append("<option value = '#' disabled selected>Seleccionar ...</option>");
                for(i = 0; i < response.length; i++){
                    $("#municipio").append("<option value = '" + response[i].id +"'>" + response[i].nombre + "</option>");
                }
            });
        });
    </script>
@endsection
