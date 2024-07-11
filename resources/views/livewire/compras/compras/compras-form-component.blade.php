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
    <legend class="text-base">Informe General de la Orden de Compra</legend>
    <div class="container">
        <div class="grid lg:grid-cols-1 sm:grid-cols-1 gap-4 mb-2">
            <span style="color:red">* Campo Requerido</span>
        </div>

      <div class="grid lg:grid-cols-5 sm:grid-cols-1 gap-4">
          <div class="">
              <label class="input-required">Nro. Compra</label>
              <x-jet-input wire:model.defer="numero" class="block mt-1 w-full form-control-sm" type="text" name="numero" :value="old('numero')" />
          </div>

          <div class="">
              <label class="input-required">Fecha Compra</label>
              <x-jet-input wire:model="fecha_compra" id="fecha_compra" class="block mt-1 w-full form-control-sm" type="date" name="fecha_compra" :value="old('fecha_compra')" max="{{ $fecha_actual }}"/>
          </div>

          <div class="">
                <x-jet-label for="fecha" value="Fecha Entrega Prov." />
                <x-jet-input wire:model="fecha_entrega_oc" id="fecha_entrega" class="block mt-1 w-full form-control-sm" type="date" name="fecha_entrega" :value="old('fecha_entrega_oc')" />
            </div>

            <div class="">
                <x-jet-label for="fecha_r" value="Fecha Entrega Mat." />
                <x-jet-input wire:model="fecha_entrega_mat" id="fecha_mat" class="block mt-1 w-full form-control-sm" type="date" name="fecha_mat" :value="old('fecha_entrega_mat')" />
            </div>

          @if ($mode_edit)
          <div class="">
              <x-jet-label value="Status" />
              <x-jet-input wire:model="estatus" id="estatus" class="block mt-1 w-full form-control-sm" type="text" name="estatus" :value="old('estatus')" disabled/>
            </div>
          @endif
      </div>

      <fieldset class="mt-4 border border-solid border-gray-300 p-3">
        <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4">
            <div class="" wire:ignore>
              <label class="input-required">Nro. Cotización</label>
                    <select wire:model="id_cotizacion" name="id_cotizacion" id="select_cotizacion"
                    class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value=""></option>
                            @foreach ($cotizaciones as $cotizacion)
                                <option wire:key="{{ $cotizacion->id }}" value="{{ $cotizacion->id }}"
                                {{ $cotizacion->id == $id_cotizacion ? 'selected' : '' }}>
                                    {{ $cotizacion->numero }}</option>
                            @endforeach
                    </select>
                    @error('cotizaciones')
                        <x-error> {{ $message }}</x-error>
                    @enderror
                    <br>
                    <label class="block font-medium text-gray-700"> </label>
            </div>
            <div class="">
              <x-jet-label for="num" value="Nro. Resolución" />
              <x-jet-input wire:model="num_resolucion_cu" id="num_resolucion_cu" class="block mt-1 w-full form-control-sm" type="text" name="num_resolucion" :value="old('num_resolucion_cu')" />
          </div>

          <div class="">
              <x-jet-label for="fecha_r" value="Fecha Resolución" />
              <x-jet-input wire:model="fecha_resolucion_cu" id="fecha_resolucion_cu" class="block mt-1 w-full form-control-sm" type="date" name="echa_resolucion" :value="old('fecha_resolucion_cu')" />
          </div>
        </div>
        @if ($tipo == 'SERVICIOS')
        <div class="grid lg:grid-cols-5 sm:grid-cols-5 gap-4">
            <div>
                <x-jet-label value="Fianza de Anticipo" />
                <div class="flex justify-center">
                    <div class="form-check form-check-inline">
                        <input wire:model.defer="fianza_anticipo" class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="fianza_anticipo" id="fianza_anticipo1" value="true">
                        <x-jet-label value="Si"/>
                    </div>
                    <div class="form-check form-check-inline">
                        <input wire:model.defer="fianza_anticipo" class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="fianza_anticipo" id="fianza_anticipo2" value="false">
                        <x-jet-label value="No"/>
                    </div>
                </div>
            </div>
            <div>
                <x-jet-label value="Fianza de Cump." />
                <div class="flex justify-center">
                    <div class="form-check form-check-inline">
                        <input wire:model.defer="fianza_fiel_comp" class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="fianza_fiel_comp" id="fianza_fiel_comp1" value="true">
                        <x-jet-label value="Si"/>
                    </div>
                    <div class="form-check form-check-inline">
                        <input wire:model.defer="fianza_fiel_comp" class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="fianza_fiel_comp" id="fianza_fiel_comp2" value="false">
                        <x-jet-label value="No"/>
                    </div>
                </div>
            </div>
            <div>
                <x-jet-label value="Lapso de Ejecución" />
                <x-jet-input wire:model="numero_ejecucion" class="block mt-1 w-full form-control-sm" type="number" min="0" :value="old('numero_ejecucion')" />
            </div>
            <div>
                <x-jet-label value="Tiempo de Ejecución" />
                <select wire:model="tiempo_ejecucion" class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">Seleccione...</option>
                    <option value="DIAS">DIAS</option>
                    <option value="MESES">MESES</option>
                </select>
            </div>
            <div>
                <x-jet-label value="% Anticipo" />
                <x-jet-input wire:model="porc_anticipo" class="block mt-1 w-full form-control-sm" type="number" min="0" :value="old('porc_anticipo')" />
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 gap-4">
          <div class="">
            <x-jet-label for="desc" value="Descripción" />
            <textarea wire:model="nota1" class="tblock w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="desc" cols="35" maxlength="200" :value="old('nota1')"></textarea>
          </div>
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4">
            <div class="">
                <div class="" wire:ignore>
                    <label class="input-required">Forma de Pago</label>
                            <select wire:model="id_forma_pago" name="id_forma_pago" id="select_forma_pago"
                        class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value=""></option>
                                @foreach ($formas_pago as $fp)
                                    <option wire:key="{{ $fp->id }}" value="{{ $fp->id }}"
                                    {{ $fp->id == $id_forma_pago ? 'selected' : '' }}>
                                        {{ $fp->descripcion }}</option>
                                @endforeach
                        </select>
                        @error('formas_pago')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                </div>
                <div class="" wire:ignore>
                    <label class="input-required">Punto de Envío</label>
                        <select wire:model="id_punto_envio" name="id_punto_envio" id="select_punto_envio"
                        class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value=""></option>
                                @foreach ($puntos_envio as $pe)
                                    <option wire:key="{{ $pe->id }}" value="{{ $pe->id }}"
                                    {{ $pe->id == $id_punto_envio ? 'selected' : '' }}>
                                        {{ $pe->descripcion }}</option>
                                @endforeach
                        </select>
                        @error('puntos_envio')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                </div>

                <div class="" wire:ignore>
                    <label class="input-required">Adjudicado por:</label>
                        <select wire:model="id_adjudicante" name="id_adjudicante" id="select_adjudicante"
                        class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value=""></option>
                                @foreach ($adjudicantes as $a)
                                    <option wire:key="{{ $a->id }}" value="{{ $a->id }}"
                                    {{ $a->id == $id_adjudicante ? 'selected' : '' }}>
                                        {{ $a->nombre }}</option>
                                @endforeach
                        </select>
                        @error('adjudicantes')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                </div>
            </div>
            <div class="col-span-2">
                <div class="">
                    <x-jet-label for="observ" value="Observaciones" />
                    <textarea wire:model="nota2" class="tblock w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="observ" maxlength="200" :value="old('nota2')"></textarea>
                </div>
                <div class="">
                    <x-jet-label value="¿Sujeto a Rendición?" />
                    <fieldset class="border border-solid border-gray-300 px-2 py-2">
                        <div class="flex justify-center">
                            <div class="form-check form-check-inline">
                                <input wire:model.defer="req_rendicion" class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="req_rendicion" id="req_rendicion1" value="true">
                                <x-jet-label value="Si"/>
                            </div>
                            <div class="form-check form-check-inline">
                                <input wire:model.defer="req_rendicion" class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="req_rendicion" id="req_rendicion2" value="false">
                                <x-jet-label value="No"/>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-4 sm:grid-cols-1 gap-4">
            <div class="" wire:ignore>
                <x-jet-label for="num" value="Tipo de Procedimiento" />
                    <select wire:model="id_tipo_adjudicacion" name="id_tipo_adjudicacion" id="select_tipo_adjudicacion"
                    class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value=""></option>
                            @foreach ($adjudicaciones as $ta)
                                <option wire:key="{{ $ta->id }}" value="{{ $ta->id }}"
                                {{ $ta->id == $id_tipo_adjudicacion ? 'selected' : '' }}>
                                    {{ $ta->descripcion }}</option>
                            @endforeach
                    </select>
                    @error('adjudicaciones')
                        <x-error> {{ $message }}</x-error>
                    @enderror
            </div>
            <div class="">
                <x-jet-label for="num" value="Nro. Procedimiento" />
                <x-jet-input wire:model="num_procedimiento" class="block mt-1 w-full form-control-sm" type="text" name="num_proc" :value="old('num_procedimiento')" />
            </div>
        </div>

      </fieldset>

    </div>
    </fieldset>


    <div class="flex items-center justify-end mt-4">
        <a href="{{route('compras.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4" title= "Cancelar">Cancelar</a>
        <x-jet-button type="button" class="ml-4" wire:click="guardar">
            @if ($mode_edit)
                Actualizar
            @else
                Registrar
            @endif
        </x-jet-button>
    </div>

