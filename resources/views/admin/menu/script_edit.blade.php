<script>
    /*$(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });*/
    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#product_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });

    var cont = 0;
    var total = 0;
    var subtotal = [];
    var total_pay = 0;
    //form purchase
    $("#save").hide();

    $("#product_id").change(productValue);

    function productValue(){
        dataProduct = document.getElementById('product_id').value.split('_');
        $("#consumer_price").val(dataProduct[1]);
    }
    $(document).ready(function(){
        $("#add").click(function(){
            add();
        });
    });
    function add(){
        product_id = dataProduct[0];
        product = $("#product_id option:selected").text();
        quantity = $("#quantity").val();
        consumer_price = $("#consumer_price").val();

        if(product_id !="" && product!="" && quantity!="" && quantity>0 && consumer_price!="" && consumer_price>0){
            subtotal[cont]= parseFloat(quantity) * parseFloat(consumer_price);
            total = total + subtotal[cont];

            var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="destroy('+cont+');"><i class="fa fa-times"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="id[]" value="'+product_id+'">'+product_id+'</td> <td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td> <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="consumer_price[]" value="'+consumer_price+'">'+consumer_price+'</td><td>$'+subtotal[cont]+' </td></tr>';
            cont++;
            totals();
            $('#materials').append(row);
            clear();
            assess();
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
        $("#product_id").val("");
        $("#quantity").val("");
        $("#consumer_price").val("");
    }

    function assess(){

        if(total>0){
            $("#save").show();
        } else{
            $("#save").hide();
        }
    }
    function deleterow(index){
        total = total-subtotal[index];
        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));

        $("#row" + index).remove();
        assess();
    }

    //function editing(){
        menu = {!! json_encode($menuProducts) !!};
        menu.forEach((value, i) => {
            if (value['quantity'] > 0) {

                id = value['id'];
                product_id= value['idP'];
                product= value['name'];
                quantity= value['quantity'];
                consumer_price= value['consumer_price'];

                if(product_id !="" && product!="" && quantity!="" && quantity>0 && consumer_price!="" && consumer_price>0){
                    subtotal[cont]= parseFloat(quantity) * parseFloat(consumer_price);
                    total = total + subtotal[cont];

                    var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="destroy('+cont+');"><i class="fa fa-times"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="id[]" value="'+product_id+'">'+product_id+'</td> <td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td> <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="consumer_price[]" value="'+consumer_price+'">'+consumer_price+'</td><td>$'+subtotal[cont]+' </td></tr>';
                    cont++;
                    totals();
                    $('#materials').append(row);
                    clear();
                    assess();
                } else {
                    //alert("Rellene todos los campos del detalle de la venta");
                    Swal.fire({
                    type: 'error',
                    //title: 'Oops...',
                    text: 'Rellene todos los campos',
                    });
                }
            }
        });
    //}
    jQuery(document).on("click", "#editrow", function () {
        editrow();
    });

    function editrow(index) {

        $("#contMod").hide();
        $("#subtotalMod").hide();
        $("#idMod").hide();

        // Obtener la fila
        var row = $("#row" + index);
        // Solo si la fila existe
        if(row) {

            // Buscar datos en la fila y asignar a campos del formulario:
            // Primera columna (0) tiene ID, segunda (1) tiene nombre, tercera (2) capacidad
            $("#contModal").val(index);
            $("#idModal").val(row.find("td:eq(2)").text());
            $("#product_idModal").val(row.find("td:eq(2)").text());
            $("#productModal").val(row.find("td:eq(3)").text());
            $("#quantityModal").val(row.find("td:eq(4)").text());
            $("#consumer_priceModal").val(row.find("td:eq(5)").text());
            $("#subtotalModal").val(row.find("td:eq(7)").text());

            // Mostrar modal
            $('#editModal').modal('show');
        }
    }

    jQuery(document).on("click", "#updatePurchase", function () {
        updaterow();
    });

    function updaterow() {

        // Buscar datos en la fila y asignar a campos del formulario:
        // Primera columna (0) tiene ID, segunda (1) tiene nombre, tercera (2) capacidad
        contedit = $("#contModal").val();
        //id = $("#idModal").val();
        product_id = $("#product_idModal").val();
        product = $("#productModal").val();
        quantity = $("#quantityModal").val();
        consumer_price = $("#consumer_priceModal").val();

        $('#priceModal').prop("readonly", false)

        if(product_id !="" && product!="" && quantity!="" && quantity>0 && consumer_price!="" && consumer_price>0){
            subtotal[cont]= parseFloat(quantity) * parseFloat(consumer_price);
            total = total + subtotal[cont];

            var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="destroy('+cont+');"><i class="fa fa-times"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="id[]" value="'+product_id+'">'+product_id+'</td> <td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td> <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="consumer_price[]" value="'+consumer_price+'">'+consumer_price+'</td><td>$'+subtotal[cont]+' </td></tr>';
            cont++;
            deleterow(contedit);
            totals();
            assess();
            $('#materials').append(row);
            $('#editModal').modal('hide');
        } else {
            //alert("Rellene todos los campos del detalle de la venta");
            Swal.fire({
            type: 'error',
            //title: 'Oops...',
            text: 'Rellene todos los campos',
            });
        }
    }


    function detailclear(){
        menu = {!! json_encode($menuProducts) !!};
        menu.forEach((value, i) => {
            if (value['quantity'] > 0) {
                deleterow(i);
            }
        });
    }
</script>
