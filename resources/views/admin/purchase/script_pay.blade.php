<script>
    /*$(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });*/
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
    //form purchase
    $("#save").hide();
    //form pay
    $("#addPays").hide();
    $("#noDefined").hide();
    $("#cash").hide();
    $("#advance").hide();
    $("#transfer").hide();
    $("#nequi").hide();
    $("#card1").hide();
    $("#card2").hide();

    $("#transvenped").hide();

    $("#payi").hide();
    $("#abpaymenty").hide();
    $("#abvto").hide();
    $("#transactiony").hide();
    $("#banky").hide();
    $("#cardy").hide();
    //$("#paymenty").hide();
    $("#addAdvance").hide();

    $(document).ready(function(){
        $("#payment_form_id").change(function(){
        form = $("#payment_form_id").val();
        if(form == 1){
            $("#noDefined").show();
            $("#cash").show();
            $("#advance").show();
            $("#transfer").show();
            $("#nequi").show();
            $("#card1").show();
            $("#card2").show();
            $("#addPays").hide();
        }else{
            $("#addPays").show();
            $("#noDefined").hide();
            $("#cash").hide();
            $("#advance").hide();
            $("#transfer").hide();
            $("#nequi").hide();
            $("#card1").hide();
            $("#card2").hide();
            $("#payment_method_id").val(1);
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
        $("#advance").show();
        $("#transfer").show();
        $("#nequi").show();
        $("#card1").show();
        $("#card2").show();
        $("#mpay").hide();
        $("#addpays").hide();

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
        $("#transactiony").hide();
        $("#banky").hide();
        $("#cardy").hide();
        $("#payi").show();
        $("#abpaymenty").hide();
        $("#addAdvance").hide();
        $("#payment").val(0);
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
        $("#addAdvance").hide();
        $("#payment").val(0);
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
        $("#addAdvance").hide();
        $("#payment").val(0);
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
        $("#addAdvance").hide();
        $("#payi").show();
        $("#banky").show();
        $("#cardy").show();
        $("#transactiony").show();
        $("#payment").val(0);
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
        $("#addAdvance").hide();
        $("#payi").show();
        $("#banky").show();
        $("#cardy").show();
        $("#transactiony").show();
        $("#payment").val(0);
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
        $("#abpaymenty").hide();//valor del anticipo
        $("#addAdvance").hide();//modelo
        $("#payment").val(0);
    }

    $(document).ready(function(){
        $("#advance").click(function(){
            $("#pay").val("");
            advance();
        });
    });

    function advance(){
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
        $("#addAdvance").show();
    }
    $(document).ready(function(){
        $("#pay").keyup(function(){
            $("#pay").val();
            $("#returned").val();
            paymentor();
        });
    });

    function paymentor(){
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
            text: 'El abono supera el valor de la compra',
            })
            $("#pay").val(0)
            paymentor();
        }
    }

    prueba = [];
    $("#supplier_id").change(function(event){
        $.get("getPayment/" + event.target.value + "", function(response){
            $("#payment_id").empty();
            $("#payment_id").append("<option value = '#' disabled selected>Seleccionar ...</option>");
            for(i = 0; i < response.length; i++){
                $("#payment_id").append("<option value = '" + response[i].id + "'>" + response[i].origin + response[i].balance + "</option>");
                prueba = response[i].balance;
            }
            $("#payment_id").selectpicker('refresh');
        });
    });

    $(document).ready(function(){
        $("#payment_id").change(function(){
            parseFloat($("#abpayment").val(prueba))
            $("#abpaymenty").show();
            prepaidnew();
        });
    });

    $(document).ready(function(){
        $("#payment").keyup(function(){
            $("#payment").val();
            prepaid();
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

    function prepaid(){
        ttpnew = parseFloat($("#total_pay").val())
        abnnew = parseFloat($("#payment").val())
        balanceynew = ttpnew - abnnew;
        if (ttpnew >= abnnew) {
            $("#returned").val(balanceynew);
            $("#payment").val(abnnew);
            $("#pay").val(abnnew);
        } else {
            //alert("Rellene todos los campos del detalle de la venta");
            Swal.fire({
            type: 'error',
            //title: 'Oops...',
            text: 'El abono supera el valor de la compra',
            })
            $("#payment").val(0)
            prepaid();
        }
    }
</script>
