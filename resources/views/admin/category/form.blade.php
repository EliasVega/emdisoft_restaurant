<div class="box-body row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="name">Nombre de la category</label>
            <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="form-control" placeholder="Nombre de la category">
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="inc">INC</label>
            <input type="number" name="inc" value="{{ old('inc', $category->inc ?? '') }}" class="form-control" placeholder="Porcentaje INC para la category">
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="utility">Utilidad</label>
            <input type="number" name="utility" value="{{ old('utility', $category->utility ?? '') }}" class="form-control" placeholder="utilidad de la category">
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="description">Descripcion de la category</label>
            <input type="text" name="description" value="{{ old('description', $category->description ?? '') }}" class="form-control" placeholder="descripcion de la category">
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-save"></i>&nbsp; Guardar</button>
            <a href="{{url('category')}}" class="btn btn-danger"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
        </div>
    </div>
</div>
