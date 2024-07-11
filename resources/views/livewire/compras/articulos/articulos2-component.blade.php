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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Línea</th>
                                    <th>Unidad Medida</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Línea</th>
                                    <th>Unidad Medida</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
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
                                    <td>{{ $articulo->ultimo_precio }}</td>
                                    <td>{{ $articulo->linea->descripcion}}</td>
                                    <td>{{ $articulo->medida->codigo }}</td>
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#multi-filter-select').DataTable( {
            "pageLength": 5,
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select class="form-control"><option value="">Filtrar por:</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                            );

                        column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                    } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });
    });
</script>
