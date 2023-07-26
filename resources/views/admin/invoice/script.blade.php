<script>
    /*$(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });*/
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
    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#percentage_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });
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
            $('#product_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });

    var cont = 0;
    var total = 0;
    var subtotal = [];
    var total_iva = 0;
    var total_pay = 0;
    var total_desc = 0;
    var ret = 0;
    var vrte = 0;
    //form invoice
    $("#addIdProduct").hide();
    $("#addPercentageId").hide();
    $("#addPercentage").hide();
    $("#save").hide();
    $("#rtferase").hide();
    $("#rtftotal").hide();

    $(document).ready(function(){
        $("#rtfon").click(function(){
            $("#addPercentageId").show();
            $("#rtferase").show();
            $("#rtftotal").show();
            $("#addPercentage").show();
        });
    });
    $(document).ready(function(){
        $("#rtfoff").click(function(){
            $("#addPercentageId").hide();
            $("#rtferase").hide();
            $("#rtftotal").hide();
            $("#addPercentage").hide();
        });
    });
    $("#percentage_id").change(percentageVer);

    function percentageVer(){
        datapercentage = document.getElementById('percentage_id').value.split('_');
        $("#percentage_id").val(datapercentage[0]);
        $("#percentage").val(datapercentage[1]);
        percentages();
        totals();
    }

    function percentages(){
        $("#addPercentageId").hide();
        $("#addPercentageId").hide();
        $("#rtfon").attr('disabled','disabled');
        $("#rtfoff").attr('disabled','disabled');
    }

    $("#product_id").change(productValue);

    function productValue(){
        dataProduct = document.getElementById('product_id').value.split('_');
        $("#stock").val(dataProduct[1]);
        $("#sale_price").val(dataProduct[2]);
        $("#iva").val(dataProduct[3]);
        $("#idP").val(dataProduct[4]);
        $("#suggested_price").val(dataProduct[2]);
    }
    $(document).ready(function(){
        $("#add").click(function(){
            add();
        });
    });
    function add(){
        dataProduct = document.getElementById('product_id').value.split('_');
        product_id= dataProduct[0];
        product= $("#product_id option:selected").text();
        quantity= $("#quantity").val();
        price= $("#sale_price").val();
        stock= $("#stock").val();
        iva= $("#iva").val();
        idp= $("#idP").val();
        idps= idp.toString();
        percentage = $("#percentage").val();
        retention = $("#retention").val();

        datapercentage = document.getElementById('percentage_id').value.split('_');
        percentage_id= datapercentage[0];
        percentage = $("#percentage").val();
        pay = $("#pay").val();
        if(product_id !="" && quantity!="" && quantity>0  && price!="" && stock!="" && iva!=""){

            if (parseFloat(quantity) > parseFloat(stock) ) {
                //alert("Rellene todos los campos del detalle de la venta");
                Swal.fire({
                type: 'error',
                //title: 'Oops...',
                text: 'La cantidad a vender supera el stock',
            })
            } else {
                subtotal[cont]= parseFloat(quantity) * parseFloat(price);
                total= total+subtotal[cont];
                ivita= subtotal[cont]*iva/100;
                total_iva=total_iva+ivita;

                var fila= '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td> <td><input type="hidden" name="idP[]" value="'+idp+'">'+idp+'</td> <td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td> <td><input type="hidden" id="quantity" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" id="price" name="price[]" value="'+parseFloat(price).toFixed(2)+'">'+price+'</td> td> <td><input type="hidden" name="iva[]" value="'+iva+'">'+iva+'</td>  <td> $'+parseFloat(subtotal[cont]).toFixed(2)+'</td></tr>';
                cont++;

                totals();
                assess();
                $('#details').append(fila);
                //$('#product_id option:selected').remove();
                clean();
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
        $("#sale_price").val("");
        $("#idP").val("");
    }
    function totals(){
        var rte = parseFloat($("#percentage").val());
        var vrte = total * rte / 100;
        var total_pay = total + total_iva;
        var total_desc = total_pay - vrte;

        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));

        $("#total_iva_html").html("$ " + total_iva.toFixed(2));
        $("#total_iva").val(total_iva.toFixed(2));

        $("#retention_html").html("$ " + vrte.toFixed(2));
        $("#retention").val(vrte.toFixed(2));

        $("#total_desc_html").html("$ " + total_desc.toFixed(2));
        $("#total_desc").val(total_desc.toFixed(2));

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
        $("#balance").val(total_pay.toFixed(2));
        assess();
    }
</script>
