<div class="box-body row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Cliente">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="department_id">Departamentos</label>
            <select name="department_id" class="form-control selectpicker" data-live-search="true" id="department_id" required>
                <option value="{{ old('department_id') }}" disabled selected>Seleccionar.</option>
                @foreach($departments as $dep)
                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="municipality_id">Municipio</label>
            <select name="municipality_id" class="form-control" id="municipality_id" required>
                <option value ="" disabled selected>Seleccionar...</option>
            </select>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="document_id">Identificacion</label>
            <select name="document_id" class="form-control selectpicker" data-live-search="true" id="document_id" required>
                <option value="{{ old('document_id') }}" disabled selected>Seleccionar.</option>
                @foreach($documents as $doc)
                    <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="number">Numero</label>
            <input type="text" name="number" value="{{ old('number') }}" class="form-control" placeholder="Identificacion">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="dv">DV</label>
            <input type="text" name="dv" value="{{ old('dv') }}" class="form-control" placeholder="DV">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="address">Direccion</label>
            <input type="text" name="address" value="{{ old('address') }}" class="form-control" placeholder="Direccion">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="phone">Telefono</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Telefono">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="liability_id">R. fiscal</label>
            <select name="liability_id" class="form-control selectpicker" data-live-search="true" id="liability_id" required>
                <option value="{{ old('liability_id') }}" disabled selected>Seleccionar.</option>
                @foreach($liabilities as $fis)
                    <option value="{{ $fis->id }}">{{ $fis->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="organization_id">Organizacion</label>
            <select name="organization_id" class="form-control selectpicker" data-live-search="true" id="organization_id" required>
                <option value="{{ old('organization_id') }}" disabled selected>Seleccionar.</option>
                @foreach($organizations as $org)
                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="regime_id">Regimen</label>
            <select name="regime_id" class="form-control selectpicker" data-live-search="true" id="regime_id" required>
                <option value="{{ old('regime_id') }}" disabled selected>Seleccionar.</option>
                @foreach($regimes as $reg)
                    <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="credit_limit">Cupo</label>
            <input type="number" name="credit_limit" value="{{ old('credit_limit') }}" class="form-control" placeholder="Cupo asignado">
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <button class="btn btn-celeste" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
            <a href="{{url('order')}}" class="btn btn-logfucsia"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
        </div>
    </div>
</div>
