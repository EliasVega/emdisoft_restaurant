<script>
    /*$(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });*/
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
    var total_iva = 0;
    var total_pay = 0;
    //form purchase
    $("#editIva").hide();
    $("#save").hide();


    $("#service_id").change(serviceValue);

    function serviceValue(){
        dataService = document.getElementById('service_id').value.split('_');
        $("#iva").val(dataService[1]);
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
        iva= $("#iva").val();
        if(service_id !="" && quantity!="" && quantity>0  && price!="" && price > 0){
            subtotal[cont]= parseFloat(quantity) * parseFloat(price);
            total= total+subtotal[cont];
            ivita= subtotal[cont]*iva/100;
            total_iva=total_iva+ivita;

            var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm btndelete" onclick="deleterow('+cont+');"><i class="fas fa-trash"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="id[]"  value="'+service_id+'">'+service_id+'</td><td><input type="hidden" name="service_id[]" value="'+service_id+'">'+service+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td><input type="hidden" name="iva[]"  value="'+iva+'">'+iva+'</td><td>$'+subtotal[cont]+' </td></tr>';

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
        $("#iva").val("");
    }
    function totals(){
        var total_pay = total + total_iva;

        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));

        $("#total_iva_html").html("$ " + total_iva.toFixed(2));
        $("#total_iva").val(total_iva.toFixed(2));

        $("#total_pay_html").html("$ " + total_pay.toFixed(2));
        $("#total_pay").val(total_pay.toFixed(2));

        $("#balance").val(total_pay.toFixed(2));
    }

    function deleterow(index){

        total = total-subtotal[index];
        total_iva= total*iva/100;
        total_pay = total + total_iva;

        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));

        total_pay=total+total_iva;
        $("#total_iva_html").html("$ " + total_iva.toFixed(2));
        $("#total_iva").val(total_iva.toFixed(2));

        $("#total_pay_html").html("$ " + total_pay.toFixed(2));
        $("#total_pay").val(total_pay.toFixed(2));

        $("#balance").val(total_pay);
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
            $("#service_idModal").val(row.find("td:eq(2)").text());
            $("#serviceModal").val(row.find("td:eq(3)").text());
            $("#quantityModal").val(row.find("td:eq(4)").text());
            $("#priceModal").val(row.find("td:eq(5)").text());
            $("#ivaModal").val(row.find("td:eq(6)").text());
            $("#subtotalModal").val(row.find("td:eq(7)").text());

            // Mostrar modal
            $('#editModal').modal('show');

        }
    }

    jQuery(document).on("click", "#updateExpense", function () {
        updaterow();
    });

    function updaterow() {

        // Buscar datos en la fila y asignar a campos del formulario:
        // Primera columna (0) tiene ID, segunda (1) tiene nombre, tercera (2) capacidad
        contedit = $("#contModal").val();
        //id = $("#idModal").val();
        service_id = $("#service_idModal").val();
        service = $("#serviceModal").val();
        quantity = $("#quantityModal").val();
        price = $("#priceModal").val();
        iva = $("#ivaModal").val();

        $('#priceModal').prop("readonly", true)

        if(service_id !="" && quantity!="" && quantity>0 && price!="" && price>0){
            subtotal[cont]= parseFloat(quantity) * parseFloat(price);
            total= total+subtotal[cont];
            ivita= subtotal[cont]*iva/100;
            total_iva=total_iva+ivita;

            var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm btndelete" onclick="deleterow('+cont+');"><i class="fas fa-trash"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="id[]"  value="'+service_id+'">'+service_id+'</td><td><input type="hidden" name="service_id[]" value="'+service_id+'">'+service+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td><input type="hidden" name="iva[]"  value="'+iva+'">'+iva+'</td><td>$'+subtotal[cont]+' </td></tr>';

            cont++;
            deleterow(contedit);
            totals();
            assess();
            $('#details').append(row);
            $('#editModal').modal('hide');
            //$('#service_id option:selected').remove();
        }else{
            // alert("Rellene todos los campos del detalle de la compra, revise los datos del serviceo");
            Swal.fire({
                type: 'error',
                //title: 'Oops...',
                text: 'Rellene todos los campos del detalle de la compra',
            })
        }
    }

    //function editing(){
        expense = {!! json_encode($expenseServices) !!};
        expense.forEach((value, i) => {
            if (value['quantity'] > 0) {

                service_id= value['id'];
                service= value['name'];
                quantity= value['quantity'];
                price= value['price'];
                iva= value['iva'];
                balance = value['balance'];

                if(service_id !="" && quantity!="" && quantity>0  && price!="" && price>0){
                    subtotal[cont]= parseFloat(quantity) * parseFloat(price);
                    total= total+subtotal[cont];
                    ivita= subtotal[cont]*iva/100;
                    total_iva=total_iva+ivita;

                    var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm btndelete" onclick="deleterow('+cont+');"><i class="fas fa-trash"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="id[]"  value="'+service_id+'">'+service_id+'</td><td><input type="hidden" name="service_id[]" value="'+service_id+'">'+service+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td><input type="hidden" name="iva[]"  value="'+iva+'">'+iva+'</td><td>$'+subtotal[cont]+' </td></tr>';
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
                    text: 'Rellene todos los campos del detalle para esta Venta',
                    })
                }
            }
        });
    //}
    function detailclear(){
        expense = {!! json_encode($expenseServices) !!};
        expense.forEach((value, i) => {
            if (value['quantity'] > 0) {
                deleterow(i);
            }
        });
    }
</script>
