<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ 'css/pdfs.css' }}">
        <title>Pre Compra</title>

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

                <p id="datos">Nit: {{ $company->nit }} -- {{ $company->dv }} --  {{ $company->liability->name }} -- <br> R. fiscal. {{ $company->regime->name }}  <br> {{ $company->organization->name }}  {{ $company->address }} <br> {{ $company->municipality->name }} -- {{ $company->department->name }} <br> Email: {{ $company->email }}
                    </p>
            </div>
            <!--DATOS FACTURA -->
            <div id="factura">
                <p> <h4>COMPRA <br> <strong id="numfact">N°.{{ $prePurchase->id }}</strong>  </h4>

                </p>
                <p> <h4>FECHA DE EMISION <br> <strong id="detosfact">{{ date('d-m-Y', strtotime($prePurchase->created_at)) }}</strong>  </h4>
                </p>
            </div>
        </div>
    </header>
    <body>
        <!--DATOS CLIENTE -->
        <div class="content">
            <div class="center">
                <div id="tcliente">
                    <span id="titulo"><strong>DATOS DEL PROVEEDOR</strong></span>
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
                        <span id="td">{{ $prePurchase->supplier->identification }} - {{ $prePurchase->supplier->dv }}</span><br>
                        <span id="td">{{ $prePurchase->supplier->name }}</span><br>
                        <span id="td">{{ $prePurchase->supplier->regime->name }}</span><br>
                        <span id="td">{{ $prePurchase->supplier->municipality->name }}</span><br>
                        <span id="td">{{ $prePurchase->supplier->phone }}</span><br>
                        <span id="td">{{ $prePurchase->supplier->email }}</span><br>
                        <span id="td">{{ $prePurchase->supplier->address }}</span><br>
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
                                <th id="dos">Descripcion del producto</th>
                                <th id="uno">Cant.</th>
                                <th>Valor</th>
                                <th>SubTotal ($)</th>
                            </tr>
                        </thead>
                        <tbody class="detalle">
                            @foreach ($prePurchaseProducts as $prePurchaseProduct)
                            <tr>
                                <td>{{ $prePurchaseProduct->product->name }}</td>
                                <td id="ccent">{{ number_format($prePurchaseProduct->quantity,2) }}</td>
                                <td class="tdder">${{ number_format($prePurchaseProduct->price,2)}}</td>
                                <td class="tdder">${{number_format($prePurchaseProduct->quantity * $prePurchaseProduct->price,2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <!--DATOS FTOTALES -->
                            <tr>
                               <th colspan="3" class="footder">TOTAL:</th>
                               <td class="footder"><strong>${{number_format($prePurchase->total,2)}}</strong></td>
                            </tr>

                            <tr>
                                <th colspan="3" class="footder">TOTAL IVA:</th>
                                <td class="footder"><strong>${{number_format($prePurchase->total_iva,2)}}</strong> </td>
                            </tr>

                            <tr>
                                <th  colspan="3" class="footder">TOTAL PAGAR:</th>
                                <td class="footder"><strong id="total">${{number_format($prePurchase->total_pay,2)}}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
        <br>
        <br>
        <footer>
            Impreso por EmdisoftPro S.A.S. derechos reservados
        </footer>
    </body>
</html>



