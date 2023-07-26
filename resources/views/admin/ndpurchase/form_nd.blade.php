<div class="box-body row">
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12" id="idProvider">
        <div class="form-group">
            <label for="supplier_id">Id_Sup.</label>
            <input type="text" name="supplier_id" value="{{ $purchase->supplier->id }}"
                class="form-control" placeholder="" readonly>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="purchase_id">Compra</label>
            <input type="text" name="purchase_id" value="{{ $purchase->id }}"
                class="form-control" placeholder="" readonly>
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="form-group">
            <label for="">Proveedor</label>
            <input type="text" name="" value="{{ $purchase->supplier->name }}"
                class="form-control" placeholder="" readonly>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-3" >
        <div class="form-check">
            <input class="form-check-input" type="radio" name="reverse" value="1" id="reverse_on">
            <label class="form-check-label" for="reverse">
                Regresar Valor a la Caja
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="reverse" value="0" id="reverse_off" checked>
            <label class="form-check-label" for="reverse">
                Dejar valor como anticipo
            </label>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table id="details" class="table table-striped table-bordered table-condensed table-hover" >
                <thead class="bg-info">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>precio ($)</th>
                        <th>SubTotal ($)</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th  colspan="3"><p align="right">TOTAL:</p></th>
                        <th><p align="right"><span id="total_html">$ 0.00</span>
                            <input type="hidden" name="total" id="total"> </p></th>
                    </tr>

                    <tr>
                        <th colspan="3"><p align="right">TOTAL IVA:</p></th>
                        <th><p align="right"><span id="total_iva_html">$ 0.00</span>
                            <input type="hidden" name="total_iva" id="total_iva"></p></th>
                    </tr>

                    <tr>
                        <th  colspan="3"><p align="right">TOTAL PAGAR:</p></th>
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
                <button class="btn btn-danger" type="submit"><i class="fa fa-save fa-2x"></i> Eliminar</button>
            </div>
        </div>
    </div>
</div>
