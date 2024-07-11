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

            <x-table.table-header :encabezados="['Nro. Requisición', 'Tipo', 'Fecha Requisición', 'Unidad Solicitante', 'Prioridad', 'Status', 'Acciones']"/>

            <tbody>
                @forelse ($requisiciones as $req)

                    <tr>
                        <td wire:click="detalleRequisicion({{ $req->id }})" class="px-3 py-2 whitespace-nowrap cursor-pointer" title="Ver Detalle">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span wire:click="detalleRequisicion({{ $req->id }})"
                                        class="cursor-pointer caret" title="Ver Detalle">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{$req->numero}}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-900 text-center" title="">{{$req->tipo}}</td>
                        <td class="text-gray-900 text-center" title="">{{\Carbon\Carbon::parse($req->fecha_requisicion)->format('d/m/Y')}}</td>
                        <td class="text-gray-900 text-center" title="">{{$req->unidad->nombre}}</td>
                        <td class="text-gray-900 text-center" title="">
                            @if ($req->prioridad->descripcion == 'NORMAL')
                                <span class="badge rounded-pill bg-success" style="border: 0px; color: #000000;">{{$req->prioridad->descripcion}}</span>
                            @elseif($req->prioridad->descripcion == 'URGENTE')
                                <span class="badge rounded-pill bg-danger" style="border: 0px; color: #000000;">{{$req->prioridad->descripcion}}</span>
                            @endif
                        </td>
                        <td class="text-gray-900 text-center" title="">
                            @if ($req->estatus == 'TRANSCRITA')
                                <span class="badge bg-info" style="border: 0px; border-radius: 5px; color: #ffffff;">{{$req->estatus}}</span>
                            @elseif ($req->estatus == 'APROBADA')
                                <span class="badge bg-success" style="border: 0px; border-radius: 5px;">{{$req->estatus}}</span>
                            @elseif ($req->estatus == 'ANULADA')
                                <span class="badge bg-warning" style="border: 0px; border-radius: 5px; color: #000000;">{{$req->estatus}}</span>
                            @elseif ($req->estatus == 'CERRADA')
                                <span class="badge bg-dark" style="border: 0px; border-radius: 5px; color: #ffffff;">{{$req->estatus}}</span>
                            @endif
                        </td>
                        <x-table.td-dropdown estilo="tw" colortxt="" colorbg="">
                            @if ($req->estatus == 'TRANSCRITA')
                                <x-boton.boton-dropdown modo="link" href="requisiciones/editar/{{ $req->tipo }}/{{ $req->id }}" icon="icon-note" text="Editar" />
                            @endif

                            <x-boton.boton-dropdown modo="link" href="detalle_requisicion/{{ $req->id }}" icon="icon-menu" text="Ver Detalle" />

                            @if ($req->estatus != 'ANULADA' && $req->estatus != 'CERRADA')
                                @if ($req->estatus != 'APROBADA')
                                    <x-boton.boton-dropdown wire:click="aprobarConfirm({{ $req->id }})" icon="icon-like" text="Aprobar" />
                                @endif
                                <x-boton.boton-dropdown wire:click="anularConfirm({{ $req->id }})" icon="icon-close" text="Anular" />
                            @endif

                            @if ($req->estatus != 'TRANSCRITA' && $req->estatus != 'ANULADA' && $req->estatus != 'CERRADA')
                                <x-boton.boton-dropdown wire:click="reversarConfirm({{ $req->id }})" icon="icon-action-undo" text="Reversar" />
                                <x-boton.boton-dropdown modo="link" href="{{ route('requisiciones.imprimir', $req->id) }}" icon="icon-printer" text="Imprimir" />
                            @endif

                            @if ($req->estatus == 'TRANSCRITA')
                                <x-boton.boton-dropdown wire:click="deleteConfirm({{ $req->id }})" icon="icon-trash" text="Eliminar" />
                            @endif

                        </x-table.td-dropdown>
                    </tr>
                    @if ($detalle_descripcion == $req->id)
                        <tr>
                            <x-table.td-detalle2 id="{{ $loop->index }}" colspan="7">
                                @if ($detalle_requisicion)
                                    <ul>
                                        @foreach ($detalle_requisicion as $detalle)
                                            <li>{{ $detalle }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $detalle_requisicion }}
                                @endif
                            </x-table.td-detalle2>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td class="p-3 text-center" colspan="8">No hay registros</td>
                    </tr>
                @endforelse

            </tbody>
        </x-table.table>

        <div class="card-footer justify-center">
            {{ $requisiciones->links() }}
        </div>
    </div>
</div>
