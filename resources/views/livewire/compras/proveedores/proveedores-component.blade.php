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

            <x-table.table-header :encabezados="['Nombre', 'Representante', 'Teléfono', 'Email', 'Acciones']" />

            <tbody>
                @forelse ($proveedores as $proveedor)
                    <tr>
                        <td wire:click="detalleProveedor({{ $proveedor->id }})" class="px-3 py-2 whitespace-nowrap cursor-pointer" title="Ver Detalle">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span wire:click="detalleProveedor({{ $proveedor->id }})"
                                        class="cursor-pointer caret" title="Ver Detalle">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{$proveedor->nombre}}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-900 text-center" title="">{{$proveedor->representante}}</td>
                        <td class="text-gray-900 text-center" title="">{{$proveedor->telefono}}</td>
                        <td class="text-gray-900 text-center" title="">{{$proveedor->email}}</td>
                        <x-table.td-dropdown estilo="tw" colortxt="" colorbg="">
                            <x-boton.boton-dropdown modo="link" href="/proveedores/{{ $proveedor->id }}/edit" icon="icon-note" text="Editar" />

                            <x-boton.boton-dropdown wire:click="changeConfirm({{ $proveedor->id }})" icon="icon-trash" text="Eliminar" />

                        </x-table.td-dropdown>
                    </tr>
                    @if ($detalle_nombre == $proveedor->nombre)
                        <tr>
                            <x-table.td-detalle2 id="{{ $loop->index }}" colspan="6">
                                @if ($detalle_proveedor)
                                    <ul>
                                        @foreach ($detalle_proveedor as $detalle)
                                            <li>{{ $detalle }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $detalle_proveedor }}
                                @endif
                            </x-table.td-detalle2>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td class="p-3 text-center" colspan="7">[-] No hay registros.</td>
                    </tr>
                @endforelse
            </tbody>
        </x-table.table>
        <div class="card-footer justify-center">
            {{ $proveedores->links() }}
        </div>
    </div>
</div>
