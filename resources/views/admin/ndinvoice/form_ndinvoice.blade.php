<div class="box-body row">
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
        <div class="form-group">
            <label for="customer_id">Id_Cli.</label>
            <input type="text" name="customer_id" value="{{ $invoices->customer_id }}"
                class="form-control" placeholder="" readonly>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-5 col-xs-12">
        <div class="form-group">
            <label for="">Cliente</label>
            <input type="text" name="" value="{{ $invoices->customer->name }}"
                class="form-control" placeholder="" readonly>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="iva">Iva</label>
            <input type="number" id="iva" name="iva" class="form-control" placeholder="Iva"
                disabled pattern="[0-9]{0,15}">
        </div>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="stock">Stock</label>
            <input type="number" id="stock" name="stock" class="form-control" placeholder="Stock"
                disabled pattern="[0-9]{0,15}">
        </div>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
        <div class="form-group" id="price_v">
            <label class="form-control-label" for="price_sale">Precio Facturado</label>
            <input type="number" id="price_sale" name="price_sale" class="form-control" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group row">
            <label class="form-control-label" for="nd_discrepancy_id">Discrepancia</label>
                <select name="nd_discrepancy_id" class="form-control selectpicker" id="nd_discrepancy_id" data-live-search="true">
                    <option value="0" disabled selected>Seleccionar...</option>
                    @foreach($discrepancies as $dis)
                        <option value="{{ $dis->id }}">{{ $dis->description }}</option>
                    @endforeach
                </select>
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="quantity">Uni/vendidas</label>
            <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Ingrese la cantidad" disabled pattern="[0-9]{0,15}">
        </div>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" >Canc</label><br>
            <a href="{{url('invoice')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group row">
            <label class="form-control-label" for="product_id">Producto</label>
                <select name="product_id" class="form-control selectpicker" id="product_id" data-live-search="true">
                    <option value="0" disabled selected>Seleccionar el Producto</option>
                    @foreach($invoice_products as $ip)
                        <option value="{{ $ip->id }}_{{ $ip->price }}_{{ $ip->stock }}_{{ $ip->quantity }}_{{ $ip->iva }}">{{ $ip->name }}</option>
                    @endforeach
                </select>
        </div>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="price">Precio</label>
            <input type="number" id="price" name="price" class="form-control" placeholder="Precio"
                 pattern="[0-9]{0,15}">
        </div>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-12">
        <div class="form-group">
            <label class="form-control-label">Add</label><br>
            <button class="btn btn-grisb" type="button" id="add" data-toggle="tooltip" data-placement="top" title="adicionar"><i class="fas fa-check"></i>&nbsp; </button>
        </div>
    </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table id="details" class="table table-striped table-bordered table-condensed table-hover" >
                    <thead class="bg-info">
                        <tr>
                            <th>Eliminar</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>precio ($)</th>
                            <th>SubTotal ($)</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th  colspan="4"><p align="right">TOTAL:</p></th>
                            <th><p align="right"><span id="total_html">$ 0.00</span>
                                <input type="hidden" name="total" id="total"> </p></th>
                        </tr>

                        <tr>
                            <th colspan="4"><p align="right">TOTAL IVA:</p></th>
                            <th><p align="right"><span id="total_iva_html">$ 0.00</span>
                                <input type="hidden" name="total_iva" id="total_iva"></p></th>
                        </tr>

                        <tr>
                            <th  colspan="4"><p align="right">TOTAL PAGAR:</p></th>
                            <th><p align="right"><span align="right" id="total_pay_html">$ 0.00</span>
                                <input type="hidden" name="total_pay" id="total_pay"></p></th>
                        </tr>
                    </tfoot>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    <div class="modal-footer" id="save">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group row">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button class="btn btn-success" type="submit"><i class="fa fa-save fa-2x"></i>&nbsp; Registrar</button>
            </div>
        </div>
    </div>
</div>
