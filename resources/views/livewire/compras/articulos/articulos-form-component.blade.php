<div>
@if (session('exito'))
    <div class="alert alert-success">
        {{ session('exito') }}
    </div>
@endif

<x-jet-validation-errors class="mt-4 mx-4 mb-2" />

<form method="POST" class="px-4 pb-4 pt-2" wire:submit.prevent="guardar">

    @csrf

  <!-- Informe General de Proveedor-->
    <fieldset class="mt-4 border border-solid border-gray-300 p-3">
    <legend class="text-base">Descripcion General del Artículo</legend>
    <div class="container">
        <div class="grid lg:grid-cols-1 sm:grid-cols-1 gap-4 mb-2">
            <span style="color:red">* Campo Requerido</span>
        </div>
        <div class="grid gap-4 grid-cols-3">
            <div class="">
                <label class="input-required">Descripción</label>
                <x-jet-input wire:model.defer="descripcion" id="desc" class="block mt-1 w-full" style="text-transform:uppercase;" type="text" name="descripcion" :value="old('descripcion')" />
            </div>
            <div class="" wire:ignore>
                <label class="input-required">Linea</label>
                <select wire:model.defer="linea_seleccionada" name="linea_seleccionada" id="select_linea"
                class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <option value=""></option>
                        @foreach ($lineas as $linea)
                            <option wire:key="{{ $linea->id }}" value="{{ $linea->id }}"
                                {{ $linea->id == $linea_seleccionada ? 'selected' : '' }}>
                                {{ $linea->descripcion }} </option>
                        @endforeach
                </select>
                @error('lineas')
                    <x-error> {{ $message }}</x-error>
                @enderror
            </div>
            <div class="" wire:ignore>
                <label class="input-required">Unidad de Medida</label>
                <select wire:model.defer="unidad_seleccionada" name="unidad_seleccionada" id="select_unidad"
                class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <option value=""></option>
                        @foreach ($unidades as $unidad)
                            <option wire:key="{{ $unidad->id }}" value="{{ $unidad->id }}"
                                {{ $unidad->id == $unidad_seleccionada ? 'selected' : '' }}>
                                {{ $unidad->descripcion }} </option>
                        @endforeach
                </select>
                @error('unidades')
                    <x-error> {{ $message }}</x-error>
                @enderror
            </div>
        </div>

        <div class="grid gap-4 grid-cols-4 pt-4">
            <div class="">
                <x-jet-label value="Cod. CCCE (Opcional)" />
                <x-jet-input wire:model.defer="cod_art_ccce" id="telefono" class="tblock mt-1 w-full" type="text" name="cod_art_ccce" :value="old('cod_art_ccce')" />
            </div>
            <div class="">
                <x-jet-label value="Cod. OCEPRE (Opcional)" />
                <x-jet-input wire:model.defer="cod_ocepre" id="telefono" class="tblock mt-1 w-full" type="text" name="cod_ocepre" :value="old('cod_ocepre')" />
            </div>
            <div class="">
                <x-jet-label  value="Cod. CNU (Opcional)" />
                <x-jet-input wire:model.defer="cod_cnu" id="telefono" class="tblock mt-1 w-full" type="text" name="cod_cnu" :value="old('cod_cnu')" />
            </div>
            <div class="">
                <x-jet-label value="Precio (Opcional)" />
                <x-jet-input wire:model.defer="ultimo_precio" id="precio" class="tblock mt-1 w-full" type="number" min="0" name="ultimo_precio" :value="old('ultimo_precio')" />
            </div>
        </div>

    </div>
    </fieldset>


    <div class="flex items-center justify-end mt-4">
        <a href="{{route('articulos.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4" title= "Cancelar">Cancelar</a>
        <x-jet-button type="button" class="ml-4" wire:click="guardar">
            @if ($mode_edit)
                Actualizar
            @else
                Registrar
            @endif
        </x-jet-button>
    </div>

</form>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {

        $('#select_linea').on('change', function(e) {
            const data_linea = $('#select_linea').val();
            @this.set('linea_seleccionada', data_linea);
            console.log('esta es la data_linea ',data_linea);
            console.log(@this.get('linea_seleccionada'));
        });

        $('#select_unidad').on('change', function(e) {
            const data_unidad = $('#select_unidad').val();
            console.log('esta es la unidad ',data_unidad);
            @this.set('unidad_seleccionada', data_unidad);
            console.log(@this.get('unidad_seleccionada'));
        });

        $('.select-multiple').selectize({
            highlight: true,
            placeholder: "Seleccione..."
        });
    });
</script>
@endpush
</div>
