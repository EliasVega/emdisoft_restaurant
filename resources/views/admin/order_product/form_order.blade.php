<div class="box-body row">
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12" id="addOrder">
        <div class="form-group">
            <label for="order">Orden de Pedido </label>
            <input type="number" name="order" id="order" value="{{ $order->id }}" class="form-control">
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <label for="customer_id">Cliente </label>
        <div class="select">
            <select id="customer_id" name="customer_id" class="form-control selectpicker" data-live-search="true" disabled>
                <option {{ old('customer_id', $order->customer_id ?? '') == '' ? "selected" : "" }} disabled>Seleccionar Cliente</option>
                @foreach($customers as $customer)
                    @if(old('supplier_id', $order->customer->customer_id ?? '') == $customer->id)
                        <option value="{{ $customer->id }}" selected>{{ $customer->name }}</option>
                    @else
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="due_date">Vencimiento</label>
            <input type="date" name="due_date" class="form-control" value="{{ $order->due_date }}">
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
