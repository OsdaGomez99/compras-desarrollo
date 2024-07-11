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
    <legend class="text-base">Informe General de la Cotización</legend>
        <div class="container">
            <div class="grid lg:grid-cols-1 sm:grid-cols-1 gap-4 mb-2">
                <span style="color:red">* Campo Requerido</span>
            </div>
            <div class="grid lg:grid-cols-4 sm:grid-cols-1 gap-4">
                <div class="">
                    <label class="input-required">Nro. Cotización</label>
                    <x-jet-input wire:model.defer="numero" id="numero" class="block mt-1 w-full form-control-sm" type="text" name="numero" :value="old('numero')" disabled/>
                </div>
                <div class="">
                    <label class="input-required">Fecha Cotización</label>
                    <x-jet-input wire:model="fecha_cotizacion" id="fecha_cotizacion" class="block mt-1 w-full form-control-sm" type="date" name="fecha_cotizacion" max="{{ $fecha_actual }}" />
                </div>
                <div class="">
                    <label class="input-required">Fecha de Vigencia</label>
                    <x-jet-input wire:model.defer="fecha_vigencia" id="fecha_vigencia" class="block mt-1 w-full form-control-sm" type="date" name="fecha_vigencia" :value="old('fecha_vigencia')"/>
                </div>
                @if ($mode_edit)
                    <div class="">
                        <x-jet-label for="status" value="Status" />
                        <x-jet-input wire:model="estatus" id="estatus" class="block mt-1 w-full form-control-sm" type="text" name="estatus" :value="old('estatus')" disabled/>
                    </div>
                @endif
            </div>
        </div>
    </fieldset>
@if ($tipo == 'SERVICIOS')
    <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4 mb-2">
        <div>
            <fieldset class="mt-4 border border-solid border-gray-300 p-3">
            <legend class="text-base">Fecha y Hora tope para entregar Ofertas</legend>
                <div class="container">
                    <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4">
                        <div class="">
                            <label>Fecha Tope</label>
                            <x-jet-input wire:model.defer="fecha_tope" id="fecha_tope" class="block mt-1 w-full form-control-sm" type="date" name="fecha_tope" :value="old('fecha_tope')"/>
                        </div>
                        <div class="">
                            <label>Hora Tope</label>
                            <x-jet-input wire:model="hora_tope" id="hora_tope" class="block mt-1 w-full form-control-sm" type="time" name="hora_tope" :value="old('hora_tope')" />
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div>
            <fieldset class="mt-4 border border-solid border-gray-300 p-3">
            <legend class="text-base">Visita Técnica</legend>
                <div class="container">
                    <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4">
                        <div class="">
                            <label>Fecha Visita</label>
                            <x-jet-input wire:model.defer="fecha_visita" id="fecha_visita" class="block mt-1 w-full form-control-sm" type="date" name="fecha_visita" :value="old('fecha_visita')"/>
                        </div>
                        <div class="">
                            <label>Hora Visita</label>
                            <x-jet-input wire:model="hora_visita" id="hora_visita" class="block mt-1 w-full form-control-sm" type="time" name="hora_visita" :value="old('hora_visita')" />
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-1 sm:grid-cols-1 gap-4">
                        <div class="">
                            <label>Lugar Visita</label>
                            <x-jet-input wire:model="lugar_visita" id="lugar_visita" class="block mt-1 w-full form-control-sm" type="text" name="lugar_visita" :value="old('lugar_visita')" />
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
@endif


    <div class="flex items-center justify-end mt-4">
        <a href="{{route('cotizaciones.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4" title= "Cancelar">Cancelar</a>
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

</script>
