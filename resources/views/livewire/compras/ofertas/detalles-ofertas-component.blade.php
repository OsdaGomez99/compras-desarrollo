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

<div style="overflow:scroll;">
    <table class="table table-bordered table-head-bg-primary table-bordered-bd-primary mt-4" style="font-size: 14px">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Artículo</th>
                <th scope="col">Linea</th>
                <th scope="col">U.M</th>
                <th scope="col">Cantidad Cotizada</th>
                @if ($oferta->estatus == 'OFERTAS RECIBIDAS' || $oferta->estatus == 'ACEPTADA')
                <th scope="col">Cantidad Ofertada</th>
                <th scope="col">Precio</th>
                <th scope="col">Exento IVA</th>
                @if ($oferta->estatus == 'OFERTAS RECIBIDAS')
                <th scope="col">Acciones</th>
                @endif
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($detalles as $detalle)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $detalle->detalle_req->articulo->descripcion }}</td>
                    <td>{{ $detalle->detalle_req->articulo->linea->descripcion }}</td>
                    <td>{{ $detalle->detalle_req->articulo->medida->descripcion }}</td>
                    <td>{{ $detalle->cantidad_cotizada}}</td>
                    @if ($oferta->estatus == 'OFERTAS RECIBIDAS' || $oferta->estatus == 'ACEPTADA')
                        @if ($edit == true && $id_detalle == $detalle->id)
                            <td>
                                <x-jet-input wire:model.defer="cantidad_ofertada2" id="cantidad_ofertada2" class="block mt-1 w-full form-control-sm" type="number" min="0" name="cantidad_ofertada2" :value="old('cantidad_ofertada2')"/>
                            </td>
                            <td>
                                <x-jet-input wire:model.defer="precio2" id="precio2" class="block mt-1 w-full form-control-sm" type="number" min="0" name="precio2" :value="old('precio2')"/>
                            </td>
                            <td>
                                <x-jet-input wire:model.defer="exento_iva2" id="exento_iva2" class="block mt-1 w-full form-control-sm" type="checkbox" name="exento_iva2" :value="old('exento_iva2')"/>
                            </td>
                        @else
                            <td>
                                <x-jet-input wire:model.defer="cantidad_ofertada2" id="cantidad_ofertada2" class="block mt-1 w-full form-control-sm" type="number" min="0" name="cantidad_ofertada2" :value="old('cantidad_ofertada2')" style="display: none"/>
                                {{$detalle->cantidad_ofertada}}
                            </td>
                            <td>
                                <x-jet-input wire:model.defer="precio2" id="precio2" class="block mt-1 w-full form-control-sm" type="number" min="0" name="precio2" :value="old('precio2')" style="display: none"/>
                                {{number_format($detalle->precio, 2)}}
                            </td>
                            <td>
                                <x-jet-input wire:model.defer="exento_iva2" id="exento_iva2" class="block mt-1 w-full form-control-sm" type="checkbox" name="exento_iva2" :value="old('exento_iva2')" style="display: none"/>
                                @if ($detalle->exento_iva == false)
                                    <i class="fas fa-ban"></i>
                                @else
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                        @endif
                        @if ($oferta->estatus == 'OFERTAS RECIBIDAS')
                            @if ($edit == true && $id_detalle == $detalle->id)
                            <td>
                                <button wire:click="guardarData({{ $detalle->id }})" class="btn btn-icon btn-round btn-success btn-sm cursor-pointer">
                                    <i class="fas fa-check"></i>
                                </button>
                            </td>
                            @else
                            <td>
                                <button wire:click="edit({{ $detalle->id }})" class="btn btn-icon btn-round btn-info btn-sm cursor-pointer">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                            @endif
                        @endif
                    @endif
                </tr>
            @empty
                <tr>
                    <td class="p-3 text-center" colspan="7">No hay detalles</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>

    jQuery(function ($) {

        $('#select_articulo').on('change', function(e) {
            const data_articulo = $('#select_articulo').val();
            @this.set('id_articulo', data_articulo);
            console.log('esta es la data_articulo ',data_articulo);
            console.log(@this.get('id_articulo'));
        });

        var $select = $('.select-multiple').selectize({
            highlight: true,
            placeholder: "Articulo"
        });

        $('#guardar').on("click", function(){
            var selectize = $select[0].selectize;
            selectize.clear();
            $('#cantidad').val('');
            @this.set('cantidad', '');
        });

    });

</script>


