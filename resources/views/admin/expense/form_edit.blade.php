<div class="box-body row">
<div class="col-lg-6 col-md-4 col-sm-4 col-xs-12" id="editProvider">
        <label for="supplier_id">Proveedor</label>
        <div class="select">
            <select id="supplier_id" name="supplier_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ old('supplier_id', $expense->supplier_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar tipo de persona</option>
                @foreach($suppliers as $supplier)
                    @if(old('supplier_id', $expense->supplier_id ?? '') == $supplier->id)
                        <option value="{{ $supplier->id }}" selected>{{ $supplier->name }}</option>
                    @else
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="editinc">
        <div class="form-group">
            <label class="form-control-label" for="inc">INC</label>
            <input type="number" id="inc" name="inc" class="form-control" placeholder="inc" disabled
                pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12" id="editServiceId">
        <div class="form-group row">
            <label class="form-control-label" for="service_id">Servicio</label>
                <select name="service_id" class="form-control selectpicker" id="service_id" data-live-search="true">
                    <option value="0" disabled selected>Seleccionar el Servicio</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}_{{ $service->category->inc }}">{{ $service->name }}</option>
                    @endforeach
                </select>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" id="editQuantity">
        <div class="form-group">
            <label class="form-control-label" for="quantity">Cantidad</label>
            <input type="number" id="quantity" name="quantity" value=""
                class="form-control" placeholder="Cantidad" pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" id="editPrice">
        <div class="form-group">
            <label class="form-control-label" for="price">Precio</label>
            <input type="number" id="price" name="price" class="form-control"
                placeholder="Precio de venta">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12" id="editAdd">
        <div class="form-group">
            <label class="form-control-label">Add</label><br>
            <button class="btn btn-grisb" type="button" id="add" data-toggle="tooltip" data-placement="top" title="Add"><i class="fas fa-check"></i>&nbsp; </button>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12" id="editCanc">
        <div class="form-group">
            <label class="form-control-label" >Canc</label><br>
            <a href="{{url('expense')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
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
                        <th>inc ($)</th>
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
                        <th colspan="7" class="footder">TOTAL INC:</th>
                        <td class="footder"><strong id="total_inc_html">$ 0.00</strong>
                            <input type="hidden" name="total_inc" id="total_inc">
                        </td>
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
