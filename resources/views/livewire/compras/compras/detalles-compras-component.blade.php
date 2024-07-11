<div>
    <x-jet-label value="Proveedor" />
    <div class="container">
        <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4 pt-4 panel">
            @if ($compra->proveedor != null)
                <div class="">
                    <x-jet-input wire:model="proveedor" class="block mt-1 w-full form-control-sm" type="text" :value="old('id_proveedor')" disabled/>
                </div>
            @else
                <div class="" wire:ignore>
                    <select wire:model="id_oferta" name="id_oferta" id="select_oferta"
                    class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm" disable>
                        <option value=""></option>
                            @foreach ($ofertas as $oferta)
                                <option wire:key="{{ $oferta->id }}" value="{{ $oferta->id }}"
                                {{ $oferta->id == $id_oferta ? 'selected' : '' }}>
                                    {{ $oferta->proveedor->nombre }}</option>
                            @endforeach
                    </select>
                    @error('ofertas')
                        <x-error> {{ $message }}</x-error>
                    @enderror
                </div>
                @if ($id_oferta != null)
                    <div>
                        <button class="btn btn-success" type="button" wire:click="guardar" id="guardar">
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                            Aceptar
                        </button>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <div style="overflow:scroll;">
        <table class="table table-bordered table-head-bg-primary table-bordered-bd-primary mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Artículo</th>
                    <th scope="col">Linea</th>
                    <th scope="col">U.M</th>
                    <th scope="col">Cant.</th>
                    <th scope="col">Precio Unitario</th>
                    <th scope="col">Importe</th>
                    <th scope="col">Exento IVA</th>
                    <th scope="col">Centro Costo</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($detalles as $detalle)
                    @if ($compra->proveedor != null)
                        <tr style="height:10px;">
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $detalle->detalle_of->detalle_req->articulo->descripcion }}</td>
                            <td>{{ $detalle->detalle_of->detalle_req->articulo->linea->descripcion }}</td>
                            <td>{{ $detalle->detalle_of->detalle_req->articulo->medida->codigo }}</td>
                            <td>{{ $detalle->detalle_of->cantidad_ofertada}}</td>
                            <td>{{ number_format($detalle->detalle_of->precio, 2) }}</td>
                            <td>{{ number_format($detalle->detalle_of->cantidad_ofertada * $detalle->detalle_of->precio, 2) }}</td>
                            <td>
                                @if ($detalle->exento_iva == false)
                                    <i class="fas fa-ban"></i>
                                @else
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td>{{ $detalle->id_centro_costo }}</td>
                        </tr>
                        @else
                        <tr style="height:10px;">
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $detalle->detalle_req->articulo->descripcion }}</td>
                            <td>{{ $detalle->detalle_req->articulo->linea->descripcion }}</td>
                            <td>{{ $detalle->detalle_req->articulo->medida->codigo }}</td>
                            <td>{{ $detalle->cantidad_ofertada }}</td>
                            <td>{{ number_format($detalle->precio, 2) }}</td>
                            <td>{{ number_format($detalle->cantidad_ofertada * $detalle->precio, 2) }}</td>
                            <td>
                                @if ($detalle->exento_iva == false)
                                    <i class="fas fa-ban"></i>
                                @else
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td>
                                <div class="" wire:ignore>
                                    <select wire:model="id_centro_costo" name="id_centro_costo" id="select_centro"
                                        class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm" disable>
                                            <option value=""></option>
                                                @foreach ($centros as $centro)
                                                    <option wire:key="{{ $centro->id }}" value="{{ $centro->id }}"
                                                    {{ $centro->id == $id_centro_costo ? 'selected' : '' }}>
                                                        {{ $centro->codificacion }}</option>
                                                @endforeach
                                        </select>
                                    @error('centros')
                                        <x-error> {{ $message }}</x-error>
                                    @enderror
                                </div>
                            </td>
                        </tr>
                        @endif
                @empty
                    <tr>
                        <td class="p-3 text-center" colspan="9">No hay detalles</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <table class="table table-bordered table-head-bg-primary table-bordered-bd-primary mt-4">
            <tr>
                <td class="text-right">
                    SUB-TOTAL Bs. <br>
                    I.V.A(16,0)% Bs. <br>
                    TOTAL COMPRAS Bs.
                </td>
                <td class="text-right">
                @if ($compra->proveedor != null)
                    {{ number_format($compra->subtotal, 2) }} <br>
                    {{ number_format($iva, 2) }} <br>
                    {{ number_format($compra->total, 2) }}
                @else
                    {{ number_format($subtotal, 2) }} <br>
                    {{ number_format($iva, 2) }} <br>
                    {{ number_format($total, 2) }}
                @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
    jQuery(function ($) {

        $('#select_oferta').on('change', function(e) {
            const data_oferta = $('#select_oferta').val();
            @this.set('id_oferta', data_oferta);
            console.log('esta es la data_oferta ',data_oferta);
            console.log(@this.get('id_oferta'));
        });

        $('#select_centro').on('change', function(e) {
            const data_centro = $('#select_centro').val();
            @this.set('id_centro_costo', data_centro);
            console.log('esta es la data_centro ',data_centro);
            console.log(@this.get('id_centro_costo'));
        });

        var $select = $('.select-multiple').selectize({
            highlight: true,
            placeholder: "Seleccione un proveedor..."
        });

        $('#guardar').on("click", function(){
            var selectize = $select[0].selectize;
            selectize.clear();
            $('#descripcion').val('');
            @this.set('descripcion', '');
        });

        $('#limpiar').on("click", function(){
            var selectize = $select[0].selectize;
            selectize.clear();
            $('#descripcion').val('');
            @this.set('descripcion', '');
        });

    });
</script>
