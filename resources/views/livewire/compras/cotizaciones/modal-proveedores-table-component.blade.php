<div>
    <div>
        <div class="fixed z-10 inset-0 ease-out duration-400" style="overflow-y:auto;">
            <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                <div class="inline-block align-middle bg-blue-50 rounded-lg text-left overflow-visible shadow-xl transform transition-all sm:my-24 sm:align-middle sm:max-w-2xl sm:w-full"
                    role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <h2 class="text-black fw-bold ml-3 mt-3">Proveedores a ofertar (Cot N° {{ $cotizacion->numero }}) ({{$cotizacion->tipo}})</h2>
                    <hr class="my-1">
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


                        <x-jet-validation-errors class="mt-4 mx-4 mb-2" />

                        <form method="POST" class="p-4" wire:submit.prevent="guardar">
                        @csrf
                            <fieldset class="border border-solid border-gray-300 p-3">
                            <legend class="text-base">Agregar proveedor</legend>
                            <div class="container">
                                <div class="grid grid-cols-2 gap-4 panel">
                                    <div class="" wire:ignore>
                                        <select wire:model.defer="id_proveedor" name="id_proveedor" id="select_proveedor"
                                        class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        <option value=""></option>
                                                @foreach ($proveedores as $proveedor)
                                                    <option wire:key="{{ $proveedor->id }}" value="{{ $proveedor->id }}"
                                                    {{ $proveedor->id == $id_proveedor ? 'selected' : '' }}>
                                                        {{ $proveedor->nombre }} </option>
                                                @endforeach
                                        </select>
                                        @error('proveedores')
                                            <x-error> {{ $message }}</x-error>
                                        @enderror
                                    </div>
                                    <div>
                                        <button class="btn btn-success" type="button" wire:click="guardar" id="guardar">
                                            <span class="btn-label">
                                                <i class="fa fa-check"></i>
                                            </span>
                                            Aceptar
                                        </button>
                                    </div>

                                    <div>
                                        <button class="btn btn-info" type="button" wire:click="enviarDataTodos" id="enviarDataTodos">
                                            <span class="btn-label">
                                            </span>
                                            Enviar Cotizacion a Todos
                                        </button>
                                    </div>

                                </div>
                            </div>
                            </fieldset>
                        </form>
                    </div>
                        <table class="table table-bordered table-head-bg-primary table-bordered-bd-primary p-4">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ofertas as $oferta)
                                    <tr>
                                        <td>
                                            @if($oferta->estatus  == 'COTIZACION ENVIADA')
                                                <button type="button" class="btn btn-icon btn-round btn-success btn-sm">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td>{{ $oferta->proveedor->nombre }}</td>
                                        <td>
                                            @if($oferta->estatus  == 'COTIZACION ENVIADA')
                                                <span class="badge bg-success" style="border: 0px; border-radius: 5px; color: white;">COTIZACIÓN ENVIADA</span>
                                            @else
                                                <a href="ofertas/editar/{{ $oferta->tipo }}/{{ $oferta->id }}" class="btn btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button wire:click="deleteData({{ $oferta->id }})" class="btn btn-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <button wire:click="enviarConfirm({{ $oferta->id }})" class="btn btn-success">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="px-4 py-3 sm:px-6 sm:flex justify-center space-x-4">
                            <x-boton.boton-cancelar wire:click="cerrarModal()">Regresar</x-boton.boton-cancelar>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>

    <script>

        jQuery(function ($) {

            $('#select_proveedor').on('change', function(e) {
                const data_proveedor = $('#select_proveedor').val();
                @this.set('id_proveedor', data_proveedor);
                console.log('esta es la data_proveedor ',data_proveedor);
                console.log(@this.get('id_proveedor'));
            });

            var $select = $('.select-multiple').selectize({
                highlight: true,
                placeholder: "Proveedor"
            });

            $('#guardar').on("click", function(){
                var selectize = $select[0].selectize;
                selectize.clear();
            });

        });

    </script>
