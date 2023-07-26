<script>
    /*$(document).ready(function(){
        alert('estoy funcionando correctamanete empresa');
    });*/

        //Selecciona el municipio de acuerdo al departamento
    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#category_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });
    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#unit_measure_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });
    var cont=0;
    var total = 0;
    var subtotal = [];

    $("#raw_material_id").change(productValue);

    function productValue(){
        dataProduct = document.getElementById('raw_material_id').value.split('_');
        $("#consumer_price").val(dataProduct[1]);
    }
    $(document).ready(function(){
        $("#add").click(function(){
            add();
        });
    });
    function add(){
        raw_material_id = dataProduct[0];
        raw_material = $("#raw_material_id option:selected").text();
        quantity = $("#quantity").val();
        consumer_price = $("#consumer_price").val();

        if(raw_material_id !="" && raw_material!="" && quantity!="" && quantity>0 && consumer_price!="" && consumer_price>0){
            subtotal[cont]= parseFloat(quantity) * parseFloat(consumer_price);
            total = total + subtotal[cont];

            var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="destroy('+cont+');"><i class="fa fa-times"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td> <td><input type="hidden" name="raw_material_id[]" value="'+raw_material_id+'">'+raw_material+'</td> <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="consumer_price[]" value="'+consumer_price+'">'+consumer_price+'</td><td>$'+subtotal[cont]+' </td></tr>';
            cont++;
            totals();
            $('#materials').append(row);
            clear();
        } else {
            //alert("Rellene todos los campos del detalle de la venta");
            Swal.fire({
            type: 'error',
            //title: 'Oops...',
            text: 'Rellene todos los campos',
            });
        }
    }
    function totals(){

        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));
    }
    function clear(){
        $("#raw_material_id").val("");
        $("#quantity").val("");
        $("#consumer_price").val("");
    }
</script>
