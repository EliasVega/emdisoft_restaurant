<script>
    /*$(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });*/
        jQuery(document).ready(function($){
            $(document).ready(function() {
                $('#supplier_id').select2({
                    theme: "classic",
                    width: "100%",
                });
            });
        });
        jQuery(document).ready(function($){
            $(document).ready(function() {
                $('#bank_id').select2({
                    theme: "classic",
                    width: "100%",
                });
            });
        });
        jQuery(document).ready(function($){
            $(document).ready(function() {
                $('#card_id').select2({
                    theme: "classic",
                    width: "100%",
                });
            });
        });
        var cont=0;
        total=0;
        $("#save").hide();
        $("#banky").hide();
        $("#cardy").hide();
        $("#transactiony").hide();
        $("#mpay").hide();
        $("#payi").hide();

        $(document).ready(function(){
            $("#add").click(function(){
                add();
            });
        });
        function add(){
            payment_method_id = $("#payment_method_id").val();
            payment_method    = $("#payment_method_id option:selected").text();
            bank_id     = $("#bank_id").val();
            bank        = $("#bank_id option:selected").text();
            card_id   = $("#card_id").val();
            card      = $("#card_id option:selected").text();
            pay        = $("#pay").val();
            transaction  = $("#transaction").val();


            if(payment_method_id !="" && bank_id!="" && card_id!=""  && pay!="" && pay>0 && transaction!=""){

                total = parseFloat(total) + parseFloat(pay);

                var fila= '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td> <td><input type="hidden" name="payment_method_id[]" value="'+payment_method_id+'">'+payment_method+'</td> <td><input type="hidden" name="card_id[]" value="'+card_id+'">'+card+'</td> <td><input type="hidden" name="bank_id[]" value="'+bank_id+'">'+bank+'</td> <td><input type="hidden" name="transaction[]" value="'+transaction+'">'+transaction+'</td> <td class="tdder"><input type="hidden" name="pay[]" value="'+pay+'">'+pay+'</td>  </tr>';
                cont++;

                totals();
                assess();
                $('#details').append(fila);
                clean();
            } else {
                //alert("Rellene todos los campos del detalle de la venta");
                Swal.fire({
                type: 'error',
                //title: 'Oops...',
                text: 'Rellene todos los campos del detalle de la Pedido',
                });
            }
        }
        function clean(){
            $("#payment_method_id").val("");
            $("#bank_id").val("");
            $("#card_id").val("");
            $("#pay").val("");
            $("#transaction").val("");
            $("#banky").hide();
            $("#cardy").hide();
            $("#transactiony").hide();
            $("#mpay").hide();
            $("#payi").hide();
        }
        function totals(){
            $("#total_html").html("$ " + total.toFixed(2));
            $("#total").val(total.toFixed(2));
        }
        function assess(){

            if(total>0){
                $("#save").show();
            } else{
                $("#save").hide();
            }
        }
        function eliminar(index){

            total = total-pay[index];

            $("#total_html").html("$ " + total.toFixed(2));
            $("#total").val(total.toFixed(2));

            $("#fila" + index).remove();
            assess();
        }

        $(document).ready(function(){
            $("#noDefined").click(function(){
                $("#pay").val("");
                noDefined();
            });
        });
        function noDefined(){
            $("#payi").show();
            $("#transaction").val('Metodo No definido');
            $("#bank_id").val(1);
            $("#card_id").val(1);
            $("#banky").hide();
            $("#cardy").hide();
            $("#transactiony").hide();
            $("#payment_method_id").val(1);
        }

        $(document).ready(function(){
            $("#cash").click(function(){
                $("#pay").val("");
                payCash();
            });
        });
        function payCash(){
            $("#payi").show();
            $("#transaction").val("Efectivo");
            $("#bank_id").val(1);
            $("#card_id").val(1);
            $("#transactiony").hide();
            $("#banky").hide(1);
            $("#cardy").hide(1);
            $("#payment_method_id").val(10);
        }

        $(document).ready(function(){
            $("#card1").click(function(){
                $("#pay").val("");
                payCard1();
            });
        });
        function payCard1(){
            $("#payi").show();
            $("#banky").show();
            $("#cardy").show();
            $("#transactiony").show();
            $("#payment_method_id").val(48);
        }

        $(document).ready(function(){
            $("#card2").click(function(){
                $("#pay").val("");
                payCard2();
            });
        });
        function payCard2(){
            $("#payi").show();
            $("#banky").show();
            $("#cardy").show();
            $("#transactiony").show();
            $("#payment_method_id").val(49);
        }

        $(document).ready(function(){
            $("#transfer").click(function(){
                $("#pay").val("");
                payTransaction();
            });
        });
        function payTransaction(){
            $("#payi").show();
            $("#card_id").val(1);
            $("#transactiony").show();
            $("#banky").show();
            $("#cardy").hide();
            $("#payment_method_id").val(47);
        }

        $(document).ready(function(){
            $("#nequi").click(function(){
                $("#pay").val("");
                payNequi();
            });
        });
        function payNequi(){
            $("#bank_id").val(2);
            $("#card_id").val(1);
            $("#payi").show();
            $("#transactiony").show();
            $("#cardy").hide();
            $("#banky").hide();
            $("#payment_method_id").val(47);
        }
</script>
