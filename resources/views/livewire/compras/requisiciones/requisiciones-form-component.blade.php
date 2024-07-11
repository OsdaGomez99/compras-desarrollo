<div>

@if (session('exito'))
    <div class="alert alert-success">
        {{ session('exito') }}
    </div>
@endif

<x-jet-validation-errors class="mt-4 mx-4 mb-2" />

<form method="POST" wire:submit.prevent="guardar">
    @csrf
            <fieldset class="mt-4 border border-solid border-gray-300 p-3">
            <legend class="text-base">Informe General de la Requisición</legend>

            <div class="container">
                <div class="grid lg:grid-cols-1 sm:grid-cols-1 gap-4 mb-2">
                    <span style="color:red">* Campo Requerido</span>
                </div>
                <div class="grid lg:grid-cols-4 sm:grid-cols-1 gap-4">
                    <div class="">
                        <label class="input-required">Nro. Requisición</label>
                        <x-jet-input wire:model.defer="numero" id="numero" class="block mt-1 w-full form-control-sm" type="text" name="numero" :value="old('numero')" disabled/>
                    </div>
                    <div class="">
                        <label class="input-required">Fecha Requisición</label>
                        <x-jet-input wire:model="fecha_requisicion" id="fecha_requisicion" class="block mt-1 w-full form-control-sm" type="date" name="fecha_requisicion" max="{{ $fecha_actual }}"/>
                    </div>
                    @if ($tipo == 'SERVICIOS')
                    <div class="">
                        <label class="input-required">Trimestre</label>
                        <x-jet-input wire:model.defer="trimestre" id="trimestre" class="block mt-1 w-full form-control-sm" type="number" min="1" name="trimestre" :value="old('trimestre')" disabled/>
                    </div>
                    @endif
                    @if ($mode_edit)
                    <div class="">
                        <x-jet-label value="Status" />
                        <x-jet-input wire:model="estatus" id="estatus" class="block mt-1 w-full form-control-sm" type="text" name="estatus" :value="old('estatus')" disabled/>
                    </div>
                    @endif
                </div>
                <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4 pt-4">
                    <div class="" wire:ignore>
                        <label class="input-required">Unidad Solicitante</label>
                        <select wire:model.defer="id_solicitante" name="id_solicitante" id="select_solicitante"
                        class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                        <option value=""></option>
                                @foreach ($solicitantes as $solicitante)
                                    <option wire:key="{{ $solicitante->id }}" value="{{ $solicitante->id }}"
                                    {{ $solicitante->id == $id_solicitante ? 'selected' : '' }}>
                                        {{ $solicitante->nombre }} </option>
                                @endforeach
                        </select>
                        @error('solicitantes')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                    </div>
                    <div class="" wire:ignore>
                            <label class="input-required">Linea</label>
                            <select wire:model.defer="id_linea" name="id_linea" id="select_linea"
                            class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value=""></option>
                                    @foreach ($lineas as $linea)
                                        <option wire:key="{{ $linea->id }}" value="{{ $linea->id }}"
                                        {{ $linea->id == $id_linea ? 'selected' : '' }}>
                                            {{ $linea->descripcion }} </option>
                                    @endforeach
                            </select>
                            @error('lineas')
                                <x-error> {{ $message }}</x-error>
                            @enderror
                    </div>
                </div>

                    <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4 pt-4">

                        <div class="" wire:ignore>
                            <label class="input-required">Año Presupuesto</label>
                            <select wire:model.defer="id_anno" name="id_anno" id="select_anno"
                            class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                            <option value=""></option>
                                    @foreach ($annos as $anno)
                                        <option wire:key="{{ $anno->id }}" value="{{ $anno->id }}"
                                        {{ $solicitante->id == $id_anno ? 'selected' : '' }}>
                                            {{ $anno->anno }} </option>
                                    @endforeach
                            </select>
                            @error('annos')
                                <x-error> {{ $message }}</x-error>
                            @enderror
                        </div>
                        <div class="">
                            <label class="input-required">Prioridad</label>
                            <fieldset class="border border-solid border-gray-300 px-2 py-2">
                            <div class="flex justify-center">
                                <div class="form-check form-check-inline">
                                    <input wire:model.defer="id_prioridad" class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1">
                                    <x-jet-label value="Normal"/>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input wire:model.defer="id_prioridad" class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
                                    <x-jet-label value="Urgente"/>
                                </div>
                            </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 pt-4">
                        <div class="">
                            <x-jet-label value="Justificación (Opcional)" />
                            <textarea wire:model.defer="justificacion" class="tblock w-full px-3 l-2 py-2 text-gray-700 border-gray-300 focus-visible:outline-none focus-visible:border-blue-600 focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="justificacion" cols="35" :value="old('justificacion')" maxlength="500"></textarea>
                        </div>
                    </div>
            </div>
            </fieldset>

    <div class="flex items-center justify-end mt-4">
        <a href="{{route('requisiciones.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4" title= "Cancelar">Cancelar</a>
        <x-jet-button type="button" class="ml-4" wire:click="guardar">
            @if ($mode_edit)
                Actualizar
            @else
                Registrar
            @endif
        </x-jet-button>
    </div>
</form>
</div>


<script>

    jQuery(function ($) {

        $('#select_solicitante').on('change', function(e) {
            const data_solicitante = $('#select_solicitante').val();
            @this.set('id_solicitante', data_solicitante);
            console.log('esta es la data_gasto ',data_solicitante);
            console.log(@this.get('id_solicitante'));
        });

        $('#select_linea').on('change', function(e) {
            const data_linea = $('#select_linea').val();
            @this.set('id_linea', data_linea);
            console.log('esta es la data_linea ', data_linea);
            console.log(@this.get('id_linea'));
        });

        $('#select_anno').on('change', function(e) {
            const data_anno = $('#select_anno').val();
            @this.set('id_anno', data_anno);
            console.log('esta es la data_anno ', data_anno);
            console.log(@this.get('id_anno'));
        });

        $('.select-multiple').selectize({
            highlight: true,
            placeholder: "Seleccione..."
        });

    });

</script>
