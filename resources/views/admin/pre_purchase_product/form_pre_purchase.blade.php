<div class="box-body row">

    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12" id="prepurch">
        <div class="form-group">
            <label for="prePurchase">Pre Compra </label>
            <input type="number" name="prePurchase" id="prePurchase" value="{{ $prePurchase->id }}" class="form-control">
        </div>
    </div>
    <div class="col-12 col-md-6">
        <label for="supplier_id">Proveedor <a href="{{ route('prePurchase.index') }}" class="btn btn-celeste btn-sm"><i class="fas fa-undo-alt mr-2"></i>Regresar</a></label>
        <div class="select">
            <select id="supplier_id" name="supplier_id" class="form-control selectpicker" data-live-search="true" disabled>
                <option {{ old('supplier_id', $prePurchase->supplier_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar Proveedor</option>
                @foreach($suppliers as $supplier)
                    @if(old('supplier_id', $prePurchase->supplier_id ?? '') == $supplier->id)
                        <option value="{{ $supplier->id }}" selected>{{ $supplier->name }}</option>
                    @else
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <label for="branch_id">Sucursal Destino</label>
        <div class="select">
            <select id="branch_id" name="branch_id" class="form-control selectpicker" data-live-search="true" disabled>
                <option {{ old('branch_id', $prePurchase->branch_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar Sucursal</option>
                @foreach($branchs as $branch)
                    @if(old('branch_id', $prePurchase->branch->branch_id ?? '') == $branch->id)
                        <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                    @else
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="generation_date">Fecha Generacion</label>
            <input type="date" name="generation_date" class="form-control" placeholder="Fecha Vencimiento">
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="due_date">Vencimiento</label>
            <input type="date" name="due_date" class="form-control" placeholder="Fecha Vencimiento">
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="document">N°Factura</label>
            <input type="text" id="document" name="document" value="{{ old('document') }}" class="form-control" placeholder="Numero de la factura" required>
        </div>
    </div>
    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12" id="startd">
        <div class="form-group">
            <label class="form-control-label" for="start_date">Fecha de inicio</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo date("Y-m-d");?>">
        </div>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" >
        <div class="form-check">
            <input class="form-check-input" type="radio" name="percentage" value="1" id="rtfon">
            <label class="form-check-label" for="retefte">
                Retenciones
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="percentage" value="0" id="rtfoff" checked>
            <label class="form-check-label" for="retefte">
                No Retenciones
            </label>
        </div>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12" id="percentagey">
        <div class="form-group row">
            <label class="form-control-label" for="percentage_id">Porcentaje</label>
            <select name="percentage_id" class="form-control selectpicker" id="percentage_id"
                data-live-search="true">
                <option value="1" disabled selected>Seleccionar.</option>
                @foreach($percentages as $percentage)
                <option
                    value="{{ $percentage->id }}_{{ $percentage->percentage }}">{{ $percentage->percentage }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="col-lg-3 col-md-2 col-sm-3 col-xs-12" id="percent">
        <div class="form-group">
            <label class="form-control-label" for="percentage">% Ret</label>
            <input type="number" id="percentage" name="percentage" value="0" class="form-control"
                placeholder="V impuesto" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table id="details" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>precio ($)</th>
                        <th>iva (%)</th>
                        <th>SubTotal ($)</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="4" class="footder">TOTAL:</th>
                        <td class="footder"><strong id="total_html">$ 0.00</strong>
                            <input type="hidden" name="total" id="total"></td>
                    </tr>
                    <tr>
                        <th colspan="4" class="footder">TOTAL IVA:</th>
                        <td class="footder"><strong id="total_iva_html">$ 0.00</strong>
                            <input type="hidden" name="total_iva" id="total_iva">
                        </td>
                    </tr>
                    <tr id="rtferase">
                        <th colspan="4" class="footder">RETENCION:</th>
                        <td class="footder"><strong id="retention_html">$ 0.00</strong>
                            <input type="hidden" name="retention" id="retention"></td>
                    </tr>
                    <tr>
                        <th colspan="4" class="footder">TOTAL PAGAR:</th>
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
