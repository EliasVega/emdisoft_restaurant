@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h4 class="box-title">Editar Proveedor: {{ $supplier->name }}
                    <a href="{{ route('supplier.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
                    <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
                </h4>
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
            {!!Form::model($supplier, ['method'=>'PATCH','route'=>['supplier.update', $supplier->id]])!!}
            {!!Form::token()!!}
                <div class="box-body row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="document_id">Tipo Documento</label>
                                <select name="document_id" class="form-control" id="document_id">
                                    @foreach($documents as $doc)
                                        @if($doc->id == $supplier->document_id)
                                            <option value="{{ $doc->id }}" selected>{{ $doc->name }}</option>
                                        @else
                                            <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="number">Numero</label>
                            <input type="text" name="number" value="{{ $supplier->number }}" class="form-control" placeholder="Nit">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label for="dv">DV</label>
                            <input type="text" name="dv" value="{{ $supplier->dv }}" class="form-control" placeholder="DV">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="name">Nombre Proveedor</label>
                            <input type="text" name="name" class="form-control" value="{{ $supplier->name }}">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="department_id">Departamentos</label>
                                <select name="department_id" class="form-control" id="department_id">
                                    @foreach($departments as $dep)
                                        @if($dep->id == $supplier->department_id)
                                            <option value="{{ $dep->id }}" selected>{{ $dep->name }}</option>
                                        @else
                                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="municipality_id" >Municipio</label>
                                <select name="municipality_id" class="form-control" id="municipality_id" required>
                                    @foreach($municipalities as $mun)
                                        @if($mun->id == $supplier->municipality_id)
                                            <option value="{{ $mun->id }}" selected>{{ $mun->name }}</option>
                                        @else
                                            <option value="{{ $mun->id }}">{{ $mun->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="address">Direccion</label>
                            <input type="text" name="address" value="{{ $supplier->address }}" class="form-control" placeholder="Ingrese la direccion">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ $supplier->email }}" class="form-control" placeholder="Ingrese el correo electronico">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="phone">Numero de Telefono</label>
                            <input type="text" name="phone" value="{{ $supplier->phone }}" class="form-control" placeholder="Numero de telefono">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="liability_id">Responsabilidad fiscal</label>
                                <select name="liability_id" class="form-control" id="liability_id">
                                    @foreach($liabilities as $lia)
                                        @if($lia->id == $supplier->liability_id)
                                            <option value="{{ $lia->id }}" selected>{{ $lia->name }}</option>
                                        @else
                                            <option value="{{ $lia->id }}">{{ $lia->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="organization_id">Tipo Organizacion</label>
                                <select name="organization_id" class="form-control" id="organizacion_id">
                                    @foreach($organizations as $org)
                                        @if($org->id == $supplier->organization_id)
                                            <option value="{{ $org->id }}" selected>{{ $org->name }}</option>
                                        @else
                                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="regime_id">Regimen</label>
                                <select name="regime_id" class="form-control" id="fiscal_id">
                                    @foreach($regimes as $reg)
                                        @if($reg->id == $supplier->regime_id)
                                            <option value="{{ $reg->id }}" selected>{{ $reg->name }}</option>
                                        @else
                                            <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="contact">Contacto</label>
                            <input type="text" name="contact" value="{{ $supplier->contact }}" class="form-control" placeholder="Ingrese el Nombre del contacto">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="phone_contact">Telefono de Contacto</label>
                            <input type="text" name="phone_contact" value="{{ $supplier->phone_contact }}" class="form-control" placeholder="Telefono del contacto">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-celeste" type="submit"><i class="fa fa-pencil-alt"></i>&nbsp; Actualizar</button>
                            <a href="{{ url('supplier') }}" class="btn btn-gris"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
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
                $('#departamento').select2({
                    theme: "classic",
                    width: "100%",
                });
            });
        });
        jQuery(document).ready(function($){
            $(document).ready(function() {
                $('#municipio').select2({
                    theme: "classic",
                    width: "100%",
                });
            });
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
