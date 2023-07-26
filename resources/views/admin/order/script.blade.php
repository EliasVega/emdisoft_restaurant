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
    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#payment_form_id').select2({
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
    var cont=0;
    total=0;
    subtotal=[];
    total_iva=0;
    ret = 0;
    percentage_id = 1;
    //form invoice
    $("#addProductId").hide();
    $("#addIdPercentage").hide();
    $("#addVpercentage").hide();
    $("#addPercentage").hide();
    /*
    $("#save").hide();
    //form pay
    $("#cash").hide();
    $("#transfer").hide();
    $("#nequi").hide();
    $("#card1").hide();
    $("#card2").hide();
    $("#noDefined").hide();
    $("#advanceCus").hide();
    $("#transvenped").hide();
    $("#addpayment").hide();*/
    /*
    $("#payi").hide();
    $("#abadvancey").hide();
    $("#abvto").hide();
    $("#transactiony").hide();
    $("#banky").hide();
    $("#cardy").hide();
    $("#advancey").hide();*/
    //$("#rtferase").hide();
    /*
    $("#advances").hide();
    $("#percentage").val(0);*/

    $(document).ready(function(){
        $("#rtfon").click(function(){
            $("#addPercentage").show();
            //$("#rtferase").show();
            $("#addVpercentage").show();
        });
    });
    $(document).ready(function(){
        $("#rtfoff").click(function(){
            $("#addPercentage").hide();
            //$("#rtferase").hide();
            $("#addVpercentage").hide();
        });
    });
    $("#percentage_id").change(percentageVer);

    function percentageVer(){
        datapercentage = document.getElementById('percentage_id').value.split('_');
        percentage_id= datapercentage[0];
        $("#percentage").val(datapercentage[1]);
        //idpercentage = $("#idpercentage").val();
        percentages();
    }

    function percentages(){
        $("#addPercentage").hide();
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

        //datapercentage = document.getElementById('percentage_id').value.split('_');
        //percentage_id= datapercentage[0];
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

                var fila= '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td><td><input type="hidden" name="percentage_id[]" value="'+percentage_id+'">'+percentage_id+'</td> <td><input type="hidden" name="idP[]" value="'+idp+'">'+idp+'</td> <td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td> <td><input type="hidden" id="quantity" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" id="price" name="price[]" value="'+parseFloat(price).toFixed(2)+'">'+price+'</td> td> <td><input type="hidden" name="iva[]" value="'+iva+'">'+iva+'</td>  <td> $'+parseFloat(subtotal[cont]).toFixed(2)+'</td></tr>';
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
        $("#percentagey").hide();
        $("#rtfon").attr('disabled','disabled');
        $("#rtfoff").attr('disabled','disabled');

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
    /*
    $(document).ready(function(){
        $("#payment_form_id").change(function(){
        form = $("#payment_form_id").val();
        if(form == 1){
            $("#noDefined").show();
            $("#cash").show();
            $("#advanceCus").show();
            $("#transfer").show();
            $("#nequi").show();
            $("#card1").show();
            $("#card2").show();
            $("#mpay").hide();
            $("#addpayment").hide();
        }else{
            $("#addpayment").show();
            $("#noDefined").hide();
            $("#cash").hide();
            $("#advanceCus").hide();
            $("#transfer").hide();
            $("#nequi").hide();
            $("#card1").hide();
            $("#card2").hide();
            $("#mpay").show();
        }
        });
    });
    $(document).ready(function(){
        $("#addpay").click(function(){
            see();
        });
    });
    function see(){
        $("#noDefined").show();
        $("#cash").show();
        $("#advanceCus").show();
        $("#transfer").show();
        $("#nequi").show();
        $("#card1").show();
        $("#card2").show();
        $("#mpay").hide();
        $("#addpayment").hide();
    }
    $(document).ready(function(){
        $("#cash").click(function(){
            tpay = $("#balance").val();
            $("#pay").val(tpay);
            payCash();
        });
    });
    function payCash(){
        $("#pay").val();
        $("#returned").val(0);
        $("#payment_method_id").val(10);
        $("#transaction").val("N/A");
        $("#bank_id").val(1);
        $("#card_id").val(1);
        $("#banky").hide();
        $("#cardy").hide();
        $("#transactiony").hide();
        $("#payi").show();
        $("#abpaymenty").hide();
        $("#advancey").hide();
        $("#advance").val(0);
        $("#eventy").hide();
    }
    $(document).ready(function(){
        $("#transfer").click(function(){
            tpay = $("#balance").val();
            $("#pay").val(tpay);
            payTransaction();
        });
    });
    function payTransaction(){
        $("#pay").val();
        $("#returned").val(0);
        $("#payment_method_id").val(47);
        $("#card_id").val(1);
        $("#payi").show();
        $("#abpaymenty").hide();
        $("#transactiony").show();
        $("#banky").show();
        $("#cardy").hide();
        $("#mpay").hide();
        $("#eventy").hide();
        $("#advancey").hide();
    }
    $(document).ready(function(){
        $("#nequi").click(function(){
            tpay = $("#balance").val();
            $("#pay").val(tpay);
            payNequi();
        });
    });
    function payNequi(){
        $("#pay").val();
        $("#returned").val(0);
        $("#payment_method_id").val(47);
        $("#bank_id").val(2);
        $("#card_id").val(1);
        $("#payi").show();
        $("#abpaymenty").hide();
        $("#transactiony").show();
        $("#cardy").hide();
        $("#mpay").hide();
        $("#banky").hide();
        $("#eventy").hide();
        $("#advancey").hide();
    }
    $(document).ready(function(){
        $("#card1").click(function(){
            tpay = $("#balance").val();
            $("#pay").val(tpay);
            payCard1();
        });
    });
    function payCard1(){
        $("#pay").val();
        $("#returned").val(0);
        $("#payment_method_id").val(48);
        $("#abpaymenty").hide();
        $("#mpay").hide();
        $("#eventy").hide();
        $("#payi").show();
        $("#banky").show();
        $("#cardy").show();
        $("#advancey").hide();
        $("#transactiony").show();
    }
    $(document).ready(function(){
        $("#card2").click(function(){
            tpay = $("#balance").val();
            $("#pay").val(tpay);
            payCard2();
        });
    });
    function payCard2(){
        $("#pay").val();
        $("#returned").val(0);
        $("#payment_method_id").val(49);
        $("#abpaymenty").hide();
        $("#mpay").hide();
        $("#eventy").hide();
        $("#payi").show();
        $("#banky").show();
        $("#cardy").show();
        $("#advancey").hide();
        $("#transactiony").show();
    }
    $(document).ready(function(){
        $("#noDefined").click(function(){
            tpay = $("#balance").val();
            $("#pay").val(tpay);
            noDefined();
        });
    });
    function noDefined(){
        $("#pay").val();
        $("#returned").val(0);
        $("#payment_method_id").val(1);
        $("#transaction").val("N/A");
        $("#bank_id").val(1);
        $("#card_id").val(1);
        $("#transactiony").show();
        $("#banky").hide();
        $("#cardy").hide();
        $("#payi").show();
        $("#abpaymenty").hide();
        $("#advancey").hide();
        $("#eventy").hide();
        $("#advance").val(0);
    }
    $(document).ready(function(){
        $("#advanceCus").click(function(){
            tpay = $("#balance").val();
            $("#pay").val(tpay);
            advanceCus();
        });
    });
    function advanceCus(){
        $("#pay").val();
        $("#returned").val(0);
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
        $("#advancey").show();
        $("#eventy").hide();
    }
    $(document).ready(function(){
        $("#pay").keyup(function(){
            $("#pay").val();
            $("#returned").val();
            payment();
        });
    });
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
    prueba = [];
    $("#customer_id").change(function(event){
        $.get("getAdvance/" + event.target.value + "", function(response){
            $("#advance_id").empty();
            $("#advance_id").append("<option value = '#' disabled selected>Seleccionar ...</option>");
            for(i = 0; i < response.length; i++){
                $("#advance_id").append("<option value = '" + response[i].id + "'>" + response[i].origin + '  ' + response[i].balance + "</option>");
                prueba = response[i].balance;
            }
            $("#advance_id").selectpicker('refresh');
        });
    });
    $(document).ready(function(){
        $("#advance_id").change(function(){
            parseFloat($("#abpayment").val(prueba))
            $("#abadvancey").show();
            prepaidnew();
        });
    });
    function prepaidnew(){
        ttp = parseFloat($("#total_pay").val())
        abn = parseFloat($("#abpayment").val())
        balancey = ttp - abn;
        if (ttp >= abn) {
            $("#returned").val(balancey);
            $("#pay").val(abn);
            $("#payment").val(abn);
        } else {
            $("#abvto").show();
            //prepaid()
        }
    }
    $(document).ready(function(){
        $("#advance").keyup(function(){
            $("#advance").val();
            prepaid();
        });
    });
    function prepaid(){
        ttpnew = parseFloat($("#total_pay").val())
        abnnew = parseFloat($("#advance").val())
        balanceynew = ttpnew - abnnew;
        if (ttpnew >= abnnew) {
            $("#returned").val(balanceynew);
            $("#advance").val(abnnew);
            $("#pay").val(abnnew);
        } else {
            //alert("Rellene todos los campos del detalle de la venta");
            Swal.fire({
            type: 'error',
            //title: 'Oops...',
            text: 'El abono supera el valor de la compra',
            })
            $("#advance").val(0)
            prepaid();
        }
    }*/
</script>
