<script>
    /*$(document).ready(function(){
            alert('estoy funcionando correctamanete empresa');
        });*/
    jQuery(document).ready(function($){
        $(document).ready(function() {
            $('#percentage_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });
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
            $('#product_id').select2({
                theme: "classic",
                width: "100%",
            });
        });
    });
    let  cont=0;
    let  total = 0;
    let subtotal = [];
    let total_iva = 0;
    let ret = 0;
    //form Order
    $("#save").hide();
    $("#editIdp").hide();
    $("#editPercentage").hide();


    //form pay button
    //$("#rtferase").hide();

    $(document).ready(function(){
        $("#rtfon").click(function(){
            $("#editPercentage").show();
            //$("#rtferase").show();
            $("#editVpercentage").show();
        });
    });
    $(document).ready(function(){
        $("#rtfoff").click(function(){
            $("#editPercentage").hide();
            //$("#rtferase").hide();
            $("#editVpercentage").hide();
        });
    });
    $("#percentage_id").change(percentageVer);

    function percentageVer(){
        datapercentage = document.getElementById('percentage_id').value.split('_');
        $("#percentage_id").val(datapercentage[0]);
        $("#percentage").val(datapercentage[1]);
        percentages();
    }

    function percentages(){
        $("#editPercentage").hide();
    }

    $("#product_id").change(productValue);

    function productValue(){
        dataProduct = document.getElementById('product_id').value.split('_');
        $("#stock").val(dataProduct[1]);
        $("#sale_price").val(dataProduct[2]);
        $("#iva").val(dataProduct[3]);
        $("#idP").val(dataProduct[0]);
        $("#suggested_price").val(dataProduct[2]);
    }
    $(document).ready(function(){
        $("#add").click(function(){
            add();
        });
    });
    function add(){
        dataProduct = document.getElementById('product_id').value.split('_');
        product_id= dataProduct[4];
        product= $("#product_id option:selected").text();
        quantity= $("#quantity").val();
        price= $("#sale_price").val();
        stock= $("#stock").val();
        iva= $("#iva").val();
        idp= $("#idP").val();
        percentage = $("#percentage").val();
        retention = $("#retention").val();

        datapercentage = document.getElementById('percentage_id').value.split('_');
        percentage_id= datapercentage[0];
        pay = $("#pay").val();
        if(product_id !="" && quantity!="" && quantity>0  && price!="" && stock!="" && iva!=""){

            if (parseFloat(quantity) > parseFloat(stock) ) {
                //alert("Rellene todos los campos del detalle de la venta");
                Swal.fire({
                type: 'error',
                //title: 'Oops...',
                text: 'La cantidad a vender supera el stock',
            })
            } else {
                subtotal[cont]= parseFloat(quantity) * parseFloat(price);
                total= total+subtotal[cont];
                ivita= subtotal[cont]*iva/100;
                total_iva=total_iva+ivita;

                var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm btndelete" onclick="deleterow('+cont+');"><i class="fas fa-trash"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="id[]"  value="'+product_id+'">'+product_id+'</td><td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td><input type="hidden" name="iva[]"  value="'+iva+'">'+iva+'</td><td>$'+subtotal[cont]+' </td></tr>';

            cont++;

                totals();
                assess();
                $('#details').append(row);
                //$('#product_id option:selected').remove();
                clean();
            }

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
        $("#product_id").val("");
        $("#quantity").val("");
        $("#sale_price").val("");
        $("#idP").val("");
    }
    function totals(){
        rte = parseFloat($("#percentage").val());
        vrte = total*rte/100;

        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));

        total_pay=total+total_iva;
        $("#total_iva_html").html("$ " + total_iva.toFixed(2));
        $("#total_iva").val(total_iva.toFixed(2));

        total_pay = total_pay - vrte;
        $("#retention_html").html("$ " + vrte.toFixed(2));
        $("#retention").val(vrte.toFixed(2));

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

        $("#row" + index).remove();
        assess();
    }

    function assess(){

    if(total>0){
        $("#save").show();
        $("#aditPercentage").hide();
        $("#rtfon").attr('disabled','disabled');
        $("#rtfoff").attr('disabled','disabled');

        } else{
            $("#save").hide();
        }
    }

    //function editing(){
        order = {!! json_encode($orderProducts) !!};
        order.forEach((value, i) => {
            if (value['quantity'] > 0) {

                id = value['id'];
                product_id= value['idP'];
                product= value['name'];
                quantity= value['quantity'];
                price= value['price'];
                stock= value['stock'];
                iva= value['iva'];
                percentage = value['percentage'];
                $("#percentage").val(percentage);

                if(product_id !="" && quantity!="" && quantity>0  && price!="" && price>0){
                    subtotal[cont]= parseFloat(quantity) * parseFloat(price);
                    total= total+subtotal[cont];
                    ivita= subtotal[cont]*iva/100;
                    total_iva=total_iva+ivita;

                    var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm btndelete" onclick="deleterow('+cont+');"><i class="fas fa-trash"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="id[]"  value="'+product_id+'">'+product_id+'</td><td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td><input type="hidden" name="iva[]"  value="'+iva+'">'+iva+'</td><td>$'+subtotal[cont]+' </td></tr>';
                    cont++;

                    totals();
                    assess();
                    $('#details').append(row);
                    //$('#product_id option:selected').remove();
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
            $("#product_idModal").val(row.find("td:eq(2)").text());
            $("#productModal").val(row.find("td:eq(3)").text());
            $("#quantityModal").val(row.find("td:eq(4)").text());
            $("#priceModal").val(row.find("td:eq(5)").text());
            $("#ivaModal").val(row.find("td:eq(6)").text());
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
        product_id = $("#product_idModal").val();
        product = $("#productModal").val();
        quantity = $("#quantityModal").val();
        price = $("#priceModal").val();
        iva = $("#ivaModal").val();

        $('#priceModal').prop("readonly", false)

        if(product_id !="" && quantity!="" && quantity>0 && price!="" && price>0){
            subtotal[cont]= parseFloat(quantity) * parseFloat(price);
            total= total+subtotal[cont];
            ivita= subtotal[cont]*iva/100;
            total_iva=total_iva+ivita;

            var row= '<tr class="selected" id="row'+cont+'"><td><button type="button" class="btn btn-danger btn-sm btndelete" onclick="deleterow('+cont+');"><i class="fas fa-trash"></i></button></td><td><button type="button" class="btn btn-warning btn-sm btnedit" onclick="editrow('+cont+');"><i class="far fa-edit"></i></button></td><td><input type="hidden" name="id[]"  value="'+product_id+'">'+product_id+'</td><td><input type="hidden" name="product_id[]" value="'+product_id+'">'+product+'</td>   <td><input type="hidden" name="quantity[]" value="'+quantity+'">'+quantity+'</td> <td><input type="hidden" name="price[]"  value="'+price+'">'+price+'</td> <td><input type="hidden" name="iva[]"  value="'+iva+'">'+iva+'</td><td>$'+subtotal[cont]+' </td></tr>';
            cont++;
            deleterow(contedit);
            totals();
            assess();
            $('#details').append(row);
            $('#editModal').modal('hide');
            //$('#product_id option:selected').remove();
        }else{
            // alert("Rellene todos los campos del detalle de la compra, revise los datos del producto");
            Swal.fire({
                type: 'error',
                //title: 'Oops...',
                text: 'Rellene todos los campos del detalle de la compra',
            })
        }
    }
    function detailclear(){
        order = {!! json_encode($orderProducts) !!};
        order.forEach((value, i) => {
            if (value['quantity'] > 0) {
                deleterow(i);
            }
        });
    }
</script>
