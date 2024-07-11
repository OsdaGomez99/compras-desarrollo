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

            <x-table.table-header :colspan="[3]" :encabezados="['Nro. Cotización']" />

            <tbody>
                @forelse ($ofertas as $oferta)

                    <tr>
                        <td data-toggle="collapse" href="#ofertas" aria-expanded="false" class="p-3 text-center whitespace-nowrap cursor-pointer collapsed" colspan="3">
                                {{ $oferta->first()->cotizacion->numero }} - {{ $oferta->first()->cotizacion->tipo }}
                        </td>
                    </tr>
                        @foreach ($oferta as $item)
                            <tr id="ofertas">
                                <td class="p-3 text-center whitespace-nowrap cursor-pointer">
                                    PROVEEDOR: {{ $item->proveedor->nombre }}
                                </td>
                                <td class="text-gray-900 text-center" title="">
                                    @if ($item->estatus == 'TRANSCRITA')
                                        <span class="badge bg-info" style="border: 0px; border-radius: 5px; color: #ffffff;">{{$item->estatus}}</span>
                                    @elseif ($item->estatus == 'COTIZACION ENVIADA')
                                        <span class="badge bg-success" style="border: 0px; border-radius: 5px;">{{$item->estatus}}</span>
                                        <i class="fas fa-share"></i>
                                    @elseif ($item->estatus == 'OFERTAS RECIBIDAS')
                                        <span class="badge bg-success" style="border: 0px; border-radius: 5px;">{{$item->estatus}}</span>
                                        <i class="fas fa-reply"></i>
                                    @elseif ($item->estatus == 'ACEPTADA')
                                        <span class="badge bg-success" style="border: 0px; border-radius: 5px">{{$item->estatus}}</span>
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <x-table.td-dropdown estilo="tw" colortxt="" colorbg="">
                                    @if ($item->estatus == 'TRANSCRITA')
                                        <x-boton.boton-dropdown modo="link" href="ofertas/editar/{{ $item->tipo }}/{{ $item->id }}" icon="icon-note" text="Editar" />
                                        <x-boton.boton-dropdown wire:click="enviarConfirm({{ $item->id }})" icon="icon-paper-plane" text="Enviar Cotizacion" />
                                    @endif

                                    <x-boton.boton-dropdown modo="link" href="detalle_oferta/{{ $item->id }}" icon="icon-menu" text="Ver Detalle" />

                                    @if ($item->estatus == 'COTIZACION ENVIADA')
                                        <x-boton.boton-dropdown wire:click="recibidaConfirm({{ $item->id }})" icon="icon-envelope-letter" text="Marcar como recibida" />
                                    @endif

                                    @if ($item->estatus == 'OFERTAS RECIBIDAS')
                                        <x-boton.boton-dropdown wire:click="aceptarConfirm({{ $item->id }})" icon="icon-check" text="Aceptar" />
                                    @endif

                                    @if ($item->estatus == 'TRANSCRITA')
                                        <x-boton.boton-dropdown wire:click="deleteConfirm({{ $item->id }})" icon="icon-trash" text="Eliminar" />
                                    @endif

                                    <x-boton.boton-dropdown modo="link" href="{{ route('ofertas.imprimir', $item->id) }}" icon="icon-printer" text="Imprimir" />
                                </x-table.td-dropdown>
                            </tr>
                        @endforeach
                @empty
                    <tr>
                        <td class="p-3 text-center" colspan="7">No hay registros</td>
                    </tr>
                @endforelse

            </tbody>
        </x-table.table>
        <div class="card-footer justify-center">
            {{ $ofertas->links() }}
        </div>
    </div>
</div>
