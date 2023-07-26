<div class="col-12 col-md-12">
    <label for="co_country_id">Pais</label>
    <div class="select">
        <select id="co_country_id" name="co_country_id" class="form-control selectpicker" data-live-search="true" required>
            <option value="47" disabled>Pais</option>
            @foreach($co_countries as $co_country)
                @if($co_country->id == ($co_municipality->co_department->co_country_id ?? ''))
                    <option value="{{ $co_country->id }}" selected>{{ $co_country->name }}</option>
                @else
                    <option value="{{ $co_country->id }}">{{ $co_country->name }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="departamento_id">Departamentos</label>
        <select name="departamento_id" class="form-control selectpicker" data-live-search="true" id="departamento" required>
            <option value="{{ old('departamento_id') }}" disabled selected>Seleccionar.</option>
            @foreach($departamentos as $dep)
                <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="municipio_id">Municipio</label>
        <select name="municipio_id" class="form-control" id="municipio" required>
            <option value ="" disabled selected>Seleccionar...</option>
        </select>
    </div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="nombre">Nombre del Cliente</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" placeholder="Ingrese el nombre del proveedor">
    </div>
</div>
<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="tdoc_id">Tipo Identificacion</label>
        <select name="tdoc_id" class="form-control selectpicker" data-live-search="true" id="departamento" required>
            <option value="{{ old('tdoc_id') }}" disabled selected>Seleccionar.</option>
            @foreach($tdocs as $tdo)
                <option value="{{ $tdo->id }}">{{ $tdo->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="fiscal_id">Responsabilidad fiscal</label>
        <select name="fiscal_id" class="form-control selectpicker" data-live-search="true" id="fiscal" required>
            <option value="{{ old('fiscal_id') }}" disabled selected>Seleccionar.</option>
            @foreach($fiscals as $fis)
                <option value="{{ $fis->id }}">{{ $fis->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="organizacion_id">Tipo Organizacion</label>
        <select name="organizacion_id" class="form-control selectpicker" data-live-search="true" id="organizacion" required>
            <option value="{{ old('organizacion_id') }}" disabled selected>Seleccionar.</option>
            @foreach($organizacions as $org)
                <option value="{{ $org->id }}">{{ $org->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="tributo_id">Regimen o >Tributo</label>
        <select name="tributo_id" class="form-control selectpicker" data-live-search="true" id="departamento" required>
            <option value="{{ old('tributo_id') }}" disabled selected>Seleccionar.</option>
            @foreach($tributos as $tri)
                <option value="{{ $tri->id }}">{{ $tri->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="numero">Numero de identificacion</label>
        <input type="text" name="numero" value="{{ old('numero') }}" class="form-control" placeholder="Ingrese el Numero de Identificacion">
    </div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" value="{{ old('direccion') }}" class="form-control" placeholder="Ingrese la direccion">
    </div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="telefono">Numero de Telefono</label>
        <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control" placeholder="Ingrese el Numero de telefono">
    </div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Ingrese el correo electronico">
    </div>
</div>
