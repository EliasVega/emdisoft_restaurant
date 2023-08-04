<script>
    /*$(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });*/
    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#menu_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });

    var cont = 0;
    var total = 0;
    var subtotal = [];
    var total_inc = 0;
    var total_pay = 0;
    var total_desc = 0;
    var ret = 0;
    var vrte = 0;
    //form purchase
    $("#editIdmenu").hide();
    $("#editPercentageId").hide();
    $("#editPercentage").hide();
    $("#save").hide();
    //$("#addDocument").hide();

    function totals(){
        var total_pay = total + total_inc;

        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));

        $("#total_inc_html").html("$ " + total_inc.toFixed(2));
        $("#total_inc").val(total_inc.toFixed(2));

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


    //function editing(){
        invoice = {!! json_encode($menuOrders) !!};
        invoice.forEach((value, i) => {
            if (value['quantity'] > 0) {

                id = value['id'];
                menu_id= value['idM'];
                menu= value['name'];
                quantity= value['quantity'];
                price= value['price'];
                inc= value['inc'];
                balance = value['balance'];

                if(menu_id !="" && quantity!="" && quantity>0  && price!="" && price>0){
                    subtotal[cont]= parseFloat(quantity) * parseFloat(price);
                    total= total+subtotal[cont];
                    ivita= subtotal[cont]*inc/100;
                    total_inc=total_inc+ivita;

                    var row= '<tr class="selected" id="row'+cont+'"><td><input type="hidden" name="id[]"  value="'+menu_id+'">'+menu_id+'</td><td><input type="hidden" name="menu_id[]" value="'+menu_id+'">'+menu+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td><input type="hidden" name="inc[]"  value="'+inc+'">'+inc+'</td><td>$'+subtotal[cont]+' </td></tr>';
                    cont++;

                    totals();
                    assess();
                    $('#details').append(row);
                }else{
                    //alert("Rellene todos los campos del detalle para esta compra");
                    Swal.fire({
                    type: 'error',
                    //title: 'Oops...',
                    text: 'Rellene todos los campos del detalle para esta Venta',
                    })
                }
            }
        });
    //}
</script>
