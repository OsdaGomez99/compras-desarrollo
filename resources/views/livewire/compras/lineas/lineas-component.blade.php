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

    <div class="card-body">
            <x-table.table class="table-fixed">

            <x-table.table-header :encabezados="['Descripción', 'Tipo', 'Acciones']" />

                <tbody>
                    @forelse ($lineas as $linea)
                        <tr>
                            <td class="text-gray-900 text-center"> {{ $linea->descripcion }} </td>
                            <td class="text-gray-900 text-center"> {{ $linea->tipo }} </td>

                            <x-table.td-action>
                                <x-boton.boton-action class="icon-note" title="Editar"
                                    wire:click="$emit('editLinea',({{ $linea->id }}))">
                                </x-boton.boton-action>
                                <x-boton.boton-action class="icon-trash" title="Eliminar"
                                    wire:click="changeConfirm({{ $linea->id }})">
                                </x-boton.boton-action>
                            </x-table.td-action>
                        </tr>
                    @empty
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td class="p-3 text-center">[-] No hay registros.</td>
                        </tr>
                    </table>
                    @endforelse
                </tbody>

            </x-table.table>

            <div class="card-footer justify-center">
                {{ $lineas->links() }}
            </div>
    </div>
</div>
