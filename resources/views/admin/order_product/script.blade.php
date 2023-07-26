<script>
    /*$(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });*/
    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#customer_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });
    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#percentage_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });
    var cont=0;
    total=0;
    subtotal=[];
    total_iva=0;
    ret = 0;
    //form purchase
    $("#idPro").hide();
    $("#percentagey").hide();
    $("#percent").hide();
    $("#save").hide();
    $("#addOrder"). hide();

    //mostrar de acuerdo al retencion
    $(document).ready(function(){
        $("#rtfon").click(function(){
            $("#percentagey").show();
            $("#rtferase").show();
            $("#percent").show();
        });
    });

    $(document).ready(function(){
        $("#rtfoff").click(function(){
            $("#percentagey").hide();
            $("#rtferase").hide();
            $("#porcent").hide();
        });
    });

    //Seleccionar de acuerdo a porcentage
    $("#percentage_id").change(percentageVer);

    function percentageVer(){
        datapercentage = document.getElementById('percentage_id').value.split('_');

        $("#percentage_id").val(datapercentage[0]);
        $("#percentage").val(datapercentage[1]);
        percentages();
        totals();
    }
    function percentages(){
        $("#percentagey").hide();
    }

    order = {!! json_encode($orderProducts) !!};
    order.forEach((value, i) => {
        if (value['quantity'] > 0) {

            product_id= value['idP'];
            product= value['name'];
            quantity= value['quantity'];
            price= value['price'];
            stock= value['stock'];
            iva= value['iva'];
            retention = value['percentage'];
            orderBalance = value['balance'];
            $('#percentage').val(retention);
            $("#pendient").val(orderBalance);

            if(product_id !="" && quantity!="" && quantity>0  && price!=""){
                subtotal[cont]= parseFloat(quantity) * parseFloat(price);
                total= total+subtotal[cont];
                ivita= subtotal[cont]*iva/100;
                total_iva=total_iva+ivita;

                var fila= '<tr class="selected" id="fila'+cont+'"><td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td> <td><input type="hidden" id="quantity" name="quantity[]" value="'+parseFloat(quantity).toFixed(2)+'">'+quantity+'</td> <td><input type="hidden" id="price" name="price[]" value="'+parseFloat(price).toFixed(2)+'">'+price+'</td> td> <td><input type="hidden" name="iva[]" value="'+iva+'">'+iva+'</td>  <td> $'+parseFloat(subtotal[cont]).toFixed(2)+'</td></tr>';
                cont++;

                totals();
                assess();
                $('#details').append(fila);

                $('#product_id option:selected').remove();


            }else{
                //alert("Rellene todos los campos del detalle para esta compra");
                Swal.fire({
                type: 'error',
                //title: 'Oops...',
                text: 'Rellene todos los campos del detalle para esta compra',
                })
            }
        }
    });
    function totals(){
        rte = parseFloat($("#percentage").val());
        vrte = total*rte/100;

        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));

        total_pay=total+total_iva;

        $("#total_iva_html").html("$ " + total_iva.toFixed(2));
        $("#total_iva").val(total_iva.toFixed(2));

        total_pay = total_pay - vrte;
        $("#retention_html").html("$ " + vrte.toFixed(2));
        $("#retention").val(vrte.toFixed(2));

        $("#total_pay_html").html("$ " + total_pay.toFixed(2));
        $("#total_pay").val(total_pay.toFixed(2));

        $("#balance").val(total_pay.toFixed(2));

    }
    function assess(){

        if(total>0){

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
