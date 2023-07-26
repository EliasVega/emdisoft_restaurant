<div class="box-body row">

    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12">
        <div class="form-group">
            <label for="customer_id">Id_Cli.</label>
            <input type="text" name="customer_id" value="{{ $invoices->idC }}"
                class="form-control" placeholder="" readonly>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-10 col-xs-12">
        <div class="form-group">
            <label for="">Cliente</label>
            <input type="text" name="" value="{{ $invoices->name }}"
                class="form-control" placeholder="" readonly>
        </div>
    </div>

    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
        <div class="form-group row">
            <label class="form-control-label" for="nc_discrepancy_id">Motivo Nota Credito</label>
                <select name="nc_discrepancy_id" class="form-control selectpicker" id="nc_discrepancy_id" data-live-search="true">
                    <option value="0" disabled selected>Seleccionar...</option>
                    @foreach($discrepancies as $dis)
                        <option value="{{ $dis->id }}">{{ $dis->description }}</option>
                    @endforeach
                </select>
        </div>
    </div>
    <div class="clearfix"></div>

