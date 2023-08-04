<div class="box-body row">
    <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="product_id">Materia Prima</label>
            <select name="product_id" class="form-control selectpicker" data-live-search="true" id="product_id">
                <option value="{{ old('product_id') }}" disabled selected>Seleccionar.</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}_{{ $product->price }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="quantity">Cantidad</label>
            <input type="text" name="quantity" value="0" id="quantity" class="form-control" placeholder="Cantidad segun Medida">
        </div>
    </div>
    <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="consumer_price">Precio</label>
            <input type="text" name="consumer_price" value="0" id="consumer_price" class="form-control" placeholder="Precio por unidad">
        </div>
    </div>
    <div class="col-lg-6 col-md-2 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="form-control-label">Adicionar</label><br>
            <button class="btn btn-grisb" type="button" id="add" data-toggle="tooltip" data-placement="top" title="Adicionar"><i class="fas fa-check"></i> </button>
        </div>
    </div>
    <div class="col-lg-6 col-md-2 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" >Canc</label><br>
            <a href="{{url('product')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table id="materials" class="table table-striped table-bordered table-condensed table-hover">
                <thead class="bg-info">
                    <tr>
                        <th>Eliminar</th>
                        <th>Editar</th>
                        <th>Materia Prina</th>
                        <th>Cantidad</th>
                        <th>Valor</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="5">
                            <p align="right">TOTAL:</p>
                        </th>
                        <th>
                            <p align="right"><span id="total_html">$ 0.00</span>
                                <input type="hidden" name="total" id="total"> </p>
                        </th>
                    </tr>
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
</div>
