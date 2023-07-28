<div class="box-body row">
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="name">Nombre del Proveedor</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nombre del proveedor">
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="document_id">Tipo Identificacion</label>
            <select name="document_id" class="form-control selectpicker" data-live-search="true" id="document_id" required>
                <option value="{{ old('document_id') }}" disabled selected>Seleccionar.</option>
                @foreach($documents as $doc)
                    <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="number">Numero</label>
            <input type="text" name="number" value="{{ old('number') }}" class="form-control" placeholder="identificacion ">
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="dv">DV</label>
            <input type="text" name="dv" value="{{ old('dv') }}" class="form-control" placeholder="DV">
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Correo electronico">
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
            <a href="{{url('expense/create')}}" class="btn btn-danger"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
        </div>
    </div>
</div>
