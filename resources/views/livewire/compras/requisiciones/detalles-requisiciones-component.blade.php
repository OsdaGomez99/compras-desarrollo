<div>
@if ($requisicion->estatus == 'TRANSCRITA')
    @if (session('success'))
        <x-session-alert type="success">
            {{ session('success') }}
        </x-session-alert>
    @elseif (session('error'))
        <x-session-alert type="danger">
            {{ session('error') }}
        </x-session-alert>
    @endif

    @if ($requisicion->tipo == 'BIENES')
        <form method="POST" wire:submit.prevent="guardar">
        @csrf
            <fieldset class="border border-solid border-gray-300 p-3">
            <legend class="text-base">Agregar Detalle</legend>
            <div class="container">
                <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4 pt-4 panel">
                    <div class="" wire:ignore>
                        <select wire:model.defer="id_articulo" name="id_articulo" id="select_articulo"
                        class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value=""></option>
                                @foreach ($articulos as $articulo)
                                    <option wire:key="{{ $articulo->id }}" value="{{ $articulo->id }}"
                                    {{ $articulo->id == $id_articulo ? 'selected' : '' }}>
                                        {{ $articulo->descripcion }} - {{ $articulo->medida->descripcion }}</option>
                                @endforeach
                        </select>
                        @error('articulos')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                    </div>
                    <div>
                        <x-jet-input wire:model.defer="cantidad" id="cantidad" class="block mt-1 w-full form-control-sm" type="number" min="1" name="cantidad" :value="old('cantidad')" placeholder="Ingrese la cantidad"/>
                    </div>
                    <div>
                        <button class="btn btn-success" type="button" wire:click="guardar" id="guardar">
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                            Aceptar
                        </button>
                        <button class="btn btn-info" type="button" id="limpiar">
                            <span class="btn-label">
                                <i class="fa fa-broom"></i>
                            </span>
                            Limpiar
                        </button>
                    </div>
                </div>
            </div>
            </fieldset>
        </form>
    @else
    <form method="POST" wire:submit.prevent="guardar">
        @csrf
            <fieldset class="border border-solid border-gray-300 p-3">
            <legend class="text-base">Agregar Detalle</legend>
            <div class="container">
                <div class="grid lg:grid-cols-1 sm:grid-cols-1 gap-4 pt-4 panel">
                    <div class="">
                        <textarea wire:model.defer="descripcion" id="descripcion" class="tblock w-full px-3 l-2 py-2 text-gray-700 border-gray-300 focus-visible:outline-none focus-visible:border-blue-600 focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" cols="35" :value="old('descripcion')" maxlength="500" placeholder="Descripción del Servicio"></textarea>
                    </div>
                </div>
                <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4 pt-4 panel">
                    <div class="" wire:ignore>
                        <select wire:model.defer="id_unidad_medida" id="select_unidad"
                        class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Medida">
                        <option value=""></option>
                                @foreach ($unidades as $unidad)
                                    <option wire:key="{{ $unidad->id }}" value="{{ $unidad->id }}"
                                        {{ $unidad->id == $id_unidad_medida ? 'selected' : '' }}>
                                        {{ $unidad->descripcion }} - {{ $unidad->codigo }} </option>
                                @endforeach
                        </select>
                        @error('unidades')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                    </div>
                    <div>
                        <x-jet-input wire:model.defer="cantidad" id="cantidad" class="block mt-1 w-full form-control-sm" type="number" min="1" name="cantidad" :value="old('cantidad')" placeholder="Ingrese la cantidad"/>
                    </div>
                    <div>
                        <button class="btn btn-success" type="button" wire:click="guardar" id="guardar">
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                            Aceptar
                        </button>
                        <button class="btn btn-info" type="button" id="limpiar">
                            <span class="btn-label">
                                <i class="fa fa-broom"></i>
                            </span>
                            Limpiar
                        </button>
                    </div>
                </div>
            </div>
            </fieldset>
        </form>
    @endif
@endif

<div style="overflow:scroll;">
    <table class="table table-bordered table-head-bg-primary table-bordered-bd-primary mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                @if ($requisicion->tipo == 'BIENES')
                <th scope="col">Articulo</th>
                @else
                <th scope="col">Descripción</th>
                @endif
                <th scope="col">Linea</th>
                <th scope="col">U.M</th>
                <th scope="col">Cantidad</th>
                @if ($requisicion->estatus == 'TRANSCRITA')
                    <th scope="col">Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($detalles as $detalle)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    @if ($requisicion->tipo == 'BIENES')
                    <td>{{ $detalle->articulo->descripcion }}</td>
                    <td>{{ $detalle->articulo->linea->descripcion }}</td>
                    <td>{{ $detalle->articulo->medida->descripcion }}</td>
                    @else
                    <td>{{ $detalle->descripcion }}</td>
                    <td>{{ $detalle->requisicion->linea->descripcion }}</td>
                    <td>{{ $detalle->medida->descripcion }}</td>
                    @endif
                    @if ($edit_cantidad == true && $id_detalle == $detalle->id)
                        <td>
                            <x-jet-input wire:model.defer="cantidad2" id="cantidad2" class="block mt-1 w-full form-control-sm" type="number" min="1" name="cantidad2" :value="old('cantidad2')"/>
                        </td>
                    @else
                        <td>
                            <x-jet-input wire:model.defer="cantidad2" id="cantidad2" class="block mt-1 w-full form-control-sm" type="number" min="1" name="cantidad2" :value="old('cantidad2')" style="display: none"/>
                            {{ $detalle->cantidad}}
                        </td>
                    @endif
                    @if ($detalle->requisicion->estatus == 'TRANSCRITA')
                        <td>
                        @if ($edit_cantidad == true && $id_detalle == $detalle->id)
                            <button wire:click="guardarData({{ $detalle->id }})" class="btn btn-icon btn-round btn-success btn-sm cursor-pointer">
                                <i class="fas fa-check"></i>
                            </button>
                        @else
                            <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-2 panel">
                                    <button wire:click="edit({{ $detalle->id }})" class="btn btn-icon btn-round btn-info btn-sm cursor-pointer">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="deleteData({{ $detalle->id }})" class="btn btn-icon btn-round btn-danger btn-sm">
                                        <i class="fa fa-times"></i>
                                    </button>
                            </div>
                        @endif

                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td class="p-3 text-center" colspan="6">No hay detalles</td>
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

        $('#select_articulo').on('change', function(e) {
            const data_articulo = $('#select_articulo').val();
            @this.set('id_articulo', data_articulo);
            console.log('esta es la data_articulo ',data_articulo);
            console.log(@this.get('id_articulo'));
        });

        $('#select_unidad').on('change', function(e) {
            const data_unidad = $('#select_unidad').val();
            console.log('esta es la unidad ',data_unidad);
            @this.set('id_unidad_medida', data_unidad);
            console.log(@this.get('uid_unidad_medida'));
        });

        var $select = $('.select-multiple').selectize({
            highlight: true,
            placeholder: "Seleccione..."
        });

        $('#guardar').on("click", function(){
            var selectize = $select[0].selectize;
            selectize.clear();
            $('#cantidad').val('');
            @this.set('cantidad', '');
            $('#descripcion').val('');
            @this.set('descripcion', '');
        });

        $('#limpiar').on("click", function(){
            var selectize = $select[0].selectize;
            selectize.clear();
            $('#cantidad').val('');
            @this.set('cantidad', '');
            $('#descripcion').val('');
            @this.set('descripcion', '');
        });

    });

</script>

