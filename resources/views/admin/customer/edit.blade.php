@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h4>Editar Cliente: {{ $customer->name }}
                    <a href="{{ route('customer.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
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
            {!!Form::model($customer, ['method'=>'PATCH','route'=>['customer.update', $customer->id]])!!}
            {!!Form::token()!!}
                <div class="box-body row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="document_id">Tipo Identificacion</label>
                            <select name="document_id" class="form-control" id="document_id">
                                @foreach($documents as $doc)
                                    @if($doc->id == $customer->document_id)
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
                            <label for="number">Identificacion</label>
                            <input type="text" name="number" value="{{ $customer->number }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label for="dv">DV</label>
                            <input type="text" name="dv" value="{{ $customer->dv }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="name">Cliente</label>
                            <input type="text" name="name" class="form-control" value="{{ $customer->name }}">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="department_id">Departamentos</label>
                            <select name="department_id" class="form-control" id="department_id">
                                @foreach($departments as $dep)
                                    @if($dep->id == $customer->department_id)
                                        <option value="{{ $dep->id }}" selected>{{ $dep->name }}</option>
                                    @else
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="municipality_id">Municipio</label>
                            <select name="municipality_id" class="form-control" id="municipality_id" required>
                                @foreach($municipalities as $mun)
                                    @if($mun->id == $customer->municipality_id)
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
                            <label for="liability_id">Responsabilidad fiscal</label>
                                <select name="liability_id" class="form-control" id="liability_id">
                                    @foreach($liabilities as $fis)
                                        @if($fis->id == $customer->liability_id)
                                            <option value="{{ $fis->id }}" selected>{{ $fis->name }}</option>
                                        @else
                                            <option value="{{ $fis->id }}">{{ $fis->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="organization_id">Tipo organizacion</label>
                                <select name="organization_id" class="form-control" id="organization_id">
                                    @foreach($organizations as $org)
                                        @if($org->id == $customer->org_id)
                                            <option value="{{ $org->id }}" selected>{{ $org->name }}</option>
                                        @else
                                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="regime_id">Regimen</label>
                                <select name="regime_id" class="form-control" id="fiscal_id">
                                    @foreach($regimes as $reg)
                                        @if($reg->id == $customer->regime_id)
                                            <option value="{{ $reg->id }}" selected>{{ $reg->name }}</option>
                                        @else
                                            <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="direccion">Direccion</label>
                            <input type="text" name="direccion" value="{{ $customer->address }}" class="form-control" placeholder="Ingrese la direccion">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="phone">Telefono</label>
                            <input type="text" name="phone" value="{{ $customer->phone }}" class="form-control" placeholder="Telefono">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ $customer->email }}" class="form-control" placeholder="Ingrese el correo electronico">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="credit_limit">Cupo</label>
                            <input type="number" name="credit_limit" value="{{ $customer->credit_limit }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-celeste" type="submit"><i class="fa fa-pencil-alt"></i>&nbsp; Actualizar</button>
                            <a href="{{ url('customer') }}" class="btn btn-gris"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
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
            $.get("edit/" + event.target.value + "", function(response){
                $("#municipality_id").empty();
                $("#municipality_id").append("<option value = '#' disabled selected>Seleccionar ...</option>");
                for(i = 0; i < response.length; i++){
                    $("#municipality_id").append("<option value = '" + response[i].id +"'>" + response[i].name + "</option>");
                }
            });
        });

    </script>
@endsection
