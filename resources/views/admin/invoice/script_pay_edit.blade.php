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
    //form invoice
    //$("#save").hide();
    //form pay
    $("#cash").hide();
    $("#transfer").hide();
    $("#nequi").hide();
    $("#card1").hide();
    $("#card2").hide();
    $("#noDefined").hide();
    $("#transvenped").hide();
    $("#payPayment").hide();
    //$("#payInvoice").hide();

    $("#payPay").hide();
    $("#payTransaction").hide();
    $("#payBank").hide();
    $("#payCard").hide();
    $("#payment_form_id").hide();
    $("#payment_method_id").hide();

    /*
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
                $("#mpay").hide();
                $("#payPayment").hide();
            }else{
                $("#payPayment").show();
                $("#noDefined").hide();
                $("#cash").hide();
                $("#advance").hide();
                $("#transfer").hide();
                $("#nequi").hide();
                $("#card1").hide();
                $("#card2").hide();
                $("#mpay").hide();
                $("#payment_method_id").val(1);

                $("#pay").val();
                $("#returned").val(0);
                $("#transaction").val("N/A");
                $("#bank_id").val(1);
                $("#card_id").val(1);
                $("#advance").val(0);
            }
        });
    });*/
    $(document).ready(function(){
        $("#payPays").click(function(){
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
        $("#payPayment").hide();
    }
    $(document).ready(function(){
        $("#cash").click(function(){
            totalInvoice = $("#balance").val();
            totalPay = $("#pay_invoice").val();
            tpay = totalInvoice - totalPay;
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
        $("#payCard").hide();
        $("#payTransaction").hide();
        $("#payPay").show();
    }
    $(document).ready(function(){
        $("#transfer").click(function(){
            totalInvoice = $("#balance").val();
            totalPay = $("#pay_invoice").val();
            tpay = totalInvoice - totalPay;
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
        $("#payTransaction").show();
        $("#payBank").show();
        $("#payCard").hide();
        $("#mpay").hide();
    }
    $(document).ready(function(){
        $("#nequi").click(function(){
            totalInvoice = $("#balance").val();
            totalPay = $("#pay_invoice").val();
            tpay = totalInvoice - totalPay;
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
        $("#payTransaction").show();
        $("#payCard").hide();
        $("#mpay").hide();
        $("#payBank").hide();
    }
    $(document).ready(function(){
        $("#card1").click(function(){
            totalInvoice = $("#balance").val();
            totalPay = $("#pay_invoice").val();
            tpay = totalInvoice - totalPay;
            $("#pay").val(tpay);
            payCard1();
        });
    });
    function payCard1(){
        $("#pay").val();
        $("#returned").val(0);
        $("#payment_method_id").val(48);
        $("#mpay").hide();
        $("#payPay").show();
        $("#payBank").show();
        $("#payCard").show();
        $("#payTransaction").show();
    }
    $(document).ready(function(){
        $("#card2").click(function(){
            totalInvoice = $("#balance").val();
            totalPay = $("#pay_invoice").val();
            tpay = totalInvoice - totalPay;
            $("#pay").val(tpay);
            payCard2();
        });
    });
    function payCard2(){
        $("#pay").val();
        $("#returned").val(0);
        $("#payment_method_id").val(49);
        $("#mpay").hide();
        $("#payPay").show();
        $("#payBank").show();
        $("#payCard").show();
        $("#payTransaction").show();
    }
    $(document).ready(function(){
        $("#noDefined").click(function(){
            totalInvoice = $("#balance").val();
            totalPay = $("#pay_invoice").val();
            tpay = totalInvoice - totalPay;
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
        $("#payCard").hide();
        $("#payPay").show();
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
        tpi = parseFloat($("#pay_invoice").val())
        abn = parseFloat($("#pay").val())
        tpiabn = tpi + abn;
        balancey = ttp - (tpi + abn);
        if (ttp >= tpiabn) {
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
