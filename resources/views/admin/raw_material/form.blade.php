<div class="box-body row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="category_id">Categorias</label>
        <div class="select">
            <select id="category_id" name="category_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ ($rawMaterial->category_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar categoria</option>
                @foreach($categories as $category)
                    @if($category->id == ($rawMaterial->category_id ?? ''))
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $rawMaterial->name ?? '') }}" class="form-control" placeholder="Nombre del rawMaterialo">
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="code">Codigo</label>
            <input type="text" name="code" value="{{ old('code', $rawMaterial->code ?? '') }}" class="form-control" placeholder="Codigo del rawMaterial">
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label for="price">Precio Unidad</label>
            <input type="text" name="price" value="{{ old('price', $rawMaterial->price ?? '') }}" class="form-control" placeholder="Precio de Compra">
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <label for="unit_measure_id">Unidad de Medida</label>
        <div class="select">
            <select id="unit_measure_id" name="unit_measure_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ ($rawMaterial->unit_measure_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar Medida</option>
                @foreach($measures as $measure)
                    @if($measure->id == ($rawMaterial->unit_measure_id ?? ''))
                        <option value="{{ $measure->id }}" selected>{{ $measure->name }}</option>
                    @else
                        <option value="{{ $measure->id }}">{{ $measure->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <button class="btn btn-celeste btn-md mt-3" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
            <a href="{{url('rawMaterial')}}" class="btn btn-gris mt-3"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
        </div>
    </div>
</div>
