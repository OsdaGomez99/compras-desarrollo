<div>

@if (session('exito'))
    <div class="alert alert-success">
        {{ session('exito') }}
    </div>
@endif

<x-jet-validation-errors class="mt-4 mx-4 mb-2"/>

<form method="POST" wire:submit.prevent="guardar">

    @csrf

  <fieldset class="mt-4 border border-solid border-gray-300 p-3">
    <legend class="text-base">Información General de la Oferta</legend>
    <div class="container">
        <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4 pt-4">
            <div class="">
                <x-jet-label for="num" value="Nro. Cotización" />
                <x-jet-input wire:model.defer="id_cotizacion" id="num_cot" class="block mt-1 w-full form-control-sm" type="text" name="num_cot" :value="old('id_cotizacion')" />
            </div>
            <div class="">
                <x-jet-label for="ls" value="Proveedor" />
                <x-jet-input wire:model.defer="id_proveedor" id="detalle_prov" class="block mt-1 w-full form-control-sm" type="text" name="detalle_prov" :value="old('id_proveedor')" />
            </div>
            <div class="">
                <x-jet-label value="Status" />
                <x-jet-input wire:model="estatus" id="estatus" class="block mt-1 w-full form-control-sm" type="text" name="estatus" :value="old('estatus')" disabled/>
            </div>
        </div>

        @if ($tipo == 'SERVICIOS')
            <div class="grid lg:grid-cols-4 sm:grid-cols-1 gap-4 pt-4">
        @else
            <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4 pt-4">
        @endif
            @if ($tipo == 'SERVICIOS')
                <div class="">
                    <x-jet-label for="fecha" value="Fecha de Entrega" />
                    <x-jet-input wire:model.defer="fecha_entrega" id="fecha_en" class="block mt-1 w-full form-control-sm" type="date" name="fecha_en" :value="old('fecha_entrega')" />
                </div>
                <div class="">
                    <x-jet-label for="fecha" value="Fecha Recepción" />
                    <x-jet-input wire:model.defer="fecha_recepcion" id="fecha_rec" class="block mt-1 w-full form-control-sm" type="date" name="fecha_rec" :value="old('fecha_recepcion')" />
                </div>
            @endif
                <div class="">
                    <x-jet-label for="fecha" value="Fecha de Oferta" />
                    <x-jet-input wire:model.defer="fecha_oferta" id="fecha_o" class="block mt-1 w-full form-control-sm" type="date" name="fecha_o" :value="old('fecha_oferta')" />
                </div>
                <div class="">
                    <x-jet-label for="fecha" value="Fecha Vencimiento" />
                    <x-jet-input wire:model.defer="fecha_vigencia" id="fecha_ven" class="block mt-1 w-full form-control-sm" type="date" name="fecha_ven" :value="old('fecha_vigencia')" />
                </div>
            @if ($tipo == 'BIENES')
                <div class="">
                    <x-jet-label for="cond" value="%V.A.N" />
                    <x-jet-input wire:model.defer="van" id="van" class="tblock mt-1 w-full col-3" type="number" min="0" name="van" :value="old('van')" />
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-4 pt-4">
            <div class="">
                <x-jet-label for="cond" value="Condiciones de Venta" />
                <textarea wire:model.defer="condiciones_venta" class="tblock w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="cond_venta" cols="65" :value="old('condiciones_venta')"></textarea>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4 pt-4">
            @if ($tipo == 'SERVICIOS')
            <div class="">
                <x-jet-label for="cond" value="%Descuento" />
                <x-jet-input wire:model.defer="descuento" id="desc" class="tblock mt-1 w-full col-3" type="text" name="desc" :value="old('descuento')" />
            </div>
            <div class="">
                <x-jet-label for="cond" value="%V.A.N" />
                <x-jet-input wire:model.defer="van" id="van" class="tblock mt-1 w-full col-3" type="text" name="van" :value="old('van')" />
            </div>
            @endif
        </div>



    </div><!-- Fin de container -->
    </fieldset>
    <div class="flex items-center justify-end mt-4">
        <a href="{{route('ofertas.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4" title= "Cancelar">Cancelar</a>
        <x-jet-button type="button" class="ml-4" wire:click="guardar">
            Actualizar
        </x-jet-button>
    </div>

</form>
</div>
