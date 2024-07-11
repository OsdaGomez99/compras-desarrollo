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
      <legend class="text-base">Informe General de Proveedor</legend>
      <div class="container">
        <div class="grid lg:grid-cols-1 sm:grid-cols-1 gap-4 mb-2">
            <span style="color:red">* Campo Requerido</span>
        </div>
        <div class="grid gap-4 grid-cols-5">
            <div class="col-span-2">
                <label class="input-required">Razón Social</label>
                <x-jet-input wire:model.defer="nombre" id="razon" class="block mt-1 w-full" type="text" name="razon" :value="old('razon')"/>
            </div>
            <div class="col-span-1" wire:ignore>
                <label class="input-required">Tipo de Persona</label>
                <select wire:model.defer="tipo_persona_seleccionada" name="tipo_persona_seleccionada" id="select_persona"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm" required onchange="showInp()">
                <option value="">Seleccione...</option>
                        @foreach ($personas as $persona)
                            <option wire:key="{{ $persona->id }}" value="{{ $persona->id }}"
                                {{ $persona->id == $tipo_persona_seleccionada ? 'selected' : '' }}>
                                {{ $persona->descripcion }} </option>
                        @endforeach
                </select>
                @error('personas')
                    <x-error> {{ $message }}</x-error>
                @enderror
            </div>
            <div class="" wire:ignore>
                <label id="label_empresa" class="input-required" style="display: none">Tipo de Empresa</label>
                <select wire:model.defer="tipo_empresa_seleccionada" name="tipo_empresa_seleccionada" id="select_empresa"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm" style="display: none">
                <option value="">Seleccione...</option>
                         @foreach ($empresas as $empresa)
                            <option wire:key="{{ $empresa->id }}" value="{{ $empresa->id }}"
                                {{ $empresa->id == $tipo_empresa_seleccionada ? 'selected' : '' }}>
                                {{ $empresa->abreviatura }} </option>
                        @endforeach
                </select>
                @error('empresas')
                    <x-error> {{ $message }}</x-error>
                @enderror
            </div>
            <div class="">
                <label class="input-required">R.I.F</label>
                <x-jet-input wire:model.defer="rif" id="rif" class="tblock mt-1 w-full" type="text" name="rif" :value="old('rif')" />
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 pt-4">
            <div class="">
                <label class="input-required">Teléfono</label>
                <x-jet-input wire:model.defer="telefono" id="telefono" class="tblock mt-1 w-full" type="text" name="telefono" :value="old('telefono')" />
            </div>
            <div class="">
                <x-jet-label value="Teléfono 2 (Opcional)" />
                <x-jet-input wire:model.defer="telefono_alt" id="telefono_alt" class="tblock mt-1 w-full" type="text" name="telefono_alt" :value="old('telefono_alt')" />
            </div>
            <div class="">
                <label class="input-required">Email</label>
                <x-jet-input wire:model.defer="email" id="email" class="tblock mt-1 w-full" type="text" name="email" :value="old('email')" />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4 pt-4">
                <div class="">
                    <x-jet-label value="Direccion*" />
                    <x-jet-input wire:model.defer="direccion" id="direccion" class="tblock mt-1 w-full" type="text" name="direccion" :value="old('direccion')" />
                </div>
              <div class="">
                  <x-jet-label value="Representante*" />
                  <x-jet-input wire:model.defer="representante" id="representante" class="tblock mt-1 w-full" type="text" name="representante" :value="old('representante')" />
              </div>
          </div>

          <div class="grid grid-cols-4 gap-4 pt-4">
                <div class="">
                    <x-jet-label value="Nro. RNC (Opcional)" />
                    <x-jet-input wire:model.defer="num_rnc" id="rnc" class="tblock mt-1 w-full" type="text" name="rnc" :value="old('rnc')" />
                </div>
              <div class="">
                  <x-jet-label value="Nro. ALSOBOCARONI (Opcional)" />
                  <x-jet-input wire:model.defer="nro_alsobocaroni" id="representante" class="tblock mt-1 w-full" type="text" name="representante" :value="old('representante')" />
              </div>

              <div class="">
                  <x-jet-label value="Cod. Grupo ALSOBOCARONI (Opc.)" />
                  <x-jet-input wire:model.defer="cod_grupo_alsobocaroni" id="rnc" class="tblock mt-1 w-full" type="text" name="rnc" :value="old('rnc')" />
              </div>

              <div class="">
                  <x-jet-label value="Nro. RUC ALSOBOCARONI (Opc.)" />
                  <x-jet-input wire:model.defer="ruc_alsobocaroni" id="" class="tblock mt-1 w-full" type="text" name="telefono_r" :value="old('telefono_r')" />
              </div>
          </div>

      </div>
      </fieldset>


    <div class="flex items-center justify-end mt-4">
        <a href="{{route('proveedores.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4" title= "Cancelar">Cancelar</a>
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

    function showInp() {
        getSelectValue = document.getElementById("select_persona").value;
        select_empresa_value = document.getElementById("select_empresa").value;
        if (getSelectValue == "2"){
            document.getElementById("select_empresa").style.display = "block";
            document.getElementById("select_empresa").setAttribute("required", "required");
            document.getElementById("select_empresa").value = "";
            @this.set('tipo_empresa_seleccionada', "");
            document.getElementById("label_empresa").style.display = "block";
            document.getElementById("label_empresa").setAttribute("required", "required");
        } else if (getSelectValue === "" || getSelectValue == "1") {
            document.getElementById("select_empresa").style.display = "none";
            select_empresa_value = "0";
            document.getElementById("label_empresa").style.display = "none";
        }
    }

    document.addEventListener('livewire:load', function() {

        $('#select_persona').on('change', function(e) {
            const data_persona = $('#select_persona').val();
            @this.set('tipo_persona_seleccionada', data_persona);
            console.log('esta es la data_persona ',data_persona);
            console.log(@this.get('tipo_persona_seleccionada'));
            if ($(this).val() == "2") {
                $('#select_empresa').prop('disabled', false);
            }
            else {
                $('#select_empresa').prop('disabled', true);
            }
        });

        $('#select_empresa').on('change', function(e) {
            const data_empresa = $('#select_empresa').val();
            @this.set('tipo_empresa_seleccionada', data_empresa);
            console.log('esta es la empresa ',data_empresa);
            console.log(@this.get('tipo_empresa_seleccionada'));
        });

        /* $('.select').selectize({
            highlight: true,
            placeholder: "Seleccione..."
        }); */

    });
</script>
@endpush
</div>
