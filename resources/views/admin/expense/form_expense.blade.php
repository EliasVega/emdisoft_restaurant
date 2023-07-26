<div class="box-body row">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="supplier_id">Proveedor  <button class="btn btn-celeste btn-sm" type="button" data-toggle="modal" data-target="#supplier"><i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar</button></label>
            <select name="supplier_id" class="form-control selectpicker" id="supplier_id"
                data-live-search="true" required>
                <option value="" disabled selected>Seleccionar el Proveedor</option>
                @foreach($suppliers as $sup)
                <option value="{{ $sup->id }}">{{ $sup->number }} - {{ $sup->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="document">Comprobante</label>
            <input type="text" id="document" name="document" value="N/A" class="form-control" placeholder="Numero Recibo">
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="due_date">Vencimiento</label>
            <input type="date" name="due_date" class="form-control" placeholder="Fecha Vencimiento">
        </div>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="note">Nota</label>
            <input type="text" id="note" name="note" class="form-control" placeholder="Describe una nota">
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" id="addIva">
        <div class="form-group">
            <label class="form-control-label" for="iva">Iva</label>
            <input type="number" id="iva" name="iva" class="form-control" placeholder="Iva" disabled
                pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group row">
            <label class="form-control-label" for="service_id">Servicio</label>
                <select name="service_id" class="form-control selectpicker" id="service_id" data-live-search="true">
                    <option value="0" disabled selected>Seleccionar el Servicio</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}_{{ $service->category->iva }}">{{ $service->name }}</option>
                    @endforeach
                </select>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="quantity">Cantidad</label>
            <input type="number" id="quantity" name="quantity" value=""
                class="form-control" placeholder="Cantidad" pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="price">Precio</label>
            <input type="number" id="price" name="price" class="form-control"
                placeholder="Precio">
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            <label class="form-control-label">Add</label><br>
            <button class="btn btn-grisb" type="button" id="add" data-toggle="tooltip" data-placement="top" title="Add"><i class="fas fa-check"></i>&nbsp; </button>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" >Canc</label><br>
            <a href="{{url('expense')}}" class="btn btn-grisb" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-window-close"></i>&nbsp; </a>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table id="details" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Eliminar</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>precio ($)</th>
                        <th>iva (%)</th>
                        <th>SubTotal ($)</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="5" class="footder">TOTAL:</th>
                        <td class="footder"><strong id="total_html">$ 0.00</strong>
                            <input type="hidden" name="total" id="total"></td>
                    </tr>
                    <tr>
                        <th colspan="5" class="footder">TOTAL IVA:</th>
                        <td class="footder"><strong id="total_iva_html">$ 0.00</strong>
                            <input type="hidden" name="total_iva" id="total_iva">
                        </td>
                    </tr>
                    <tr>
                        <th colspan="5" class="footder">TOTAL PAGAR:</th>
                        <td class="footder"><strong id="total_pay_html">$ 0.00</strong>
                            <input type="hidden" name="total_pay" id="total_pay"></td>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
