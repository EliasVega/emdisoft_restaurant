<div class="box-body row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="document_id">Tipo Documento</label>
        <div class="select">
            <select id="document_id" name="document_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ old('document_id', $customer->document_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar Documento</option>
                @foreach($documents as $document)
                    @if(old('document_id', $customer->document_id ?? '') == $document->id)
                        <option value="{{ $document->id }}" selected>{{ $document->name }}</option>
                    @else
                        <option value="{{ $document->id }}">{{ $document->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="number">Numero</label>
            <input type="text" name="number" value="{{ old('number', $customer->number ?? '') }}" class="form-control" placeholder="Ingrese el Numero de identificacion ">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="name">Nombre del Cliente</label>
            <input type="text" name="name" value="{{ old('name', $customer->name ?? '') }}" class="form-control" placeholder="Ingrese el nombre del proveedor">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $customer->email ?? '') }}" class="form-control" placeholder="Ingrese el correo electronico">
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <button class="btn btn-celeste" type="submit"><i class="fa fa-save"></i> Guardar</button>
            <a href="{{url('cuastomer')}}" class="btn btn-gris"><i class="fa fa-window-close"></i> Cancelar</a>
        </div>
    </div>
</div>
