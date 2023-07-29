<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ 'css/post.css' }}">
        <title>Factura de venta</title>

    </head>

    <header id="header">
        <!-- LOGGO -->
        <div class="center">
            <div id="logo">
                <img src="{{asset($company->logo) }}" alt="{{ $company->name }}">
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="center">
        <!--DATOS company -->
            <div class="empresa">
                <p><strong id="nombre">{{  $company->name  }}</strong></p>

                <p id="datos">Nit: {{ $company->nit }} - {{ $company->dv }} - {{ $company->regime->name }} - {{ $company->organization->name }} - {{ $invoice->branch->address }}- {{ $invoice->branch->phone }} - {{ $company->municipality->name }} - {{ $company->department->name }} <br> Email: {{ $invoice->branch->email }}
                    </p>
            </div>
            <!--DATOS FACTURA -->
            <div id="factura">
                <p> DOCUMENTO: <strong id="numfact">N°.{{ $invoice->id }}</strong> <br>
                    FECHA DE EMISION: <strong id="datfact">{{ date('d-m-Y', strtotime($invoice->created_at)) }}</strong>
                </p>
            </div>
        </div>
    </header>
    <div class="clearfix"></div>
    <body>
        <div class="content">
            <!--DATOS CLIENTE -->
            <p id="titulo">DATOS DEL CLIENTE</p>
            <div class="center">
                <div id="cliente">
                    <!--DATOS CLIENTE -->
                    <div id="titc">
                        <span id="tc">CC o NIT: </span><br>
                        <span id="tc">NOMBRE:   </span><br>
                        <span id="tc">EMAIL:    </span><br>
                    </div>
                    <div id="titd">
                        <span id="td">{{ $invoice->customer->number }}</span><br>
                        <span id="td">{{ $invoice->customer->name }}</span><br>
                        <span id="td">{{ $invoice->customer->email }}</span><br>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <table class="tabla">
                <!--DETALLE DE VENTA -->
                <thead>
                    <tr>
                        <th>Descripcion</th>
                        <th>Cant.</th>
                        <th>Valor</th>
                        <th>SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice_menus as $ip)
                    <tr>
                        <td>{{ $ip->menu->name }}</td>
                        <td id="ccent">{{ number_format($ip->quantity,2) }}</td>
                        <td class="tdder">${{ number_format($ip->price,2)}}</td>
                        <td class="tdder">${{number_format($ip->quantity * $ip->price,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <!--DATOS FTOTALES -->
                    <tr>
                        <th colspan="2" class="footder">TOTAL:</th>
                        <td colspan="2" class="footder"><strong>${{number_format($invoice->total,2)}}</strong></td>
                    </tr>

                    <tr>
                        <th colspan="2" class="footder">TOTAL IVA:</th>
                        <td colspan="2" class="footder"><strong>${{number_format($invoice->total_iva,2)}}</strong> </td>
                    </tr>

                    <tr>
                        <th  colspan="2" class="footder">TOTAL PAGAR:</th>
                        <td colspan="2" class="footder"><strong>${{number_format($invoice->total_pay,2)}}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <br>
        <br>
        <footer>
            Impreso por Ecounts S.A.S. derechos reservados
        </footer>
    </body>

</html>



