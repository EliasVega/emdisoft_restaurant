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
    let  cont=0;
    let  total = 0;
    let subtotal = [];
    let total_inc = 0;
    //form Order
    $("#save").hide();

    $("#menu_id").change(menuValue);

    function menuValue(){
        datamenu = document.getElementById('menu_id').value.split('_');
        $("#sale_price").val(datamenu[1]);
        $("#inc").val(datamenu[2]);
        $("#suggested_price").val(datamenu[1]);
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
        ed = 2;
        if(menu_id !="" && quantity!="" && quantity>0  && price!="" && inc!=""){
            subtotal[cont]= parseFloat(quantity) * parseFloat(price);
            total= total+subtotal[cont];
            inca= subtotal[cont]*inc/100;
            total_inc=total_inc+inca;

            var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm btndelete" onclick="deleterow('+cont+');"><i class="fas fa-trash"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="ed[]" value="'+ed+'">'+ed+'</td><td><input type="hidden" name="id[]" value="'+menu_id+'">'+menu_id+'</td><td><input type="hidden" name="menu_id[]" value="'+menu_id+'">'+menu+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td><input type="hidden" name="inc[]"  value="'+inc+'">'+inc+'</td><td>$'+subtotal[cont]+' </td></tr>';

            cont++;

            totals();
            assess();
            $('#details').append(row);
            //$('#menu_id option:selected').remove();
            clean();


        }else{
            //alert("Rellene todos los campos del detalle de la venta");
            Swal.fire({
            type: 'error',
            //title: 'Oops...',
            text: 'Rellene todos los campos del detalle de este pedido',
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

    function deleterow(index){

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

    function assess(){

    if(total>0){
        $("#save").show();

        } else{
            $("#save").hide();
        }
    }

    //function editing(){
        order = {!! json_encode($menuOrders) !!};
        order.forEach((value, i) => {
            if (value['quantity'] > 0) {

                menu_id = value['idM'];
                menu= value['name'];
                quantity= value['quantity'];
                price= value['price'];
                inc= value['inc'];
                ed = 1;

                if(menu_id !="" && quantity!="" && quantity>0  && price!="" && price>0){
                    subtotal[cont]= parseFloat(quantity) * parseFloat(price);
                    total= total+subtotal[cont];
                    inca= subtotal[cont]*inc/100;
                    total_inc=total_inc+inca;

                    var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm btndelete" onclick="deleterow('+cont+');"><i class="fas fa-trash"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="ed[]" value="'+ed+'">'+ed+'</td><td><input type="hidden" name="id[]" value="'+menu_id+'">'+menu_id+'</td><td><input type="hidden" name="menu_id[]" value="'+menu_id+'">'+menu+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td><input type="hidden" name="inc[]"  value="'+inc+'">'+inc+'</td><td>$'+subtotal[cont]+' </td></tr>';
                    cont++;

                    totals();
                    assess();
                    $('#details').append(row);
                    //$('#menu_id option:selected').remove();
                    clean();
                }else{
                    //alert("Rellene todos los campos del detalle para esta compra");
                    Swal.fire({
                    type: 'error',
                    //title: 'Oops...',
                    text: 'Rellene todos los campos del detalle para esta compra',
                    })
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
            $("#menu_idModal").val(row.find("td:eq(2)").text());
            $("#menuModal").val(row.find("td:eq(3)").text());
            $("#quantityModal").val(row.find("td:eq(4)").text());
            $("#priceModal").val(row.find("td:eq(5)").text());
            $("#incModal").val(row.find("td:eq(6)").text());
            $("#subtotalModal").val(row.find("td:eq(7)").text());

            // Mostrar modal
            $('#editModal').modal('show');
        }
    }

    jQuery(document).on("click", "#updateOrder", function () {
        updaterow();
    });

    function updaterow() {
        // Buscar datos en la fila y asignar a campos del formulario:
        // Primera columna (0) tiene ID, segunda (1) tiene nombre, tercera (2) capacidad
        contedit = $("#contModal").val();
        //id = $("#idModal").val();
        menu_id = $("#menu_idModal").val();
        menu = $("#menuModal").val();
        quantity = $("#quantityModal").val();
        price = $("#priceModal").val();
        inc = $("#incModal").val();
        ed = 1;

        $('#priceModal').prop("readonly", false)

        if(menu_id !="" && quantity!="" && quantity>0 && price!="" && price>0){
            subtotal[cont]= parseFloat(quantity) * parseFloat(price);
            total= total+subtotal[cont];
            inca= subtotal[cont]*inc/100;
            total_inc=total_inc+inca;

            var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm btndelete" onclick="deleterow('+cont+');"><i class="fas fa-trash"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="ed[]" value="'+ed+'">'+ed+'</td><td><input type="hidden" name="id[]" value="'+menu_id+'">'+menu_id+'</td><td><input type="hidden" name="menu_id[]" value="'+menu_id+'">'+menu+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td><input type="hidden" name="inc[]"  value="'+inc+'">'+inc+'</td><td>$'+subtotal[cont]+' </td></tr>';
            cont++;
            deleterow(contedit);
            totals();
            assess();
            $('#details').append(row);
            $('#editModal').modal('hide');
            //$('#menu_id option:selected').remove();
        }else{
            // alert("Rellene todos los campos del detalle de la compra, revise los datos del menuo");
            Swal.fire({
                type: 'error',
                //title: 'Oops...',
                text: 'Rellene todos los campos del detalle de la compra',
            })
        }
    }
    function detailclear(){
        order = {!! json_encode($menuOrders) !!};
        order.forEach((value, i) => {
            if (value['quantity'] > 0) {
                deleterow(i);
            }
        });
    }
</script>
