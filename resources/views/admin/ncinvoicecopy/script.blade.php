<script>
    /*$(document).ready(function(){
        alert('estoy funcionando correctamanete empresa');
    });*/
    $(document).ready(function(){
        $("#add").click(function(){
            add();
        });
    });

    var cont=0;
    total=0;
    subtotal=[];
    total_iva = 0;
    $("#save").hide();
    $("#nc").hide();
    $("#elim").hide();

    $(document).ready(function(){
        $("#nc_discrepancy_id").change(function(){

            if ($("#nc_discrepancy_id").val() == 2) {
                $("#nc").hide();
                $("#elim").show();

            } else {
                $("#elim").hide();
                $("#nc").show();
            }
        });
    });
/*
    $("#nc_discrepancy_id").change(discrepancyValue);

    function discrepancyValue(){
        datadiscrepancy = document.getElementById('nc_discrepancy_id').value.split('_');
        $("#nc_discrepancy_id").val(dataProduct[0]);
        disc = $("#nc_discrepancy_id").val();
        $(document).ready(function(){
            $("#discrepancy_id").change(function(){
                if (disc == 2) {
                $("#nc").hide();
                } else {
                    $("#nc").show();
                }
            });
        });
    }*/

    $("#product_id").change(productValue);

    function productValue(){

        dataProduct = document.getElementById('product_id').value.split('_');
        $("#price").val(dataProduct[1]);
        $("#stock").val(dataProduct[2]);
        $("#quantity").val(dataProduct[3]);
        $("#quantityI").val(dataProduct[3]);
        $("#iva").val(dataProduct[4]);
    }

    function add(){
        dataProduct = document.getElementById('product_id').value.split('_');
        product_id= dataProduct[0];
        product= $("#product_id option:selected").text();
        quantity= $("#quantity").val();
        price= $("#price").val();
        quantityI= $("#quantityI").val();
        stock= $("#stock").val();
        iva= $("#iva").val();

        if(product_id !="" && quantity!="" && quantity>0 && price!="" && stock>"" && iva!= ""){

            subtotal[cont]=quantity*price;
            total= total+subtotal[cont];
            ivita= subtotal[cont]*iva/100;
            total_iva=total_iva+ivita;

            if(parseInt(quantity) <= parseInt(quantityI) && parseInt(quantity) > 0){

                var fila= '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td> <td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td> <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" id="price[]" name="price[]"  value="'+price+'">'+price+'</td> <td>$'+subtotal[cont]+' </td></tr>';
                cont++;

                totals();

                assess();
                $('#details').append(fila);
                //$('#product_id option:selected').remove();
                clean();

            }else{


                //alert("La cantidad a vender supera el stock");

                Swal.fire({
                    type: 'error',
                    //title: 'Oops...',
                    text: 'La cantidad supera las unidades vendidas o es negativa',

                })
            }

        }else{

           // alert("Rellene todos los campos del detalle de la compra, revise los datos del producto");

            Swal.fire({
            type: 'error',
            //title: 'Oops...',
            text: 'Rellene todos los campos del detalle de la ventas',

            })

        }

 }


 function clean(){
    $("#product_id").val("");
    $("#quantityI").val("");
    $("#quantity").val("");
    $("#price").val("");
    $("#iva").val("");
    $("#stock").val("");
 }

 function totals(){

    $("#total_html").html("$ " + total.toFixed(2));
    $("#total").val(total.toFixed(2));

    total_pay=total+total_iva;
    $("#total_iva_html").html("$ " + total_iva.toFixed(2));
    $("#total_iva").val(total_iva.toFixed(2));

    $("#total_pay_html").html("$ " + total_pay.toFixed(2));
    $("#total_pay").val(total_pay.toFixed(2));

 }



 function assess(){

     if(total>=0){

       $("#save").show();

     } else{

       $("#save").hide();
     }
 }

 function eliminar(index){

    total = total-subtotal[index];
    total_iva= total*iva/100;
    total_pay = total + total_iva;

    $("#total_html").html("$ " + total.toFixed(2));
    $("#total").val(total.toFixed(2));

    total_pay=total+total_iva;
    $("#total_iva_html").html("$ " + total_iva.toFixed(2));
    $("#total_iva").val(total_iva.toFixed(2));

    $("#total_pay_html").html("$ " + total_pay.toFixed(2));
    $("#total_pay").val(total_pay.toFixed(2));

    $("#fila" + index).remove();
    assess();
 }
</script>
