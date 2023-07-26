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

    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#payment_method_id').select2({
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

    $(document).ready(function(){
        $("#cash").click(function(){
            $("#pay").val("");
            payCash();
        });
    });

    $(document).ready(function(){
        $("#card").click(function(){
            $("#pay").val("");
            payCard();
        });
    });

    $(document).ready(function(){
        $("#transfer").click(function(){
            $("#pay").val("");
            payTransaction();
        });
    });

    $(document).ready(function(){
        $("#nequi").click(function(){
            $("#pay").val("");
            payNequi();
        });
    });

    $(document).ready(function(){
        $("#pay").keyup(function(){
            $("#pay").val();
            payment();
        });
    });

    $(document).ready(function(){
        $("#transvenped").click(function(){
            $("#pay").val("");
            payOrderInvoice();
        });
    });

    var cont=0;
    total=0;
    subtotal=[];
    total_iva=0;
    ret = 0;
    $("#save").hide();
    $("#payi").hide();
    $("#transactiony").hide();
    $("#banky").hide();
    $("#cardy").hide();
    $("#abvto").hide();
    $("#abpaymenty").hide();
    $("#idPro").hide();


    $("#product_id").change(productValue);

    function productValue(){

        dataProduct = document.getElementById('product_id').value.split('_');
        $("#price").val(dataProduct[1]);
        $("#price_sale").val(dataProduct[1]);
        $("#stock").val(dataProduct[2]);
        $("#quantity").val(dataProduct[3]);
        $("#iva").val(dataProduct[4]);
        pricep = dataProduct[1];
    }

    function documentValue(){

        dataDocument = document.getElementById('pay_event_id').value.split('_');
        $("#abv").val(dataDocument[0]);
        $("#pay").val(dataDocument[1]);
        $("#abpayment").val(dataDocument[2]);
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
        pv = $("#price_sale").val();


        if(product_id !="" && quantity!="" && quantity>0 && price!="" && iva!= ""){
                subtotal[cont]=quantity*price;
                total= total+subtotal[cont];
                ivita= subtotal[cont]*iva/100;
                total_iva=total_iva+ivita;

                var fila= '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="removefile('+cont+');"><i class="fa fa-times"></i></button></td> <td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td class="tdder"><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td class="tdder">$'+subtotal[cont]+' </td></tr>';
                cont++;

                totals();

                assess();
                $('#details').append(fila);
                //$('#product_id option:selected').remove();
                clean();
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

        $("#balance").val(total_pay.toFixed(2));

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

    function payCash(){
        $("#payment_method_id").val(1);
        $("#transaction").val("N/A");
        $("#bank_id").val(1);
        $("#card_id").val(1);
        $("#transactiony").hide();
        $("#banky").hide();
        $("#cardy").hide();
        $("#mpay").hide();
        $("#payi").show();
        $("#abpaymenty").hide();
        $("#eventy").hide();
    }

    function payCard(){
        $("#payment_method_id").val(2);
        $("#abpaymenty").hide();
        $("#mpay").hide();
        $("#eventy").hide();
        $("#payi").show();
        $("#banky").show();
        $("#cardy").show();
        $("#transactiony").show();
    }

    function payTransaction(){
        $("#payment_method_id").val(3);
        $("#card_id").val(1);
        $("#payi").show();
        $("#abpaymenty").hide();
        $("#transactiony").show();
        $("#banky").show();
        $("#cardy").hide();
        $("#mpay").hide();
        $("#eventy").hide();
    }

    function payNequi(){
        $("#payment_method_id").val(4);
        $("#bank_id").val(2);
        $("#card_id").val(1);
        $("#payi").show();
        $("#abpaymenty").hide();
        $("#transactiony").show();
        $("#cardy").hide();
        $("#mpay").hide();
        $("#banky").hide();
        $("#eventy").hide();
    }

    function payOrderInvoice(){
        $("#payment_method_id").val(1);
        $("#transaction").val("N/A");
        $("#bank_id").val(1);
        $("#card_id").val(1);
        $("#payi").hide();
        $("#abpaymenty").show();
        $("#transactiony").hide();
        $("#cardy").hide();
        $("#mpay").hide();
        $("#banky").hide();
        $("#eventy").show();
    }

    function payment(){
        ttp = parseFloat($("#total_pay").val())
        abn = parseFloat($("#pay").val())
        balancey = ttp - abn;
        if (ttp >= abn) {
            $("#returned").val(balancey);
        } else {
            //alert("Rellene todos los campos del detalle de la venta");
            Swal.fire({
            type: 'error',
            //title: 'Oops...',
            text: 'El abono supera el valor de la venta',
            })
            $("#pay").val(0)
            payment();
        }
    }
</script>
