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

            <x-table.table-header :encabezados="['Nro. Compra', 'Tipo', 'Fecha Compra', 'Nro. Cotización', 'Status', 'Acciones']" />

            <tbody>
                @forelse ($compras as $com)

                    <tr>
                        <td wire:click="detalleCompra({{ $com->id }})" class="px-3 py-2 whitespace-nowrap cursor-pointer" title="Ver Detalle">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span wire:click="detalleCompra({{ $com->id }})"
                                        class="cursor-pointer caret" title="Ver Detalle">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{$com->numero}}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-900 text-center" title="">{{$com->tipo}}</td>
                        <td class="text-gray-900 text-center" title="">{{\Carbon\Carbon::parse($com->fecha_compra)->format('d/m/Y')}}</td>
                        <td class="text-gray-900 text-center" title="">{{$com->cotizacion->numero}}</td>
                        <td class="text-gray-900 text-center" title="">
                            @if ($com->estatus == 'TRANSCRITA')
                                <span class="badge bg-info" style="border: 0px; border-radius: 5px; color: #ffffff;">{{$com->estatus}}</span>
                            @elseif ($com->estatus == 'APROBADA COMPRAS')
                                <span class="badge bg-success" style="border: 0px; border-radius: 5px;">{{$com->estatus}}</span>
                            @elseif ($com->estatus == 'ANULADA')
                                <span class="badge bg-warning" style="border: 0px; border-radius: 5px; color: #000000;">{{$com->estatus}}</span>
                            @elseif ($com->estatus == 'CERRADA')
                                <span class="badge bg-dark" style="border: 0px; border-radius: 5px; color: #ffffff;">{{$com->estatus}}</span>
                            @endif
                        </td>

                        <x-table.td-dropdown estilo="tw" colortxt="" colorbg="">
                            <x-boton.boton-dropdown modo="link" href="compras/editar/{{ $com->tipo }}/{{ $com->id }}" icon="icon-note" text="Editar" />

                            <x-boton.boton-dropdown modo="link" href="detalle_compra/{{ $com->id }}" icon="icon-menu" text="Ver Detalle" />

                            <x-boton.boton-dropdown wire:click="aprobarConfirm({{ $com->id }})" icon="icon-like" text="Aprobar" />


                            @if ($com->estatus == 'TRANSCRITA')
                                <x-boton.boton-dropdown wire:click="deleteConfirm({{ $com->id }})" icon="icon-trash" text="Eliminar" />
                            @endif

                            <x-boton.boton-dropdown modo="link" href="{{ route('compras.imprimir', $com->id) }}" icon="icon-printer" text="Imprimir" />

                        </x-table.td-dropdown>
                    </tr>
                    @if ($detalle_descripcion == $com->numero)
                        <tr>
                            <x-table.td-detalle2 id="{{ $loop->index }}" colspan="7">
                                @if ($detalle_compra)
                                    <ul>
                                        @foreach ($detalle_compra as $detalle)
                                            <li>{{ $detalle }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $detalle_compra }}
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
            {{ $compras->links() }}
        </div>
    </div>
</div>