</form>

<script>

    jQuery(function ($) {

        $('#select_cotizacion').on('change', function(e) {
            const data_cotizacion = $('#select_cotizacion').val();
            @this.set('id_cotizacion', data_cotizacion);
            console.log('esta es la data_cotizacion ',data_cotizacion);
            console.log(@this.get('id_cotizacion'));
        });

        $('#select_oferta').on('change', function(e) {
            const data_oferta = $('#select_oferta').val();
            @this.set('id_oferta', data_oferta);
            console.log('esta es la data_oferta ',data_oferta);
            console.log(@this.get('id_oferta'));
        });

        $('#select_forma_pago').on('change', function(e) {
            const data_forma_pago = $('#select_forma_pago').val();
            @this.set('id_forma_pago', data_forma_pago);
            console.log('esta es la data_forma_pago ',data_forma_pago);
            console.log(@this.get('id_forma_pago'));
        });

        $('#select_punto_envio').on('change', function(e) {
            const data_punto_envio = $('#select_punto_envio').val();
            @this.set('id_punto_envio', data_punto_envio);
            console.log('esta es la data_punto_envio ',data_punto_envio);
            console.log(@this.get('id_punto_envio'));
        });

        $('#select_tipo_adjudicacion').on('change', function(e) {
            const data_tipo_adjudicacion = $('#select_tipo_adjudicacion').val();
            @this.set('id_tipo_adjudicacion', data_tipo_adjudicacion);
            console.log('esta es la data_tipo_adjudicacion ',data_tipo_adjudicacion);
            console.log(@this.get('id_tipo_adjudicacion'));
        });

        $('#select_adjudicante').on('change', function(e) {
            const data_adjudicante = $('#select_adjudicante').val();
            @this.set('id_adjudicante', data_adjudicante);
            console.log('esta es la data_adjudicante ',data_adjudicante);
            console.log(@this.get('id_adjudicante'));
        });

        var $select = $('.select-multiple').selectize({
            highlight: true,
            placeholder: "Seleccione..."
        });


        /* $('#guardar').on("click", function(){
            var selectize = $select[0].selectize;
            selectize.clear();
        }); */

    });

</script>

</div>
