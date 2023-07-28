<div class="box-body row">
    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="nit">Nit</label>
            <input type="text" name="nit" value="{{ $company->nit }}" class="form-control" placeholder="Nit" required>
        </div>
    </div>
    <div class="col-lg-2 col-md-1 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="dv">DV</label>
            <input type="text" name="dv" value="{{ $company->dv }}" class="form-control" placeholder="DV" required>
        </div>
    </div>
    <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="name">Compañia</label>
            <input type="text" name="name" value="{{ $company->name }}" class="form-control" placeholder="Ingrese el name de la company">
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ $company->email }}" class="form-control" placeholder="Ingrese el correo electronico">
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
        <label for="department_id">Departamento</label>
            <select name="department_id" class="form-control" id="department_id">
                @foreach($departments as $dep)
                    @if($dep->id == $company->department_id)
                        <option value="{{ $dep->id }}" selected>{{ $dep->name }}</option>
                    @else
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="municipality_id">Municipio</label>
                <select name="municipality_id" class="form-control" id="municipality_id" required>
                    @foreach($municipalities as $mun)
                        @if($mun->id == $company->municipality_id)
                            <option value="{{ $mun->id }}" selected>{{ $mun->name }}</option>
                        @else
                            <option value="{{ $mun->id }}">{{ $mun->name }}</option>
                        @endif
                    @endforeach
                </select>
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">
        <div class="form-group">
            <label for="logo">Imagen</label>
            <input type="file" name="logo" class="form-control" id="logo" value="{{ $company->imagen }}" placeholder="Ingresar Imagen">
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
            <a href="{{url('company')}}" class="btn btn-danger"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
        </div>
    </div>
</div>
