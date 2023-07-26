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
            $('#product_id').select2({
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
    var total_desc = 0;
    var ret = 0;
    var vrte = 0;
    //form purchase
    $("#idPro").hide();
    $("#addPercentage").hide();
    $("#addVpercentage").hide();
    $("#save").hide();

    $("#rtferase").hide();
    $("#rtftotal").hide();
    $("#advance").hide();
    //$("#addDocument").hide();

    $(document).ready(function(){
        $("#rtfon").click(function(){
            $("#addPercentage").show();
            $("#rtferase").show();
            $("#rtftotal").show();
            $("#addVpercentage").show();
        });
    });

    $(document).ready(function(){
        $("#rtfoff").click(function(){
            $("#addPercentage").hide();
            $("#rtferase").hide();
            $("#rtftotal").hide();
            $("#addVpercentage").hide();
        });
    });

    $("#percentage_id").change(percentageVer);

    function percentageVer(){
        datapercentage = document.getElementById('percentage_id').value.split('_');
        $("#percentage_id").val(datapercentage[0]);
        $("#percentage").val(datapercentage[1]);
        percentages();
        totals();
    }
    function percentages(){
        $("#percentagey").hide();
        //$("#addPercentage").hide();
        $("#rtfon").attr('disabled','disabled');
        $("#rtfoff").attr('disabled','disabled');
    }

    $("#product_id").change(productValue);

    function productValue(){
        dataProduct = document.getElementById('product_id').value.split('_');
        $("#stock").val(dataProduct[1]);
        $("#vprice").val(dataProduct[2]);
        $("#iva").val(dataProduct[3]);
        //$("#idP").val(dataProduct[4]);
        $("#price").val(dataProduct[2]);
    }
    $(document).ready(function(){
        $("#add").click(function(){
            add();
        });
    });
    function add(){

        dataProduct = document.getElementById('product_id').value.split('_');
        product_id= dataProduct[0];
        product= $("#product_id option:selected").text();
        quantity= $("#quantity").val();
        price= $("#price").val();
        stock= $("#stock").val();
        iva= $("#iva").val();

        datapercentage = document.getElementById('percentage_id').value.split('_');
        percentage_id= datapercentage[0];
        percentage = $("#percentage").val();
        if(product_id !="" && quantity!="" && quantity>0  && price!=""){
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

    function clean(){
        $("#product_id").val("");
        $("#quantity").val("");
        $("#sale_price").val("");
    }
    function totals(){
        var rte = parseFloat($("#percentage").val());
        var vrte = total * rte / 100;
        var total_pay = total + total_iva;
        var total_desc = total_pay - vrte;

        $("#total_html").html("$ " + total.toFixed(2));
        $("#total").val(total.toFixed(2));

        $("#total_iva_html").html("$ " + total_iva.toFixed(2));
        $("#total_iva").val(total_iva.toFixed(2));

        $("#retention_html").html("$ " + vrte.toFixed(2));
        $("#retention").val(vrte.toFixed(2));

        $("#total_desc_html").html("$ " + total_desc.toFixed(2));
        $("#total_desc").val(total_desc.toFixed(2));

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

    //function editing(){
        purchase = {!! json_encode($productPurchases) !!};
        purchase.forEach((value, i) => {
            if (value['quantity'] > 0) {

                id = value['id'];
                product_id= value['idP'];
                product= value['name'];
                quantity= value['quantity'];
                price= value['price'];
                stock= value['stock'];
                iva= value['iva'];
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
    function detailclear(){
        purchase = {!! json_encode($productPurchases) !!};
        purchase.forEach((value, i) => {
            if (value['quantity'] > 0) {
                deleterow(i);
            }
        });
    }
</script>
