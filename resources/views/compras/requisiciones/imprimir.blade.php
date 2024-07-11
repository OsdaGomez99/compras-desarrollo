<!doctype html>
<html lang="es">
<head>
    <title>REQ. DE {{$requisicion->tipo}} NRO. {{$requisicion->numero}} </title>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>

        body {
            font-family: 'Helvetica';
            font-size: 10px;
            margin-top: 5.2cm;
            margin-bottom: 6cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        footer {
            position: fixed;
            bottom: 0px;
            left: 0cm;
            right: 0cm;
            height: 50px;
            margin-bottom: 175px;
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

        .page-break {
	        page-break-after: always;
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
                            Av. Las Américas - Edificio General de Seguros
                        </div>
                    </td>
                    <td>
                        <table class="w-full text-left">
                            <tr>
                                <td>N° Requisición:</td>
                                <td style="font-size: 1.20rem; font-weight: bold;">{{ $requisicion->numero }}</td>
                            </tr>
                            <tr>
                                <td>Fecha Requisición</td>
                                <td>{{\Carbon\Carbon::parse($requisicion->fecha_requisicion)->format('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <td>Prioridad</td>
                                <td>{{ $requisicion->prioridad->descripcion}}</td>
                            </tr>
                            <tr>
                                <td>Página</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="text-center">
            <h2>REQUISICIÓN DE COMPRA DE {{ $requisicion->tipo }}</h2>
        </div>
        <br>
        <table width="100%" class="table">
            <tbody>
                <tr>
                    <td class="font-bold border-table">DEPENDENCIA SOLICITANTE</td>
                    <td class="font-bold border-table"> LINEA </td>
                </tr>
                <tr>
                    <td class="border-table"> {{ $requisicion->unidad->nombre}}</td>
                    <td class="border-table"> {{ $requisicion->linea->descripcion}} </td>
                </tr>
            </tbody>
        </table>
    </header>

    <footer style="bottom:-5px;">
        @isset($requisicion->justificacion)
            <table width="100%" class="table">
                <tbody>
                    <tr>
                        <td class="font-bold border-table"> JUSTIFICACION </td>
                    </tr>
                    <tr>
                        <td class="border-table"> {{ $requisicion->justificacion}}<div class="text-white"><br>a</div></td>
                    </tr>
                </tbody>
            </table>
        @else
            <br><br><br><br><br>
        @endisset
        <table width="100%" class="table">
            <tbody>
                <tr>
                    <td class="text-center font-bold border-table" width="70%"> DEPENDENCIA SOLICITANTE</td>
                    <td class="text-center font-bold border-table" width="30%"> COMPRAS</td>
                </tr>
                <tr>
                    <td class="text-center font-bold border-table">
                        <div class="text-white">
                            a <br> a
                        </div>
                        <br>Jefe de Dependencia
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            |
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Firma Autorizada
                    </td>
                    <td class="text-center font-bold border-table">
                        <div class="text-white">
                            a <br> a <br> a
                        </div>
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
                @if ($requisicion->tipo == 'BIENES')
                    <td class="text-center font-bold border-table"> DESCRIPCION ARTICULO</td>
                @else
                    <td class="text-center font-bold border-table"> DESCRIPCION SERVICIO</td>
                @endif
                    <td class="text-center font-bold border-table">U.M</td>
                    <td class="text-center font-bold border-table"> CANT.</td>
                </tr>
                @foreach ($detalles as $d)
                    <tr>
                        <td class="text-center border-table"> {{ $loop->iteration }}</td>
                    @if ($requisicion->tipo == 'BIENES')
                        <td class="border-table"> {{ $d->articulo->descripcion }}</td>
                        <td class="text-center border-table"> {{ $d->articulo->medida->codigo }}</td>
                    @else
                        <td class="border-table"> {{ $d->descripcion }}</td>
                        <td class="text-center border-table"> {{ $d->medida->codigo }}</td>
                    @endif
                        <td class="text-center border-table"> {{ $d->cantidad }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(448, 83, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 8);
            ');
        }
    </script>

</body>
</html>
