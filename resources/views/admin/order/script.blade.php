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
            $('#menu_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });
    var cont=0;
    total=0;
    subtotal=[];
    total_inc=0;
    //form invoice
    $("#addmenuId").hide();
    $("#homeOrder").hide();

    $("#menu_id").change(menuValue);

    function menuValue(){
        datamenu = document.getElementById('menu_id').value.split('_');
        $("#sale_price").val(datamenu[1]);
        $("#suggested_price").val(datamenu[1]);
        $("#inc").val(datamenu[2]);

    }
    $(document).ready(function(){
        $("#add").click(function(){
            add();
        });
    });
    function add(){
        datamenu = document.getElementById('menu_id').value.split('_');
        menu_id= datamenu[0];
        menu= $("#menu_id option:selected").text();
        quantity= $("#quantity").val();
        price= $("#sale_price").val();
        inc= $("#inc").val();

        if(menu_id !="" && quantity!="" && quantity>0  && price!="" && inc!=""){
            subtotal[cont]= parseFloat(quantity) * parseFloat(price);
            total= total+subtotal[cont];
            ivita= subtotal[cont]*inc/100;
            total_inc=total_inc+ivita;

            var fila= '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td><td><input type="hidden" name="menu_id[]" value="'+menu_id+'">'+menu+'</td> <td><input type="hidden" id="quantity" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" id="price" name="price[]" value="'+parseFloat(price).toFixed(2)+'">'+price+'</td> td> <td><input type="hidden" name="inc[]" value="'+inc+'">'+inc+'</td>  <td> $'+parseFloat(subtotal[cont]).toFixed(2)+'</td></tr>';
            cont++;

            totals();
            assess();
            $('#details').append(fila);
            //$('#menu_id option:selected').remove();
            clean();
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
        $("#menu_id").val("");
        $("#quantity").val("");
        $("#sale_price").val("");
    }
    function totals(){

        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));

        total_pay=total+total_inc;
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
    function eliminar(index){

        total = total-subtotal[index];
        total_inc= total*inc/100;
        total_pay = total + total_inc;

        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));

        total_pay=total+total_inc;
        $("#total_inc_html").html("$ " + total_inc.toFixed(2));
        $("#total_inc").val(total_inc.toFixed(2));

        $("#total_pay_html").html("$ " + total_pay.toFixed(2));
        $("#total_pay").val(total_pay.toFixed(2));

        $("#fila" + index).remove();
        assess();
    }
    $(document).ready(function(){
        $("#checkbox1").click(function(){
            $("#createTable").show();
            $("#homeOrder").hide();
        });
    });

    $(document).ready(function(){
        $("#checkbox2").click(function(){
            $("#homeOrder").show();
            $("#createTable").hide();
        });
    });

    $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    });
</script>
