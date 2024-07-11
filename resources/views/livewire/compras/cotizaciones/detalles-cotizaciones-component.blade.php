<div>
    <div>
        <x-jet-validation-errors class="mt-4 mx-4 mb-2" />
        <fieldset class="mt-4 border border-solid border-gray-300 p-3">
        <legend class="text-base">Agregar Detalle</legend>
        <div class="container">
            <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4 pt-4 panel">
                <div class="" wire:ignore>
                    <select wire:model="id_requisicion" name="id_requisicion" id="select_requisicion"
                    class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="-1">Seleccione la requisicion...</option>
                            @foreach ($requisiciones as $requisicion)
                                <option wire:key="{{ $requisicion->id }}" value="{{ $requisicion->id }}"
                                    {{ $requisicion->id == $id_requisicion ? 'selected' : '' }}>
                                    {{ $requisicion->numero }} - {{ $requisicion->linea->descripcion }}</option>
                            @endforeach
                    </select>
                    @error('requisiciones')
                        <x-error> {{ $message }}</x-error>
                    @enderror
                </div>
                @if ($id_requisicion != -1)
                <div class="">
                    <button class="btn btn-success" type="button" wire:click="guardar" id="guardar">
                        <span class="btn-label">
                            <i class="fa fa-check"></i>
                        </span>
                        Aceptar
                    </button>
                </div>
            </div>
            <div class="grid lg:grid-cols-1 sm:grid-cols-1 gap-4 pt-4 panel">
                <div style="overflow:scroll">
                    <table class="table table-bordered table-head-bg-primary table-bordered-bd-info">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                @if ($cotizacion->tipo == 'BIENES')
                                <th scope="col">Artículo</th>
                                @else
                                <th scope="col">Descripción</th>
                                @endif
                                <th scope="col">Linea</th>
                                <th scope="col">U.M</th>
                                <th scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detalles as $key => $detalle)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    @if ($cotizacion->tipo == 'BIENES')
                                    <td>{{ $detalle->articulo->descripcion }}</td>
                                    <td>{{ $detalle->articulo->linea->descripcion }}</td>
                                    <td>{{ $detalle->articulo->medida->descripcion }}</td>
                                    @else
                                    <td>{{ $detalle->descripcion }}</td>
                                    <td>{{ $detalle->requisicion->linea->descripcion }}</td>
                                    <td>{{ $detalle->medida->descripcion }}</td>
                                    @endif
                                    <td>{{ $detalle->cantidad }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                @endif
            </div>
        </fieldset>
    </div>

    <div style="overflow:scroll;">
        <table class="table table-bordered table-head-bg-primary table-bordered-bd-info mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    @if ($cotizacion->tipo == 'BIENES')
                    <th scope="col">Artículo</th>
                    @else
                    <th scope="col">Descripción</th>
                    @endif
                    <th scope="col">Linea</th>
                    <th scope="col">U.M</th>
                    <th scope="col">Cantidad Cotizada</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detalles_cot as $detalles)
                    <tr>
                        <td data-toggle="collapse" href="#ofertas" aria-expanded="false" class="p-3 text-center whitespace-nowrap collapsed" colspan="5">
                            Req. Nro. {{ $detalles->first()->detalle_req->requisicion->numero }} - {{ $detalles->first()->detalle_req->requisicion->linea->descripcion }}
                            @if ($detalles->first()->cotizacion->estatus == "TRANSCRITA")
                                <button wire:click="eliminar({{ $detalles->first()->id }})" type="button" data-toggle="tooltip" title="Eliminar requisición" class="btn btn-link btn-danger cursor-pointer" data-original-title="Remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            @endif

                        </td>
                    </tr>
                    @foreach ($detalles as $detalle)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            @if ($cotizacion->tipo == 'BIENES')
                            <td>{{ $detalle->detalle_req->articulo->descripcion }}</td>
                            <td>{{ $detalle->detalle_req->articulo->linea->descripcion }}</td>
                            <td>{{ $detalle->detalle_req->articulo->medida->descripcion }}</td>
                            @else
                            <td>{{ $detalle->detalle_req->descripcion }}</td>
                            <td>{{ $detalle->detalle_req->requisicion->linea->descripcion }}</td>
                            <td>{{ $detalle->detalle_req->medida->descripcion }}</td>
                            @endif
                            <td>{{ $detalle->cantidad }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td class="p-3 text-center" colspan="7">No hay detalles</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>

  /*   document.addEventListener('livewire:load', function() {



    }) */
    jQuery(function ($) {

        $('#select_requisicion').on('change', function(e) {
            @this.set('id_requisicion', $('#select_requisicion').val());
            console.log('esta es la data_requisicion ',data_requisicion);
            console.log(@this.get('id_requisicion'));
        });

        var $select = $('.select-multiple').selectize({
            highlight: true,
            placeholder: "Seleccione la requisicion..."
        });

        $('#guardar').on("click", function(){
            var selectize = $select[0].selectize;
            selectize.clear();
        });

    });

</script>
