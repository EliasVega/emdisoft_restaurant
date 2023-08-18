<div class="box-body row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="document_id">Tipo Documento</label>
        <div class="select">
            <select id="document_id" name="document_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ old('document_id', $supplier->document_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar Documento</option>
                @foreach($documents as $document)
                    @if(old('document_id', $supplier->document_id ?? '') == $document->id)
                        <option value="{{ $document->id }}" selected>{{ $document->name }}</option>
                    @else
                        <option value="{{ $document->id }}">{{ $document->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="number">Numero</label>
            <input type="text" name="number" value="{{ old('number', $supplier->number ?? '') }}" class="form-control" placeholder="Ingrese el Numero de identificacion ">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="name">Nombre del Proveedor</label>
            <input type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}" class="form-control" placeholder="Ingrese el nombre del proveedor">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $supplier->email ?? '') }}" class="form-control" placeholder="Ingrese el correo electronico">
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <button class="btn btn-celeste" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
            <a href="{{url('supplier')}}" class="btn btn-gris"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
        </div>
    </div>
</div>
