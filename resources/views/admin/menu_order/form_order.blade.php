<div class="box-body row">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" id="addCustomer">
        <div class="form-group">
            <label for="customer_id">Cliente   <button class="btn btn-celeste btn-sm mb-2" type="button"
                data-toggle="modal" data-target="#customer"><i class="fa fa-plus mr-md-2"></i>Agregar</button></label>
            <select name="customer_id" class="form-control selectpicker" id="customer_id"
                data-live-search="true" required>
                <option value="" disabled selected>Seleccionar el Cliente</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->number }} - {{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 mt-3" id="addOrder">
        <div class="form-group">
            <label for="order">Orden de Pedido </label>
            <input type="number" name="order" id="order" value="{{ $order->id }}" class="form-control" readonly>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table id="details" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Menu</th>
                        <th>Cantidad</th>
                        <th>precio ($)</th>
                        <th>inc ($)</th>
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
                        <th colspan="5" class="footder">TOTAL INC:</th>
                        <td class="footder"><strong id="total_inc_html">$ 0.00</strong>
                            <input type="hidden" name="total_inc" id="total_inc">
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
