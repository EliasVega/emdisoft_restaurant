<div class="box-body row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="category_id">Categorias</label>
        <div class="select">
            <select id="category_id" name="category_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ ($product->category_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar categoria</option>
                @foreach($categories as $category)
                    @if($category->id == ($product->category_id ?? ''))
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="unit_measure_id">Unidad de Medida</label>
        <div class="select">
            <select id="unit_measure_id" name="unit_measure_id" class="form-control selectpicker" data-live-search="true" required>
                <option {{ ($product->unit_measure_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar Medida</option>
                @foreach($measures as $measure)
                    @if($measure->id == ($product->unit_measure_id ?? ''))
                        <option value="{{ $measure->id }}" selected>{{ $measure->name }}</option>
                    @else
                        <option value="{{ $measure->id }}">{{ $measure->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="form-control" placeholder="Nombre del producto">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="code">Codigo</label>
            <input type="text" name="code" value="{{ old('code', $product->code ?? '') }}" class="form-control" placeholder="Codigo del product">
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="price">Precio producto unidad</label>
            <input type="text" name="price" value="{{ old('price', $product->price ?? '') }}" class="form-control" placeholder="Precio de Compra">
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="text" name="stock" value="{{old('stock', $product->stock ?? '') }}" class="form-control" placeholder="Ingrese el Stock" readonly>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <button class="btn btn-celeste btn-md mt-3" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
            <a href="{{url('product')}}" class="btn btn-gris mt-3"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
        </div>
    </div>
</div>
