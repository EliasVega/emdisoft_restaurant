<div class="box-body row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" >
                    <thead class="bg-info">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>precio ($)</th>
                            <th>SubTotal ($)</th>
                        </tr>
                    </thead>
                    <tbody class="fact">
                        @foreach ($invoice_products as $ip)
                        <tr>
                            <td>{{ $ip->name }}</td>
                            <td>{{ $ip->quantity }}</td>
                            <td class="tdder">{{ $ip->price }}</td>
                            <td class="tdder">{{ $ip->subtotal }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th  colspan="3"><p align="right">TOTAL:</p></th>
                            <th><p align="right"><span>${{ number_format($invoices->total,2) }}</span>
                                <input type="hidden" name="vtotal"> </p></th>
                        </tr>

                        <tr>
                            <th colspan="3"><p align="right">TOTAL IVA:</p></th>
                            <th><p align="right"><span>${{ number_format($invoices->total_iva,2) }}</span>
                                <input type="hidden" name="vtotal_iva"></p></th>
                        </tr>

                        <tr>
                            <th  colspan="3"><p align="right">TOTAL PAGAR:</p></th>
                            <th><p align="right"><span align="right">${{ number_format($invoices->total_pay,2) }}</span>
                                <input type="hidden" name="vtotal_pay"></p></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <div class="modal-footer" id="save">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group row">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button class="btn btn-success" type="submit"><i class="fa fa-save fa-2x"></i>&nbsp; Registrar</button>
            </div>
        </div>
    </div>
</div>
