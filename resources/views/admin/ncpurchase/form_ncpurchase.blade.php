<div class="box-body row">
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="supplier_id">Id_Sup.</label>
            <input type="text" name="supplier_id" value="{{ $purchase->supplier->id }}"
                class="form-control" placeholder="" readonly>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
        <div class="form-group">
            <label for="">Proveedor</label>
            <input type="text" name="" value="{{ $purchase->supplier->name }}"
                class="form-control" placeholder="" readonly>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="form-group row">
            <label class="form-control-label" for="nc_discrepancy_id">Discrepancia</label>
                <select name="nc_discrepancy_id" class="form-control selectpicker" id="nc_discrepancy_id" data-live-search="true">
                    <option value="0" disabled selected>Seleccionar...</option>
                    @foreach($discrepancies as $dis)
                        <option value="{{ $dis->id }}">{{ $dis->description }}</option>
                    @endforeach
                </select>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-lg8 col-md-8 col-sm8 col-xs-12">
        <div class="box-danger">
            <label class="form-control-label"><h6>Agregar products</h6></label>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="purchase_id">Compra</label>
            <input type="text" name="purchase_id" value="{{ $purchase->id }}"
                class="form-control" placeholder="" readonly>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="iva">Iva</label>
            <input type="number" id="iva" name="iva" class="form-control" placeholder="Iva"
                disabled pattern="[0-9]{0,15}">
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="stock">Stock</label>
            <input type="number" id="stock" name="stock" class="form-control" placeholder="Stock"
                disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group" id="price_v">
            <label class="form-control-label" for="purchase_price">V/facturado</label>
            <input type="number" id="purchase_price" name="purchase_price" class="form-control" disabled pattern="[0-9]{0,15}">
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="quantity">Uni/compradas</label>
            <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Ingrese la cantidad" disabled pattern="[0-9]{0,15}">
        </div>
    </div>

    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group row">
            <label class="form-control-label" for="product_id">Producto</label>
                <select name="product_id" class="form-control selectpicker" id="product_id" data-live-search="true">
                    <option value="0" disabled selected>Seleccionar el Producto</option>
                    @foreach($productPurchases as $pp)
                        <option value="{{ $pp->product->id }}_{{ $pp->product->price }}_{{ $pp->product->stock }}_{{ $pp->quantity }}_{{ $pp->product->category->iva }}">{{ $pp->product->name }}</option>
                    @endforeach
                </select>
        </div>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="price">Precio</label>
            <input type="number" id="price" name="price" class="form-control" placeholder="Precio"
                 pattern="[0-9]{0,15}">
        </div>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label">Add</label><br>
            <button class="btn btn-grisb" type="button" id="add" data-toggle="tooltip" data-placement="top" title="adicionar"><i class="fas fa-check"></i>&nbsp; </button>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" >Canc</label><br>
            <a href="{{url('purchase')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
        </div>
    </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table id="details" class="table table-striped table-bordered table-condensed table-hover" >
                    <thead class="bg-info">
                        <tr>
                            <th>Eliminar</th>
                            <th>Stock</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>precio ($)</th>
                            <th>SubTotal ($)</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th  colspan="5"><p align="right">TOTAL:</p></th>
                            <th><p align="right"><span id="total_html">$ 0.00</span>
                                <input type="hidden" name="total" id="total"> </p></th>
                        </tr>

                        <tr>
                            <th colspan="5"><p align="right">TOTAL IVA:</p></th>
                            <th><p align="right"><span id="total_iva_html">$ 0.00</span>
                                <input type="hidden" name="total_iva" id="total_iva"></p></th>
                        </tr>

                        <tr>
                            <th  colspan="5"><p align="right">TOTAL PAGAR:</p></th>
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
            <div class="form-group">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button class="btn btn-celeste" type="submit"><i class="fa fa-save fa-2x"></i>&nbsp; Registrar</button>
            </div>
        </div>
    </div>
</div>
