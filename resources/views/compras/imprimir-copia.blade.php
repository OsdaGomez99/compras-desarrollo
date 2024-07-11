<!doctype html>
<html lang="es">

<head>

    <div class="page-break"></div>

    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        body {
            font-family: 'Helvetica';
            font-size: 12px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
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
            border: 1px solid #727272;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }

        .table td {
            border-top: 0.2px dashed #727272;
        }

        .font-bold {
            font-weight: bold;
        }

        .h2 {
            font-size: 32px;
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
                            SISTEMA DE COMPRAS DE BIENES Y SERVICIOS
                        </div>
                    </td>
                    <td>
                        <table class="w-full">

                            <tr>
                                <td>Fecha:</td>
                                <td>{{ $requisicion->fecha_requisicion }}</td>
                            </tr>

                            <tr>
                                <td>N° Requisición:</td>
                                <td>{{ $recepcion->num_doc }}</td>
                            </tr>

                            <tr>
                                <td>Tipo de Solicitud</td>
                                <td>{{ $requisicion->tipo }}</td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>

        </div>

        <div class="text-center">
            <h2> Requisición de Compra</h2> <br>
        </div>
    </header>

    @if (isset($compra))
        <div>
            <table width="100%" class="table table-responsive w-100 d-block d-md-table table-hover">

                <x-table.table-header :encabezados="['Número Orden Compra', 'Código Proveedor', 'Proveedor', ' RIF ']" />

                <tbody>
                    <tr>

                        <td class="text-gray-900 text-center"> {{ $compra->num_compra }} </td>
                        <td class="text-gray-900 text-center"> {{ $compra->proveedor->codigo }} </td>
                        <td class="text-gray-900 text-center"> {{ $compra->proveedor->nombre }} </td>
                        <td class="text-gray-900 text-center"> {{ $compra->proveedor->rif }} </td>
                    </tr>
                </tbody>

            </table>

        </div>
    @endif


    <table width="100%" class="table table-responsive w-100 d-block d-md-table table-hover">

        <x-table.table-header :encabezados="[' ', 'Descripción', 'Cantidad Llegada']" />

        <tbody>
            @foreach ($detalles as $d)
                <tr>

                    <td class="text-gray-900 text-center"> {{ $d->num_linea }} </td>
                    <td class="text-gray-900 text-center"> {{ $d->articulo->descripcion }}</td>
                    <td class="text-gray-900 text-center"> {{ $d->cantidad }} </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>

<footer style="bottom:-5px;">
    <table width="100%">
        <tr>
            <td class="text-left"> Resp: {{ $requisicion->user->nombre }}</td>
        </tr>
    </table>
</footer>

</html>

<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $pdf->text(270, 730, "página $PAGE_NUM de $PAGE_COUNT", $font, 7);
        ');
    }
</script>
