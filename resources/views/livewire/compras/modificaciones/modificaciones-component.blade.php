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

            <x-table.table-header :encabezados="['Nro. Solicitud', 'Fecha Solicitud', 'Nro. Compra', 'Status', 'Acciones']" />

            <tbody>
                @forelse ($modificaciones as $mod)

                    <tr>
                        <td wire:click="detalleModificacion({{ $mod->id }})" class="px-3 py-2 whitespace-nowrap cursor-pointer">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span wire:click="detalleModificacion({{ $mod->id }})"
                                        class="cursor-pointer caret">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{$mod->numero}}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-900 text-center" title="">{{$mod->fecha}}</td>
                        <td class="text-gray-900 text-center" title="">{{$mod->compra->numero}}</td>
                        <td class="text-gray-900 text-center" title="">{{$mod->estatus->descripcion}}</td>

                        <x-table.td-dropdown estilo="tw" colortxt="" colorbg="">
                            <x-boton.boton-dropdown modo="link" href="modificaciones/{{ $mod->id }}/edit" icon="icon-note" text="Editar" />

                            <x-boton.boton-dropdown modo="link" href="detalle_modificacion/{{ $mod->id }}" icon="icon-menu" text="Ver Detalle" />

                            <x-boton.boton-dropdown wire:click="deleteConfirm({{ $mod->id }})" icon="icon-trash" text="Eliminar" />

                            <x-boton.boton-dropdown wire:click="" icon="icon-printer" text="Imprimir" />

                        </x-table.td-dropdown>
                    </tr>
                    @if ($detalle_descripcion == $mod->numero)
                        <tr>
                            <x-table.td-detalle2 id="{{ $loop->index }}" colspan="7">
                                @if ($detalle_modificacion)
                                    <ul>
                                        @foreach ($detalle_modificacion as $detalle)
                                            <li>{{ $detalle }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $detalle_modificacion }}
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
            {{ $modificaciones->links() }}
        </div>
    </div>
</div>
