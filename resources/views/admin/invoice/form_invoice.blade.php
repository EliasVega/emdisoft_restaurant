<div class="box-body row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" id="addCustomer">
        <div class="form-group">
            <label for="customer_id">Cliente   <button class="btn btn-celeste btn-sm mb-2" type="button"
                data-toggle="modal" data-target="#customer"><i class="fa fa-plus mr-md-2"></i>Agregar</button></label>
            <select name="customer_id" class="form-control selectpicker" id="customer_id"
                data-live-search="true" required>
                <option value="" disabled selected>Seleccionar el Cliente</option>
                @foreach($customers as $cus)
                <option value="{{ $cus->id }}">{{ $cus->number }} - {{ $cus->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="box-danger">
            <label class="form-control-label">
                <strong>Agregar Productos</strong>
            </label>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="addSuggestedPrice">
        <div class="form-group">
            <label class="form-control-label" for="precio">P/sugerido</label>
            <input type="number" id="suggested_price" name="pricesug" class="form-control"
                placeholder="Precio sugerido" disabled>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="addIva">
        <div class="form-group">
            <label class="form-control-label" for="iva">Iva</label>
            <input type="number" id="iva" name="iva" class="form-control" placeholder="Iva" disabled
                pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="clearfix">
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" id="addProduct">
        <div class="form-group row">
            <label class="form-control-label" for="product_id">Producto</label>
            <select name="product_id" class="form-control selectpicker" id="product_id"
                data-live-search="true">
                <option value="0" disabled selected>Seleccionar el Producto</option>
                @foreach($products as $product)
                <option
                    value="{{ $product->id }}_{{ $product->sale_price }}_{{ $product->iva }}">
                    {{ $product->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" id="addQuantity">
        <div class="form-group">
            <label class="form-control-label" for="quantity">Cantidad</label>
            <input type="number" id="quantity" name="quantity" value=""
                class="form-control" placeholder="Cantidad" pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" id="addPrice">
        <div class="form-group">
            <label class="form-control-label" for="sale_price">Precio</label>
            <input type="number" id="sale_price" name="sale_price" class="form-control"
                placeholder="Precio de venta">
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-12" id="added">
        <div class="form-group">
            <label class="form-control-label">Add</label><br>
            <button class="btn btn-grisb" type="button" id="add" data-toggle="tooltip" data-placement="top" title="Add"><i class="fas fa-check"></i>&nbsp; </button>
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-12" id="addCanc">
        <div class="form-group">
            <label class="form-control-label" >Canc</label><br>
            <a href="{{url('invoice')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table id="details" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Eliminar</th>
                        <th>Id</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>precio ($)</th>
                        <th>iva ($)</th>
                        <th>SubTotal ($)</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="6" class="footder">TOTAL:</th>
                        <td class="footder"><strong id="total_html">$ 0.00</strong>
                            <input type="hidden" name="total" id="total"></td>
                    </tr>
                    <tr>
                        <th colspan="6" class="footder">TOTAL IVA:</th>
                        <td class="footder"><strong id="total_iva_html">$ 0.00</strong>
                            <input type="hidden" name="total_iva" id="total_iva">
                        </td>
                    </tr>
                    <tr>
                        <th colspan="6" class="footder">TOTAL PAGAR:</th>
                        <td class="footder"><strong id="total_pay_html">$ 0.00</strong>
                            <input type="hidden" name="total_pay" id="total_pay"></td>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
