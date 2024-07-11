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
        <legend class="text-base">Informe General de la Solicitud</legend>
        <div class="container">

          <div class="grid grid-cols-3 gap-4">
              <div class="">
                  <x-jet-label for="num" value="Nro. Solicitud" />
                  <x-jet-input wire:model.defer="numero" id="numero_compra" class="block mt-1 w-full form-control-sm" type="text" name="numero_compra" :value="old('numero_compra')" />
              </div>

              <div class="">
                  <x-jet-label for="fecha_oc" value="Fecha Solicitud" />
                  <x-jet-input wire:model.defer="fecha" id="fecha_compra" class="block mt-1 w-full form-control-sm" type="date" name="fecha_oc" :value="old('fecha_oc')" />
              </div>

                <div class="">
                    <x-jet-label value="Status" />
                    <x-jet-input wire:model="id_status" id="id_status" class="block mt-1 w-full form-control-sm" type="text" name="id_status" :value="old('id_status')" disabled/>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-4">

              <div class="">
                  <x-jet-label for="num" value="Nro. Compra" />
                  <x-jet-input id="num_resolucion" class="block mt-1 w-full form-control-sm" type="text" name="num_resolucion" :value="old('num_resolucion')" />
              </div>

              <div class="">
                <fieldset class="border border-solid border-gray-300 p-2">
                <legend class="text-base m-0">Tipo de Solicitud</legend>
                    <div class="flex justify-center">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                        <x-jet-label for="si_boton" value="Modificacion"/>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                        <x-jet-label for="no_boton" value="Anulacion"/>
                      </div>
                    </div>
                </fieldset>
              </div>

            </div>

            <div class="grid grid-cols-1 gap-4 pt-4">
                <div class="">
                    <x-jet-label value="Justificación" />
                    <textarea wire:model.defer="justificacion" class="tblock w-full px-3 l-2 py-2 text-gray-700 border-gray-300 focus-visible:outline-none focus-visible:border-blue-600 focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="justificacion" cols="35" :value="old('justificacion')"></textarea>
                </div>
            </div>



        </div>
        </fieldset>


        <div class="flex items-center justify-end mt-4">
            <a href="{{route('modificaciones.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4" title= "Cancelar">Cancelar</a>
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
