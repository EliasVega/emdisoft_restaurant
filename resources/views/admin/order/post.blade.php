<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ 'css/post.css' }}">
        <title>Factura de compra</title>

    </head>

    <header id="header">
        <!-- LOGGO -->
        <div class="center">
            <div id="logo">
                <img src="{{ public_path('images/logos/'.$company->logo) }}" alt="{{ $company->name }}">
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="center">
        <!--DATOS company -->
            <div class="empresa">
                <p><strong id="nombre">{{  $company->name  }}</strong></p>

                <p id="datos">Nit: {{ $company->nit }} - {{ $company->dv }}  {{ $order->user->branch->address }} - {{ $company->municipality->name }} {{ $company->department->name }} <br> Email: {{ $order->user->branch->email }}
                    </p>
            </div>
            <!--DATOS FACTURA -->
            <div id="factura">
                <p> COMANDA: <strong id="numfact">N°.{{ $order->id }}</strong> <br>
                    FECHA DE EMISION: <strong id="datfact">{{ date('d-m-Y', strtotime($order->created_at)) }}</strong>
                </p>
            </div>
        </div>
    </header>
    <div class="clearfix"></div>
    <body>
            <table class="tabla">
                <!--DETALLE DE VENTA -->
                <thead>
                    <tr>
                        <th>estado</th>
                        <th>Descripcion</th>
                        <th>Cant.</th>
                        <th>Valor</th>
                        <th>SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menuOrders as $menuOrder)
                    <tr>
                        <td>{{ $menuOrder->status }}</td>
                        <td>{{ $menuOrder->menu->name }}</td>
                        <td id="ccent">{{ number_format($menuOrder->quantity,2) }}</td>
                        <td class="tdder">${{ number_format($menuOrder->price,2)}}</td>
                        <td class="tdder">${{number_format($menuOrder->quantity * $menuOrder->price,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <!--DATOS FTOTALES -->
                    <tr>
                        <th colspan="4" class="footder">TOTAL:</th>
                        <td class="footder"><strong>${{number_format($order->total,2)}}</strong></td>
                    </tr>
                    @if ($order->total_iva > 0)
                        <tr>
                            <th colspan="4" class="footder">TOTAL IVA:</th>
                            <td class="footder"><strong>${{number_format($order->total_iva,2)}}</strong> </td>
                        </tr>

                        <tr>
                            <th  colspan="4" class="footder">TOTAL PAGAR:</th>
                            <td class="footder"><strong>${{number_format($order->total_pay,2)}}</strong></td>
                        </tr>
                    @endif
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



