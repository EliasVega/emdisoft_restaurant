@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h4 class="box-title">Agregando Traslado
                    <a href="{{ route('trnsfer.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
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
            <form action="{{route('transfer.store')}}" method="POST">
                {{csrf_field()}}
                <div class="box-body row">
                    @include('admin/transfer.form')
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

        jQuery(document).ready(function($){
            $(document).ready(function() {
                $('#product_id').select2({
                    theme: "classic",
                    width: "100%",
                });
            });
        });

        $(document).ready(function(){
            $("#add").click(function(){
                add();
            });

        });

        var cont=0;
        $("#save").hide();
        $("#product_id").change(productvalue);
        $(".idpro").hide();

        function productvalue(){

            dataProduct = document.getElementById('product_id').value.split('_');
            $("#idP").val(dataProduct[1]);

            dataProduct = document.getElementById('product_id').value.split('_');
            $("#stock").val(dataProduct[2]);
        }

        function add(){
            branch_id = $("#branch_id").val();
            branch= $("#branch_id option:selected").text();
            dataProduct = document.getElementById('product_id').value.split('_');
            product_id= dataProduct[0];
            product= $("#product_id option:selected").text();
            quantity= $("#quantity").val();
            stock= $("#stock").val();
            idp = $("#idP").val();

          if(branch_id != null && product_id !="" && quantity!="" && quantity>0  && stock!=""){

                if(parseInt(stock)>=parseInt(quantity)){

                    var fila= '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="removefile('+cont+');"><i class="fa fa-times"></i></button></td> <td><input type="hidden" name="idP[]" value="'+idp+'">'+idp+'</td> <td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td>  <td><input type="hidden" name="stock[]" value="'+stock+'">'+stock+'</td> <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="branch_id[]" value="'+branch_id+'">'+branch+'</td>   </tr>';
                    cont++;

                    assess();
                    $('#details').append(fila);
                    $('#product_id option:selected').remove();
                    clean();
                } else{

                    //alert("La cantidad a vender supera el stock");

                    Swal.fire({
                    type: 'error',
                    //title: 'Oops...',
                    text: 'La cantidad a trasladar supera el stock',

                    })
                }

            }else{

                //alert("Rellene todos los campos del detalle de la venta");

                Swal.fire({
                type: 'error',
                //title: 'Oops...',
                text: 'Rellene todos los campos del detalle de la venta',

                })

            }

     }


     function clean(){
        $("#product_id").val("");
        $("#quantity").val("");
        $("#stock").val("");
        $("#idP").val("");
     }


     function assess(){

         if(cont>0){
           $("#save").show();
           $("#branch_id").hide();

         } else{

           $("#save").hide();
         }
     }

     function removefile(index){

        $("#fila" + index).remove();
        assess();
     }
</script>
@endsection
