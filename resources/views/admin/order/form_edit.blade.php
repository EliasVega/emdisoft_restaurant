<div class="box-body row">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" id="editCustomer">
        <label for="customer_id">Cliente</label>
        <div class="select">
            <select id="customer_id" name="customer_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ old('customer_id', $order->customer_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar Cliente</option>
                @foreach($customers as $customer)
                    @if(old('customer_id', $order->customer_id ?? '') == $customer->id)
                        <option value="{{ $customer->id }}" selected>{{ $customer->name }}</option>
                    @else
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="editDueDate">
        <div class="form-group">
            <label class="form-control-label" for="due_date">Fecha Vencimiento</label>
            <input type="date" id="due_date" name="due_date" value="{{ $order->due_date }}" class="form-control" placeholder="vencimmiento" required>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="box-danger">
            <label class="form-control-label">
                <strong>Agregar Productos</strong>
            </label>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12" id="editIdp">
        <div class="form-group">
            <label class="form-control-label" for="idP">ID Producto</label>
            <input type="number" id="idP" name="idP" class="form-control" placeholder="Id Prod." disabled
                pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="editRadio">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="percentage" value="1" id="rtfon">
            <label class="form-check-label" for="reterenta">
                Retenciones
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="percentage" value="0" id="rtfoff" checked>
            <label class="form-check-label" for="reterenta">
                No Retenciones
            </label>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="editPercentage">
        <div class="form-group row">
            <label class="form-control-label" for="percentage_id">Porcentaje</label>
            <select name="percentage_id" class="form-control selectpicker" id="percentage_id"
                data-live-search="true">
                <option value="1" disabled selected>Seleccionar.</option>
                @foreach($percentages as $per)
                <option
                    value="{{ $per->id }}_{{ $per->percentage }}">{{ $per->percentage }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="editSugestedPrice">
        <div class="form-group">
            <label class="form-control-label" for="suggested_price">P/sugerido</label>
            <input type="number" id="suggested_price" name="suggested_price" class="form-control"
                placeholder="Precio sugerido" disabled>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="editStock">
        <div class="form-group">
            <label class="form-control-label" for="stock">Stock</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock') }}" class="form-control"
                placeholder="stock" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="editIva">
        <div class="form-group">
            <label class="form-control-label" for="iva">Iva</label>
            <input type="number" id="iva" name="iva" class="form-control" placeholder="Iva" disabled
                pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-3 col-xs-12" id="editVpercentage">
        <div class="form-group">
            <label class="form-control-label" for="percentage">% Ret</label>
            <input type="number" id="percentage" name="percentage" value="0" class="form-control"
                placeholder="V impuesto" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="clearfix">
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" id="editProduct">
        <div class="form-group row">
            <label class="form-control-label" for="product_id">Producto</label>
            <select name="product_id" class="form-control selectpicker" id="product_id"
                data-live-search="true">
                <option value="0" disabled selected>Seleccionar el Producto</option>
                @foreach($branchProducts as $branchProduct)
                <option
                    value="{{ $branchProduct->id }}_{{ $branchProduct->stock }}_{{ $branchProduct->sale_price }}_{{ $branchProduct->iva }}_{{ $branchProduct->idP }}">
                    {{ $branchProduct->name }}--{{ $branchProduct->stock }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" id="editQuantity">
        <div class="form-group">
            <label class="form-control-label" for="quantity">Cantidad</label>
            <input type="number" id="quantity" name="quantity" value=""
                class="form-control" placeholder="Cantidad" pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" id="editSalePrice">
        <div class="form-group">
            <label class="form-control-label" for="sale_price">Precio</label>
            <input type="number" id="sale_price" name="sale_price" class="form-control"
                placeholder="Precio de venta">
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-12" id="editAdd">
        <div class="form-group">
            <label class="form-control-label">Add</label><br>
            <button class="btn btn-grisb" type="button" id="add" data-toggle="tooltip" data-placement="top" title="Add"><i class="fas fa-check"></i>&nbsp; </button>
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-12" id="editCanc">
        <div class="form-group">
            <label class="form-control-label" >Canc</label><br>
            <a href="{{url('order')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table id="details" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Eliminar</th>
                        <th>Editar</th>
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
                        <th colspan="7" class="footder">TOTAL:</th>
                        <td class="footder"><strong id="total_html">$ 0.00</strong>
                            <input type="hidden" name="total" id="total"></td>
                    </tr>
                    <tr>
                        <th colspan="7" class="footder">TOTAL IVA:</th>
                        <td class="footder"><strong id="total_iva_html">$ 0.00</strong>
                            <input type="hidden" name="total_iva" id="total_iva">
                        </td>
                    </tr>
                    <tr id="rtferase">
                        <th colspan="7" class="footder">RETENCION:</th>
                        <td class="footder"><strong id="retention_html">$ 0.00</strong>
                            <input type="hidden" name="retention" id="retention"></td>
                    </tr>
                    <tr>
                        <th colspan="7" class="footder">TOTAL PAGAR:</th>
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
