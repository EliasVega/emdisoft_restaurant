<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ 'css/pdfs.css' }}">
        <title>Factura de venta</title>
    </head>
    <header id="header">
        <!-- LOGGO -->
        <div class="center">
            <div id="logo">
                <img src="{{asset($company->logo) }}" alt="{{ $company->name }}" width="150px" height="50px" class="app-logo">
            </div>
        <!--DATOS company -->
            <div class="empresa">
                <p><strong id="nombre">{{  $company->name  }}</strong></p>

                <p id="datos">Nit: {{ $company->nit }} -- {{ $company->dv }} --  {{ $company->liability->name }} -- <br> {{ $company->regime->name }} - {{ $company->organization->name }} <br>Resolucion N°. {{ $indicators->resolution }} Prefijo: {{ $indicators->prefix }} Rango {{ $indicators->from }} <br> al {{ $indicators->to }} -- Vigencia: desde {{ $indicators->date_from }} hasta {{ $indicators->date_to }} <br> {{ $invoice->branch->municipality->name }} -- {{ $invoice->branch->department->name }}  <br> --Sucursal - {{ $invoice->branch->name }} -- {{ $invoice->branch->address }} <br> Email: {{ $company->email }}
                    </p>
            </div>
            <!--DATOS FACTURA -->
            <div id="factura">
                <p> <h4>FACTURA ELECTRONICA <br> DE VENTA <br> <strong id="numfact">N°.{{ $indicators->prefix }} - {{ $invoice->document }}</strong>  </h4>

                </p>
                <p> <h4>FECHA DE EMISION <br> <strong id="detosfact">{{ date('d-m-Y', strtotime($invoice->created_at)) }}</strong>  </h4>
                </p>
            </div>
        </div>
    </header>
    <body>
        <!--DATOS CLIENTE -->
        <div class="content">
            <div class="center">
                <div id="tcliente">
                    <span id="titulo"><strong>DATOS DEL CLIENTE</strong></span>
                </div>
            </div>
            <div class="center">
                <!--CODIGO QR -->
                <div id="qr">
                    <img src="" alt="qr">
                </div>
                <div id="cliente">
                    <!--DATOS CLIENTE -->
                    <div id="titc">
                        <span id="tc">CC o NIT: </span><br>
                        <span id="tc">NOMBRE:   </span><br>
                        <span id="tc">REGIMEN:  </span><br>
                        <span id="tc">CIUDAD:   </span><br>
                        <span id="tc">TELEFONO: </span><br>
                        <span id="tc">EMAIL:    </span><br>
                        <span id="tc">DIRECCION:</span><br>
                    </div>
                    <div id="titd">
                        <span id="td">{{ $invoice->customer->number }}</span><br>
                        <span id="td">{{ $invoice->customer->name }}</span><br>
                        <span id="td">{{ $invoice->customer->regime->name }}</span><br>
                        <span id="td">{{ $invoice->customer->municipality->name }}</span><br>
                        <span id="td">{{ $invoice->customer->phone }}</span><br>
                        <span id="td">{{ $invoice->customer->email }}</span><br>
                        <span id="td">{{ $invoice->customer->address }}</span><br>
                    </div>
                </div>
                <div id="fpago">
                    <!--FORMA DE PAGO-->
                    <div id="tfpago">
                        <span id="tc">F. pago: </span><br>
                        <span id="tc">M. pago:   </span><br>
                        <span id="tc">Vence:</span><br>
                    </div>
                    <div id="dfpago">
                        <span id="td">{{ $invoice->paymentForm->name }}</span><br>
                        <span id="td">{{ $invoice->paymentMethod->name }}</span><br>
                        <span id="td">{{ $invoice->due_date }}</span><br>
                    </div>
                </div>

            </div>

        </div>
        <div class="contenido">
            <div class="center">
                <div id="ttabla">
                    <table class="tabla">
                        <!--DETALLE DE VENTA -->
                        <thead>
                            <tr>
                                <th id="uno">Cant.</th>
                                <th id="dos">Descripcion del producto</th>
                                <th>Valor</th>
                                <th>SubTotal ($)</th>
                            </tr>
                        </thead>
                        <tbody class="detalle">
                            @foreach ($invoice_products as $ip)
                            <tr>
                                <td id="ccent">{{ number_format($ip->quantity,2) }}</td>
                                <td>{{ $ip->product->name }}</td>
                                <td class="tdder">${{ number_format($ip->price,2)}}</td>
                                <td class="tdder">${{number_format($ip->quantity * $ip->price,2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <!--DATOS FTOTALES -->
                            <tr>
                               <th colspan="3" class="footder">TOTAL:</th>
                               <td class="footder"><strong>${{number_format($invoice->total,2)}}</strong></td>
                            </tr>

                            <tr>
                                <th colspan="3" class="footder">TOTAL IVA:</th>
                                <td class="footder"><strong>${{number_format($invoice->total_iva,2)}}</strong> </td>
                            </tr>

                            <tr>
                                <th  colspan="3" class="footder">TOTAL PAGAR:</th>
                                <td class="footder"><strong id="total">${{number_format($invoice->total_pay,2)}}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
        <br>
        <br>
        <footer>
            Impreso por Ecounts S.A.S. derechos reservados
        </footer>
    </body>
</html>



