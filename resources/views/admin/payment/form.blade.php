<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-6" id="suppliery">
    <label for="supplier_id">Proveedor</label>
    <div class="select">
        <select id="supplier_id" name="supplier_id" class="form-control selectpicker" data-live-search="true" required>
            <option {{ ($payment->supplier->id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar Proveedor</option>
            @foreach($suppliers as $supplier)
                @if($supplier->id == ($payment->supplier_id ?? ''))
                    <option value="{{ $supplier->id }}" selected>{{ $upplier->name }}</option>
                @else
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group">
        <button class="btn btn-celeste btn-sm" type="button" id="noDefined" data-toggle="tooltip" data-placement="top" title="Metodo no definido">Indefinido </button>
    </div>
</div>
<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group">
        <button class="btn btn-celeste btn-sm" type="button" id="cash" data-toggle="tooltip" data-placement="top" title="Efectivo">Efectivo</button>
    </div>
</div>
<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group">
        <button class="btn btn-celeste btn-sm" type="button" id="transfer" data-toggle="tooltip" data-placement="top" title="Transferencia">Transferencia</button>
    </div>
</div>
<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group">
        <button class="btn btn-celeste btn-sm" type="button" id="nequi" data-toggle="tooltip" data-placement="top" title="Nequi">Nequi</button>
    </div>
</div>
<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group">
        <button class="btn btn-celeste btn-sm" type="button" id="card1" data-toggle="tooltip" data-placement="top" title="Tarjetas">T/Credito</button>
    </div>
</div>
<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group">
        <button class="btn btn-celeste btn-sm" type="button" id="card2" data-toggle="tooltip" data-placement="top" title="Tarjetas">T/Debito</button>
    </div>
</div>
<div class="col-lg-6 col-md-4 col-sm-4 col-xs-12" id="payi">
    <div class="form-group">
        <label class="form-control-label" for="pay">Abono</label>
        <input type="number" id="pay" name="pay" value="" class="form-control"
            placeholder="pago" pattern="[0-9]{0,15}">
    </div>
</div>
<div class="col-lg-6 col-md-4 col-sm-4 col-xs-12" id="mpay">
    <div class="form-group">
        <label for="payment_method_id">Medio de Pago</label>
        <select name="payment_method_id" class="form-control selectpicker" id="payment_method_id"
            data-live-search="true">
            <option value="" disabled selected>Seleccionar....</option>
            @foreach($paymentMethods as $paymentMethod)
            <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group" id="banky">
        <label for="bank_id">bank</label>
        <select name="bank_id" class="form-control selectpicker" id="bank_id"
            data-live-search="true">
            <option value="" disabled selected>seleccionar...</option>
            @foreach($banks as $bank)
            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group" id="cardy">
        <label for="card_id">Tipo tarjeta</label>
        <select name="card_id" class="form-control selectpicker" id="card_id"
            data-live-search="true">
            <option value="" disabled selected>seleccionar...</option>
            @foreach($cards as $card)
            <option value="{{ $card->id }}">{{ $card->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
    <div class="form-group" id="transactiony">
        <label class="form-control-label" for="transaction"># Transaccion</label>
        <input type="text" id="transaction" name="transaction" value="" class="form-control">
    </div>
</div>
<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
    <div class="box-danger">
        <label class="form-control-label">
            <h4>Agregar Abonos</h4>
        </label>
    </div>
</div>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <div class="form-group">
        <button class="btn btn-celeste" type="button" id="add"><i class="fa fa-save"></i>&nbsp; Agregar Abono</button>
        <a href="{{url('payment')}}" class="btn btn-gris"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="form-group">
        <label class="form-control-label" for="note">Agregar Nota</label>
        <input type="text" name="note" value="" class="form-control">
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
        <table id="details" class="table table-striped table-bordered table-condensed table-hover">
            <thead class="bg-info">
                <tr>
                    <th>Eliminar</th>
                    <th>Medio</th>
                    <th>T. Tarjeta</th>
                    <th>Entidad</th>
                    <th>Transaccion o Documento</th>
                    <th>Abono</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="5">
                        <p align="right">TOTAL:</p>
                    </th>
                    <th>
                        <p align="right"><span id="total_html">$ 0.00</span>
                            <input type="hidden" name="total" id="total"> </p>
                    </th>
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
            <button class="btn btn-celeste" type="submit"><i class="fa fa-save"></i>&nbsp;Registrar</button>
        </div>
    </div>
</div>


