<div class="box-body row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" id="editCustomer">
        <label for="supplier_id">Cliente</label>
        <div class="select">
            <select id="customer_id" name="customer_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ old('customer_id', $invoice->customer_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar tipo de persona</option>
                @foreach($customers as $customer)
                    @if(old('customer_id', $invoice->customer_id ?? '') == $customer->id)
                        <option value="{{ $customer->id }}" selected>{{ $customer->name }}</option>
                    @else
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="box-danger">
            <label class="form-control-label">
                <strong>Agregar Menus</strong>
            </label>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12" id="editIdmenu">
        <div class="form-group">
            <label class="form-control-label" for="idP">ID menu</label>
            <input type="number" id="idP" name="idP" class="form-control" placeholder="Id Prod." disabled>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="editSuggestedPrice">
        <div class="form-group">
            <label class="form-control-label" for="suggested_price">P/sugerido</label>
            <input type="number" id="suggested_price" name="suggested_price" class="form-control"
                placeholder="Precio sugerido" disabled>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="editInc">
        <div class="form-group">
            <label class="form-control-label" for="inc">INC</label>
            <input type="number" id="inc" name="inc" class="form-control" placeholder="Inc" disabled
                pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="clearfix">
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" id="addmenu">
        <div class="form-group row">
            <label class="form-control-label" for="menu_id">Menu</label>
            <select name="menu_id" class="form-control selectpicker" id="menu_id"
                data-live-search="true">
                <option value="0" disabled selected>Seleccionar Menu</option>
                @foreach($menus as $menu)
                <option
                    value="{{ $menu->id }}_{{ $menu->sale_price }}_{{ $menu->inc }}">
                    {{ $menu->name }}</option>
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
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" id="editPrice">
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
            <a href="{{url('invoice')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
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
                        <th>Menu</th>
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
                        <th colspan="7" class="footder">TOTAL inc:</th>
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
