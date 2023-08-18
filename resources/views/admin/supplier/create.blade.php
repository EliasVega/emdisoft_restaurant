@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h4 class="box-title">Agregar Proveedor
                    <a href="{{ route('supplier.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
                    <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
                </h4>
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
            {!!Form::open(array('url'=>'supplier', 'method'=>'POST', 'autocomplete'=>'off'))!!}
            {!!Form::token()!!}

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @include('admin/supplier.form')
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
