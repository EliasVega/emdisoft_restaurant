@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h4>Recargando Caja
                    <a href="{{ route('sale_box.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
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
            <form action="{{route('cash_in.store')}}" method="POST">
                {{csrf_field()}}
                <div class="box-body row">
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label class="form-control-label" for="reason">Razon</label>
                            <input type="text" id="reason" name="reason" value="" class="form-control"
                                placeholder="Motivo">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group" id="cajetilla">
                            <label class="form-control-label" for="boxy">Efectivo Caja</label>
                            <input type="number" id="boxy" name="boxy" value="{{ $sale_box->cash }}" class="form-control"
                                placeholder="Efectivo" disabled pattern="[0-9]{0,15}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group" id="valorcito">
                            <label class="form-control-label" for="payment">Efectivo</label>
                            <input type="number" id="payment" name="payment" value="" class="form-control"
                                placeholder="Efectivo" pattern="[0-9]{0,15}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="admin_id">Entrega</label>
                            <select name="admin_id" class="form-control selectpicker" id="admin_id"
                                data-live-search="true">
                                <option value="" disabled selected>Seleccionar....</option>
                                @foreach($users as $use)
                                <option value="{{ $use->id }}">{{ $use->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="user_id">Recibe</label>
                            <select name="user_id" class="form-control selectpicker" id="user_id"
                                data-live-search="true">
                                <option value="" disabled selected>Seleccionar....</option>
                                @foreach($users as $use)
                                <option value="{{ $use->id }}">{{ $use->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="form-group" id="save">
                            <button class="btn btn-celeste btn-md" type="submit"><i class="fa fa-save"></i>&nbsp; Aceptar</button>
                            <a href="{{url('cash_in')}}" class="btn btn-gris"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    /*$(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });*/

        $(document).ready(function(){
            $("#payment").blur(function(){
                valuing();
                assess();
            });
        });

        $(document).ready(function(){
            $("#admin_id").click(function(){
                assign();
            });
        });
        valor = 0;
        admin = "";
        $("#save").hide();

    function valuing(){

        payment = parseFloat($("#payment").val());

        if(payment < 0){
            //alert("Rellene todos los campos del detalle de la venta");
            Swal.fire({
            type: 'error',
            //title: 'Oops...',
            text: 'Estas ingresando un valor negativo',
            })
            $("#payment").val("")
        }
    }
    function assign(){
        payment = $("#payment").val();


        if(payment <= 0 || payment == ""){
            //alert("Rellene todos los campos del detalle de la venta");
            Swal.fire({
            type: 'error',
            //title: 'Oops...',
            text: 'Primero debes digitar la cantidad a Retirar',
            })
        }
    }

    function assess(){

        if(payment>0){
            $("#save").show();
        } else{
            $("#save").hide();
        }
    }
</script>

@endsection
