<div class="box-body row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="name">Proveedor</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Proveedor">
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="number">NIT / CC</label>
            <input type="text" name="number" value="{{ old('number') }}" class="form-control" placeholder="identificacion ">
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="document_id">T/Identificacion</label>
            <select name="document_id" class="form-control selectpicker" data-live-search="true" id="document_id" required>
                <option value="{{ old('document_id') }}" disabled selected>Seleccionar.</option>
                @foreach($documents as $doc)
                    <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <button class="btn btn-celeste" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
            <a href="{{url('purchase/create')}}" class="btn btn-gris"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
        </div>
    </div>
</div>