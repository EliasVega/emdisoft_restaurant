<div class="box-body row">
    <div class="formulario">
        <div class="checkbox">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 checkbox">
                <input type="checkbox" name="service" value="0" id="checkbox1" checked>
                <label for="checkbox1">En Mesa</label>

                <input type="checkbox" name="service" value="1" id="checkbox2">
                <label for="checkbox2">Domicilios</label>
            </div>

        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="addSuggestedPrice">
        <div class="form-group">
            <label class="form-control-label" for="precio">P/sugerido</label>
            <input type="number" id="suggested_price" name="pricesug" class="form-control"
                placeholder="Precio sugerido" disabled>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="addInc">
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
                <option value="" disabled selected>Seleccionar el Menu</option>
                @foreach($menus as $menu)
                <option
                    value="{{ $menu->id }}_{{ $menu->sale_price }}_{{ $menu->category->inc }}">{{ $menu->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" id="addQuantity">
        <div class="form-group">
            <label class="form-control-label" for="quantity">Cantidad</label>
            <input type="number" id="quantity" name="quantity" value=""
                class="form-control" placeholder="Cantidad" pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" id="addPrice">
        <div class="form-group">
            <label class="form-control-label" for="sale_price">Precio</label>
            <input type="number" id="sale_price" name="sale_price" class="form-control"
                placeholder="Precio de venta">
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="addObservation">
        <div class="form-group">
            <label class="form-control-label" for="observation">Observaciones</label>
            <input type="text" id="observation" name="observation" class="form-control"
                placeholder="Observaciones">
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
            <a href="{{url('order')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table id="details" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Eliminar</th>
                        <th>Menu</th>
                        <th>Cantidad</th>
                        <th>precio ($)</th>
                        <th>inc ($)</th>
                        <th>SubTotal ($)</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="5" class="footder">TOTAL:</th>
                        <td class="footder"><strong id="total_html">$ 0.00</strong>
                            <input type="hidden" name="total" id="total"></td>
                    </tr>
                    <tr>
                        <th colspan="5" class="footder">TOTAL INC:</th>
                        <td class="footder"><strong id="total_inc_html">$ 0.00</strong>
                            <input type="hidden" name="total_inc" id="total_inc">
                        </td>
                    </tr>
                    <tr>
                        <th colspan="5" class="footder">TOTAL PAGAR:</th>
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
