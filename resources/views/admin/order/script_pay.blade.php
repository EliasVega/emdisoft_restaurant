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
    //$("#save").hide();
    //form pay button
    $("#payPayment").hide();
    $("#noDefined").hide();
    $("#cash").hide();
    $("#prepay").hide();
    $("#transfer").hide();
    $("#nequi").hide();
    $("#card1").hide();
    $("#card2").hide();

    //$("#transvenped").hide();
    //form pay
    //$("#payBalance").hide();
    //$("#payReturned").hide();
    $("#payPay").hide();
    $("#payAdvance").hide();
    $("#payVadvance").hide();
    $("#payTransaction").hide();
    $("#payBank").hide();
    $("#payCard").hide();
    $("#payAdvanceId").hide();

    $(document).ready(function(){
        $("#payment_form_id").change(function(){
        form = $("#payment_form_id").val();
        if(form == 1){
            $("#noDefined").show();
            $("#cash").show();
            $("#prepay").show();
            $("#transfer").show();
            $("#nequi").show();
            $("#card1").show();
            $("#card2").show();
            $("#mpay").hide();
            $("#payPayment").hide();
        }else{
            $("#payPayment").show();
            $("#noDefined").hide();
            $("#cash").hide();
            $("#prepay").hide();
            $("#transfer").hide();
            $("#nequi").hide();
            $("#card1").hide();
            $("#card2").hide();
            $("#mpay").hide();
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
        $("#prepay").show();
        $("#transfer").show();
        $("#nequi").show();
        $("#card1").show();
        $("#card2").show();
        $("#mpay").hide();
        $("#paypayment").hide();
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
        $("#payBank").hide();
        $("#payCardy").hide();
        $("#payTransaction").hide();
        $("#payPay").show();
        $("#payAdvance").hide();
        $("#payVadvance").hide();
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
        $("#payPay").show();
        $("#payAdvance").hide();
        $("#payTransaction").show();
        $("#payBank").show();
        $("#payCardy").hide();
        $("#mpay").hide();
        $("#eventy").hide();
        $("#payVadvance").hide();
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
        $("#payPay").show();
        $("#payAdvance").hide();
        $("#payTransaction").show();
        $("#payCardy").hide();
        $("#mpay").hide();
        $("#payBank").hide();
        $("#eventy").hide();
        $("#payVadvance").hide();
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
        $("#payAdvance").hide();
        $("#mpay").hide();
        $("#eventy").hide();
        $("#payPay").show();
        $("#payBank").show();
        $("#payCardy").show();
        $("#payVadvance").hide();
        $("#payTransaction").show();
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
        $("#payAdvance").hide();
        $("#mpay").hide();
        $("#eventy").hide();
        $("#payPay").show();
        $("#payBank").show();
        $("#payCardy").show();
        $("#payVadvance").hide();
        $("#payTransaction").show();
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
        $("#payTransaction").show();
        $("#payBank").hide();
        $("#payCardy").hide();
        $("#payPay").show();
        $("#payAdvance").hide();
        $("#payVadvance").hide();
        $("#eventy").hide();
        $("#advance").val(0);
    }
    $(document).ready(function(){
        $("#prepay").click(function(){
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
        $("#payPay").hide();
        $("#payAdvanceId").show();
        $("#payTransaction").hide();
        $("#payCardy").hide();
        $("#mpay").hide();
        $("#payBank").hide();
        $("#payVadvance").show();
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
            parseFloat($("#advance").val(prueba))
            $("#payAdvance").show();
            prepaidnew();
        });
    });
    function prepaidnew(){
        ttp = parseFloat($("#total_pay").val())
        abn = parseFloat($("#advance").val())
        balancey = ttp - abn;
        if (ttp >= abn) {
            $("#returned").val(balancey);
            $("#pay").val(abn);
            $("#payment").val(abn);
        } else {
            $("#payVadvance").show();
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
    }
</script>
