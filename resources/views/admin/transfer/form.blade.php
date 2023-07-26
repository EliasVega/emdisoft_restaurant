<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
    <div class="form-group">
        <label class="form-control-label" for="branch">Sucursal Origen</label>
        <input type="text" id="branch" value="{{ $branch->name }}" name="sucursal" class="form-control"
            placeholder="Sucursal" readonly>
    </div>
</div>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="form-group row">
        <label class="form-control-label" for="branch_id">Sucursal Destino</label>
        <select name="branch_id" class="form-control selectpicker" id="branch_id"
            data-live-search="true" required>
            <option value="" disabled selected>Seleccionar Sucursal</option>
            @foreach($branches as $bra)
            <option value="{{ $bra->id }}">{{ $bra->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <div class="box-danger">
        <label class="form-control-label">
            <h4>Agregar Productos</h4>
        </label>
    </div>
</div>
<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12">
    <div class="form-group idpro" >
        <label class="form-control-label" for="idP">ID</label>
        <input type="number" id="idP" name="idP" class="form-control"
            placeholder="ID" readonly>
    </div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group row">
        <label class="form-control-label" for="product_id">Producto</label>
        <select name="product_id" class="form-control selectpicker" id="product_id"
            data-live-search="true">
            <option value="0" disabled selected>Seleccionar el Producto</option>
            @foreach($branch_products as $bp)
            <option
                value="{{ $bp->id }}_{{ $bp->idP }}_{{ $bp->stock }}">{{ $bp->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
    <div class="form-group">
        <label class="form-control-label" for="quantity">Cantidad</label>
        <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
            class="form-control" placeholder="Ingrese la cantidad">
    </div>
</div>

<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
    <div class="form-group">
        <label class="form-control-label" for="stock">Stock</label>
        <input type="number" id="stock" name="stock" class="form-control"
            placeholder="stock" readonly>
    </div>
</div>


<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
    <div class="form-group">
        <label class="form-control-label">Add</label><br>
        <button class="btn btn-grisb" type="button" id="add" data-toggle="tooltip" data-placement="top" title="adicionar"><i class="fas fa-check"></i>&nbsp; </button>
    </div>
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
    <div class="form-group">
        <label class="form-control-label" >Canc</label><br>
        <a href="{{url('product_branch')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
        <table id="details" class="table table-striped table-bordered table-condensed table-hover">
            <thead class="th-gris">
                <tr class="th-gris">
                    <th>Eliminar</th>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>stock</th>
                    <th>Cantidad</th>
                    <th>Destino</th>
                </tr>
            </thead>
            <tfoot>

            </tfoot>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer" id="save">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button class="btn btn-celeste" type="submit"><i class="fa fa-save"></i>&nbsp;
                Registrar</button>
        </div>
    </div>
</div>
