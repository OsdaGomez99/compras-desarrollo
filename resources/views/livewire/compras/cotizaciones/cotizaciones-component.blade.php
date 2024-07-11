<div>
    @if (session('success'))
        <x-session-alert type="success">
            {{ session('success') }}
        </x-session-alert>
    @elseif (session('error'))
        <x-session-alert type="danger">
            {{ session('error') }}
        </x-session-alert>
    @endif

    <div class="overflow-x-scroll">

        <x-table.table class="table-auto">

            <x-table.table-header :encabezados="['Nro. Cotización', 'Tipo', 'Fecha Cotización', 'Status', 'Acciones']" />

            <tbody>
                @forelse ($cotizaciones as $cot)

                    <tr>
                        <td wire:click="detalleCotizacion({{ $cot->id }})" class="px-3 py-2 whitespace-nowrap cursor-pointer" title="Ver Detalle">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span wire:click="detalleCotizacion({{ $cot->id }})"
                                        class="cursor-pointer caret" title="Ver Detalle">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{$cot->numero}}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-900 text-center" title="">{{$cot->tipo}}</td>
                        <td class="text-gray-900 text-center" title="">{{\Carbon\Carbon::parse($cot->fecha_cotizacion)->format('d/m/Y')}}</td>
                        <td class="text-gray-900 text-center" title="">
                            @if ($cot->estatus == 'TRANSCRITA')
                                <span class="badge bg-info" style="border: 0px; border-radius: 5px; color: #ffffff;">{{$cot->estatus}}</span>
                            @elseif ($cot->estatus == 'COTIZACION ENVIADA')
                                <span class="badge bg-success" style="border: 0px; border-radius: 5px;">{{$cot->estatus}}</span>
                                <i class="fas fa-share"></i>
                            @elseif ($cot->estatus == 'OFERTAS RECIBIDAS')
                                <span class="badge bg-success" style="border: 0px; border-radius: 5px;">{{$cot->estatus}}</span>
                                <i class="fas fa-reply"></i>
                            @elseif ($cot->estatus == 'ANULADA')
                                <span class="badge bg-warning" style="border: 0px; border-radius: 5px; color: #000000;">{{$cot->estatus}}</span>
                            @elseif ($cot->estatus == 'RECHAZADA')
                                <span class="badge bg-secondary" style="border: 0px; border-radius: 5px; color: #000000;">{{$cot->estatus}}</span>
                            @endif
                        </td>

                        <x-table.td-dropdown estilo="tw" colortxt="" colorbg="">
                            <x-boton.boton-dropdown modo="link" href="cotizaciones/editar/{{ $cot->tipo }}/{{ $cot->id }}" icon="icon-note" text="Editar" />

                            <x-boton.boton-dropdown modo="link" href="detalle_cotizacion/{{ $cot->id }}" icon="icon-menu" text="Ver Detalle" />

                            <x-boton.boton-dropdown wire:click="$emit('abrir', ({{ $cot->id }}))" icon="icon-user" text="Ver Proveedores" />

                            @if ($cot->estatus == 'TRANSCRITA')
                                <x-boton.boton-dropdown wire:click="deleteConfirm({{ $cot->id }})" icon="icon-trash" text="Eliminar" />
                            @endif

                        </x-table.td-dropdown>
                    </tr>
                    @if ($detalle_descripcion == $cot->id)
                        <tr>
                            <x-table.td-detalle2 id="{{ $loop->index }}" colspan="7">
                                @if ($detalle_cotizacion)
                                    <ul>
                                        @foreach ($detalle_cotizacion as $detalle)
                                            <li>{{ $detalle }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $detalle_cotizacion }}
                                @endif
                            </x-table.td-detalle2>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td class="p-3 text-center" colspan="7">No hay registros</td>
                    </tr>
                @endforelse

            </tbody>
        </x-table.table>

        <div class="card-footer justify-center">
            {{ $cotizaciones->links() }}
        </div>
    </div>
</div>
