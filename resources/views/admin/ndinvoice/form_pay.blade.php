<div class="box-body row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" id="fpago">
            <label for="payment_form_id">F/Pago</label>
            <select name="payment_form_id" class="form-control selectpicker" id="payment_form_id"
                data-live-search="true" required>
                <option value="" disabled selected>Seleccionar...</option>
                @foreach($payment_forms as $pf)
                <option value="{{ $pf->id }}">{{ $pf->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" id="mpay">
            <label for="payment_method_id">Med/pago</label>
            <select name="payment_method_id" class="form-control selectpicker" id="payment_method_id"
                data-live-search="true" required>
                <option value="" disabled selected>Seleccionar...</option>
                @foreach($payment_methods as $pm)
                <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <label class="form-control-label">
                <h4>Medios de Pago</h4>
            </label>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group" >
            <button class="btn" type="button" id="transvenped" data-toggle="tooltip" data-placement="top" title="De Documento"><img src="{{ asset('img/transvenped.jpg') }}" height="150" width="80" alt="transvenped"></button>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group" >
            <button class="btn" type="button" id="cash" data-toggle="tooltip" data-placement="top" title="cash"><img src="{{ asset('img/efect.jpg') }}" height="150" width="80" alt="cash"></button>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            <button class="btn" type="button" id="card" data-toggle="tooltip" data-placement="top" title="card"><img src="{{ asset('img/tarjet.jpg') }}" height="150" width="80" alt="TC o TD"></button>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            <button class="btn" type="button" id="transfer" data-toggle="tooltip" data-placement="top" title="Tranferencia Bancaria"><img src="{{ asset('img/trans.jpg') }}" height="150" width="80" alt="Transferencia"></button>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            <button class="btn" type="button" id="nequi" data-toggle="tooltip" data-placement="top" title="Nequi"><img src="{{ asset('img/nequi.jpg') }}" height="150" width="80" alt="Nequi"></button>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <label class="form-control-label">
                <h4>Agregar Abono</h4>
            </label>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="balance">Total Nota Debito</label>
            <input type="number" id="balance" name="balance" value="0" class="form-control gris" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" id="balancy">
            <label class="form-control-label" for="returned">Saldo</label>
            <input type="number" id="returned" name="returned" value="0"
                class="form-control gris" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" id="payi">
            <label class="form-control-label requerido" for="pay">Abono</label>
            <input type="number" id="pay" name="pay" value="0"
                class="form-control blanco" placeholder="pay" pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" id="transactiony">
            <label class="form-control-label" for="transaction">#Transaccion</label>
            <input type="text" id="transaction" name="transaction"
                class="form-control" placeholder="Operacion">
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" id="banky">
            <label class="requerido" for="bank_id">Bancos</label>
            <select name="bank_id" class="form-control selectpicker" id="bank_id"
                data-live-search="true">
                <option value="" disabled selected>Seleccionar...</option>
                @foreach($banks as $ban)
                <option value="{{ $ban->id }}">{{ $ban->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" id="cardy">
            <label for="card_id">Tipo Tarjeta</label>
            <select name="card_id" class="form-control selectpicker" id="card_id"
                data-live-search="true">
                <option value="" disabled selected>seleccionar...</option>
                @foreach($cards as $car)
                <option value="{{ $car->id }}">{{ $car->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" id="abpaymenty">
            <label class="form-control-label requerido" for="abpayment">abono</label>
            <input type="number" id="abpayment" name="abpayment" value="0"
                class="form-control blanco">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" id="abvto">
            <label class="form-control-label" for="abv">abono evento</label>
            <input type="number" id="abv" name="abv" value="0"
                class="form-control" >
        </div>
    </div>
</div>
