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
    $("#cash").hide();
    $("#transfer").hide();
    $("#nequi").hide();
    $("#card1").hide();
    $("#card2").hide();
    $("#noDefined").hide();

    $("#payi").hide();
    $("#abpaymenty").hide();
    $("#abvto").hide();
    $("#transactiony").hide();
    $("#banky").hide();
    $("#cardy").hide();

    $(document).ready(function(){
        $("#payment_form_id").change(function(){
        form = $("#payment_form_id").val();
        if(form == 1){
            $("#noDefined").show();
            $("#cash").show();
            $("#transfer").show();
            $("#nequi").show();
            $("#card1").show();
            $("#card2").show();
            $("#addPays").hide();
        }else{
            $("#addPays").show();
            $("#noDefined").hide();
            $("#cash").hide();
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
        $("#payment").val(0);
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
</script>
