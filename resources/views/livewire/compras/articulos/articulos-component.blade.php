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

            <x-table.table-header :encabezados="['Descripción', 'Línea', 'Unidad de Medida', 'Acciones']" :width="[1]" />

            <tbody>
                @forelse ($articulos as $articulo)

                    <tr>
                        <td wire:click="detalleArticulo({{ $articulo->id }})" class="px-3 py-2 whitespace-nowrap cursor-pointer" title="Ver Detalle">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span wire:click="detalleArticulo({{ $articulo->id }})"
                                        class="cursor-pointer caret" title="Ver Detalle">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{$articulo->descripcion}}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-900 text-center" title="">{{ $articulo->linea->descripcion}}</td>
                        <td class="text-gray-900 text-center" title="">{{ $articulo->medida->codigo }}</td>
                        <x-table.td-dropdown estilo="tw" colortxt="" colorbg="">
                            <x-boton.boton-dropdown modo="link" href="/articulos/{{ $articulo->id }}/edit" icon="icon-note" text="Editar" />

                            <x-boton.boton-dropdown wire:click="changeConfirm({{ $articulo->id }})" icon="icon-trash" text="Eliminar" />

                        </x-table.td-dropdown>
                    </tr>
                    @if ($detalle_descripcion == $articulo->descripcion)
                        <tr>
                            <x-table.td-detalle2 id="{{ $loop->index }}" colspan="6">
                                @if ($detalle_articulo)
                                    <ul>
                                        @foreach ($detalle_articulo as $detalle)
                                            <li>{{ $detalle }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $detalle_articulo }}
                                @endif
                            </x-table.td-detalle2>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td class="p-3 text-center" colspan="6">No hay registros</td>
                    </tr>
                @endforelse

            </tbody>
        </x-table.table>
        {{$articulos->links()}}
    </div>
</div>
