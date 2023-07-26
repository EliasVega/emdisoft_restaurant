<div class="box-body row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <label class="form-control-label">
                <h4>FACTURACION ELECTRONICA</h4>
            </label>
        </div>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="identifier">ID Software</label>
            <input type="text" name="identifier" value="{{ old('identifier', $software->identifier ?? '') }}" class="form-control" placeholder="ID del software">
        </div>
    </div>

    <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="pin">Pin</label>
            <input type="text" name="pin" value="{{ old('pin', $software->pin ?? '') }}" class="form-control" placeholder="Pin">
        </div>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="set">Set FE</label>
            <input type="text" name="set" value="{{ old('set', $software->set ?? '') }}" class="form-control" placeholder="Set FE">
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <label class="form-control-label">
                <h4>NOMINA INDIVIDUAL</h4>
            </label>
        </div>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="payroll_identifier">ID Software Nomina</label>
            <input type="text" name="payroll_identifier" value="{{ old('payroll_identifier', $software->payroll_identifier ?? '') }}" class="form-control" placeholder="ID del software">
        </div>
    </div>

    <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="payroll_pin">Pin</label>
            <input type="text" name="payroll_pin" value="{{ old('payroll_pin', $software->payroll_pin ?? '') }}" class="form-control" placeholder="Pin">
        </div>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="payroll_set">Set Nomina</label>
            <input type="text" name="payroll_set" value="{{ old('payroll_set', $software->payroll_set ?? '') }}" class="form-control" placeholder="Set FE">
        </div>
    </div>
</div>
