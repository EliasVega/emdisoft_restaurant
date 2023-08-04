<script>
    /*$(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });*/
    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#branch_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });
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
            $('#service_id').select2({
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
    //form purchase
    $("#addInc").hide();
    $("#save").hide();

    $("#service_id").change(serviceValue);

    function serviceValue(){
        dataService = document.getElementById('service_id').value.split('_');
        $("#inc").val(dataService[1]);
    }
    $(document).ready(function(){
        $("#add").click(function(){
            add();
        });
    });
    function add(){
        dataService = document.getElementById('service_id').value.split('_');
        service_id= dataService[0];
        service= $("#service_id option:selected").text();
        quantity= $("#quantity").val();
        price= $("#price").val();
        inc= $("#inc").val();

        if(service_id !="" && quantity!="" && quantity>0  && price!="" && price > 0){
            subtotal[cont]= parseFloat(quantity) * parseFloat(price);
            total= total+subtotal[cont];
            ivita= subtotal[cont]*inc/100;
            total_inc=total_inc+ivita;

            var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td><td><input type="hidden" name="service_id[]" value="'+service_id+'">'+service+'</td> <td><input type="hidden" id="quantity" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" id="price" name="price[]" value="'+parseFloat(price).toFixed(2)+'">'+price+'</td> td> <td><input type="hidden" name="inc[]" value="'+inc+'">'+inc+'</td>  <td> $'+parseFloat(subtotal[cont]).toFixed(2)+'</td></tr>';
            cont++;

            totals();
            assess();
            $('#details').append(row);
            $('#service_id option:selected').remove();
            clean();


        }else{
            //alert("Rellene todos los campos del detalle para esta compra");
            Swal.fire({
            type: 'error',
            //title: 'Oops...',
            text: 'Revise los campos son nulos o negativos',
            })
        }
    }

    function clean(){
        $("#service_id").val("");
        $("#quantity").val("");
        $("#price").val("");
    }
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

        $("#row" + index).remove();
        assess();
    }
</script>
