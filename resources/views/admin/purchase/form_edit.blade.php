<div class="box-body row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="addSupplier">
        <label for="supplier_id">Proveedor</label>
        <div class="select">
            <select id="supplier_id" name="supplier_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ old('supplier_id', $purchase->supplier_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar Proveedor</option>
                @foreach($suppliers as $supplier)
                    @if(old('supplier_id', $purchase->supplier_id ?? '') == $supplier->id)
                        <option value="{{ $supplier->id }}" selected>{{ $supplier->name }}</option>
                    @else
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="addBranch">
        <label for="branch_id">Sucursal de Destino</label>
        <div class="select">
            <select id="branch_id" name="branch_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ old('branch_id', $purchase->branch_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar tipo de persona</option>
                @foreach($branches as $branch)
                    @if(old('branch_id', $purchase->branch_id ?? '') == $branch->id)
                        <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                    @else
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="addDocument">
        <div class="form-group">
            <label class="form-control-label" for="document">N°Factura</label>
            <input type="text" id="document" name="document" value="{{ $purchase->document }}" class="form-control" placeholder="Numero de la factura" required>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="addDueData">
        <div class="form-group">
            <label class="form-control-label" for="due_date">Vencimiento</label>
            <input type="date" name="due_date" value="{{ $purchase->due_date }}" class="form-control" placeholder="Fecha Vencimiento" >
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-3" id="addRadio">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="percentage" value="1" id="rtfon">
            <label class="form-check-label" for="retefte">
                Retenciones
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="percentage" value="0" id="rtfoff" checked>
            <label class="form-check-label" for="retefte">
                No Retenciones
            </label>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12" id="addPercentage">
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
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="addStock">
        <div class="form-group">
            <label class="form-control-label" for="stock">Stock</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock') }}" class="form-control"
                placeholder="stock" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="addIva">
        <div class="form-group">
            <label class="form-control-label" for="iva">Iva</label>
            <input type="number" id="iva" name="iva" class="form-control" placeholder="Iva" disabled
                pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-12" id="addVprice">
        <div class="form-group">
            <label for="vprice">V/Actual</label>
            <input type="number" name="vprice" id="vprice"  class="form-control" readonly>
        </div>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-3 col-xs-12" id="addVpercentage">
        <div class="form-group">
            <label class="form-control-label" for="percentage">% Ret</label>
            <input type="number" id="percentage" name="percentage" value="0" class="form-control"
                placeholder="V impuesto" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="addProduct">
        <div class="form-group row">
            <label class="form-control-label" for="product_id">Producto</label>
                <select name="product_id" class="form-control selectpicker" id="product_id" data-live-search="true">
                    <option value="0" disabled selected>Seleccionar el Producto</option>
                    @foreach($products as $pro)
                        <option value="{{ $pro->id }}_{{ $pro->stock }}_{{ $pro->price }}_{{ $pro->category->iva }}">{{ $pro->name }}</option>
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
            <label class="form-control-label" for="price">Precio</label>
            <input type="number" id="price" name="price" class="form-control"
                placeholder="Precio">
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
            <a href="{{url('purchase')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table id="details" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Eliminar</th>
                        <th>Editar</th>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>precio ($)</th>
                        <th>Imp. %</th>
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
                    <tr id="rtftotal">
                        <th colspan="7" class="footder">TOTAL - DESC:</th>
                        <td class="footder"><strong id="total_desc_html">$ 0.00</strong>
                            <input type="hidden" name="total_desc" id="total_desc"></td>
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
    <div class="modal-footer" id="save">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button class="btn btn-celeste" type="submit"><i class="fa fa-save"></i>&nbsp;
                    Registrar</button>
            </div>
        </div>
    </div>
</div>
