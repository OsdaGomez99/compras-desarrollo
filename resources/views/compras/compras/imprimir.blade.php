<!doctype html>
<html lang="es">

<head>
    <title>ORDEN DE COMPRA DE {{$compra->tipo}} NRO. {{$compra->numero}} </title>
    <div class="page-break"></div>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>

        body {
            font-family: 'Helvetica';
            font-size: 10px;
            margin-top: 8cm;
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
                                <td>N° Compra:</td>
                                <td style="font-size: 1.20rem; font-weight: bold;">{{ $compra->numero }}</td>
                            </tr>
                            <tr>
                                <td>Tipo Procedimiento</td>
                                <td>{{ $compra->tipo_adjudicacion->descripcion }}</td>
                            </tr>
                            <tr>
                                <td>Fecha Compra:</td>
                                <td>{{\Carbon\Carbon::parse($compra->cotizacion->fecha_cotizacion)->format('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <td>Página:</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="text-center">
            <h2>ORDEN DE COMPRA DE {{ $compra->tipo }}</h2>
        </div>
        <table width="100%" class="table">
            <tbody>
                <tr>
                    <td class="border-table">
                    LA UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA POR LA PRESENTE SOLICITA EL SUMINISTRO DE LOS {{$compra->tipo}}
                    SIGUIENTES, SUJETO A LOS TERMINOS Y CONDICIONES ESTABLECIDAS EN LA NORMATIVA QUE EN LA MATERIA RIJA EN LA UNIDAD.
                    ESTA ORDEN CONSTITUYE EL CONVENIO ENTRE LA UNIVERSIDAD Y EL PROVEEDOR
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" class="table">
            <tbody>
                <tr>
                    <td class="border-table">
                        <span class="font-bold">PROVEEDOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $compra->proveedor->rif}}</span><br>
                        {{ $compra->proveedor->nombre}}
                    </td>
                    <td class="border-table">
                        <span class="font-bold">FORMA PAGO</span><br>
                        {{ $compra->forma_pago->descripcion}}
                    </td>
                    <td class="border-table">
                        <span class="font-bold">UNIDADES SOLICITANTES</span><br>
                        {{ $compra->cotizacion->nombre}}
                    </td>
                </tr>
                <tr>
                    <td class="border-table">
                    <span class="font-bold">LUGAR DE ENTREGA</span><br>
                        {{ $compra->punto_envio->descripcion}} - {{ $compra->punto_envio->direccion}}
                    </td>
                    <td class="border-table"></td>
                    <td class="border-table"></td>
                </tr>
            </tbody>
        </table>
        @if ($compra->tipo == 'SERVICIOS')
        <table width="100%" class="table">
            <tbody>
                    <tr>
                        <td class="border-table">
                            <span class="font-bold">NRO. RESOLUCION</span><br>
                            a
                        </td>
                        <td class="border-table">
                            <span class="font-bold">FIANZA DE ANTICIPO</span><br>
                            a
                        </td>
                        <td class="border-table">
                            <span class="font-bold">FIANZA DE FIEL COMP.</span><br>
                            a
                        </td>
                        <td class="border-table">
                            <span class="font-bold">% DE ANTICIPO</span><br>
                            a
                        </td>
                        <td class="border-table">
                            <span class="font-bold">LAPSO DE EJECUCION</span><br>
                            a
                        </td>
                    </tr>
                @endif
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
                        <td class="border-table"> {{$compra->nota1}} <div class="text-white"><br>a</div></td>

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
                        JEFE DE DEPARTAMENTO DE COMPRAS DE {{ $compra->tipo }}
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
                        <td class="border-table"> {{ $d->detalle_of->detalle_req->articulo->descripcion }}</td>
                        <td class="text-center border-table"> {{ $d->detalle_of->detalle_req->articulo->medida->codigo }}</td>
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
            $pdf->text(439, 83, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 8);
        ');
    }
</script>
