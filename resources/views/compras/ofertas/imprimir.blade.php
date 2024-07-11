<!doctype html>
<html lang="es">
<head>
    <title>OFERTA PARA PROVEEDOR: {{$oferta->proveedor->nombre}} - COT. DE {{$oferta->tipo}} NRO. {{$oferta->cotizacion->numero}} </title>
    <div class="page-break"></div>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>

        body {
            font-family: 'Helvetica';
            font-size: 10px;
            margin-top: 7cm;
            margin-bottom: 6cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0cm;
        }

        footer {
            position: fixed;
            bottom: 0px;
            left: 0cm;
            right: 0cm;
            height: 50px;
            margin-bottom: 175px;
        }

        .page_break {
            page-break-before: always;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .w-full {
            width: 100%;
        }

        .p {
            padding: 1rem;
        }

        .table {
            color: #212529;
            background-color: transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
            border-collapse: collapse;
        }

        .border-table {
            border: 0.15px solid;
            padding: 0.3em;
        }

        .font-bold {
            font-weight: bold;
        }

        .h2 {
            font-size: 32px;
        }

        .text-white{
            color: white;
        }

    </style>

</head>

<body>

    <header>
        <div class="w-full">
            <table width="100%">
                <tr>
                    <td>
                        <img src="{{ public_path('images/logo.png') }}" width="45px" height="45px" />
                    </td>
                    <td>
                        <div class="text-left">
                            UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA <br>
                            Sistema de Compras de Bienes y Servicios <br>
                            Av. Las Américas - Edificio General de Seguros <br>
                            Teléfono: (7137) 215-263-119-116 <br>
                            Puerto Ordaz - Edo. Bolivar <br>
                            R.I.F.: G-20003343-6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N.I.T.: 0274494255
                        </div>
                    </td>
                    <td>
                        <table class="w-full text-left">
                            <tr>
                                <td>N° Cotización:</td>
                                <td style="font-size: 1.20rem; font-weight: bold;">{{ $oferta->cotizacion->numero }}</td>
                            </tr>
                            <tr>
                                <td>Fecha Cotización:</td>
                                <td>{{\Carbon\Carbon::parse($oferta->cotizacion->fecha_cotizacion)->format('d/m/Y')}}</td>
                            </tr>
                            @if ($oferta->tipo == 'BIENES')
                                <tr>
                                    <td class="text-white">Fecha Tope:</td>
                                </tr>
                                <tr>
                                    <td class="text-white">Hora Tope:</td>
                                </tr>
                            @else
                                <tr>
                                    <td>Fecha Tope:</td>
                                    <td>{{\Carbon\Carbon::parse($oferta->cotizacion->fecha_tope)->format('d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Hora Tope:</td>
                                    <td>{{\Carbon\Carbon::parse($oferta->cotizacion->fecha_cotizacion)->format('d/m/Y')}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Página:</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="text-center">
            <h2>COTIZACION DE {{ $oferta->tipo }}</h2>
        </div>
        <br>
        <table width="100%" class="table">
            <tbody>
                <tr>
                    <td class="font-bold border-table">
                        PROVEEDOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $oferta->proveedor->rif}} <br>
                        {{ $oferta->proveedor->nombre}}
                    </td>
                    <td class="font-bold border-table">TELEFONOS</td>
                </tr>
                <tr>
                    <td class="border-table">
                        {{ $oferta->proveedor->direccion}} <br>
                        <span class="font-bold">PERSONA CONTACTO:</span>
                        {{ $oferta->proveedor->representante}}
                        {{ $oferta->proveedor->email}}
                    </td>
                    <td class="border-table">
                        @if (!$oferta->proveedor->telefono)
                            {{ $oferta->proveedor->telefono_alt}}
                        @elseif (!$oferta->proveedor->telefono_alt)
                            {{ $oferta->proveedor->telefono}}
                        @else
                            {{ $oferta->proveedor->telefono}} <br>
                            {{ $oferta->proveedor->telefono_alt}}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" class="table">
            <tbody>
                <tr>
                    <td class="border-table">
                    ES GRATO DIRIGIRNOS A USTEDES EN LA OPORTUNIDAD DE SALUDARLES Y SOLICITARLES LA COTIZACION CON
                    PRECIOS ACCESIBLES PARA LA COMPRA DE LOS {{$oferta->tipo}} ESPECIFICADOS A CONTINUACION:
                    </td>
                </tr>
            </tbody>
        </table>

    </header>

    <footer style="bottom:-5px;">

            <table width="100%" class="table">
                <tbody>
                    <tr>
                        <td class="font-bold border-table"> CONDICIONES GENERALES </td>
                    </tr>
                    <tr>
                        <td class="border-table"> {{$oferta->condiciones_venta}} <div class="text-white"><br>a</div></td>

                    </tr>
                </tbody>
            </table>
        <table width="100%" class="table">

            <tbody>
                <tr>
                    <td class="text-center font-bold border-table" width="70%"> ATENTAMENTE</td>
                </tr>
                <tr>
                    <td class="text-center font-bold border-table">
                        JEFE DE DEPARTAMENTO DE COMPRAS DE {{ $oferta->tipo }}
                    </td>
                </tr>
            </tbody>
        </table>

    </footer>

    <main>

        <table width="100%" class="table">
            <tbody>
                <tr>
                    <td class="text-center font-bold border-table">#</td>
                    <td class="text-center font-bold border-table"> DESCRIPCION</td>
                    <td class="text-center font-bold border-table">U.M</td>
                    <td class="text-center font-bold border-table"> CANT.</td>
                </tr>
                @foreach ($detalles as $d)
                    <tr>
                        <td class="text-center border-table"> {{ $loop->iteration }}</td>
                        <td class="border-table"> {{ $d->detalle_req->articulo->descripcion }}</td>
                        <td class="text-center border-table"> {{ $d->detalle_req->articulo->medida->codigo }}</td>
                        <td class="text-center border-table"> {{ $d->cantidad }} </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>

<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $pdf->text(446, 95, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 8);
        ');
    }
</script>
