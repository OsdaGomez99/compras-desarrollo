<script>
    document.addEventListener('limpiaForm', function() {
        $('.error').html('');
        $('#permiso').select().focus();
    });
</script>
<div class="fixed z-10 inset-0 ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-middle bg-blue-50 rounded-lg text-left overflow-visible shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <h2 class="text-black fw-bold ml-3 mt-3">{{ $id_permiso == -1 ? 'Ingresar Permiso' : 'Editar Permiso'  }}</h2>
            <hr class="my-1">
            <form>
                <div class="bg-blue-50 pt-4 px-6 pb-2">
                    <div>
                        <label for="permiso" class="block font-semibold text-base text-black">Permiso</label>
                        <x-jet-input id="permiso" class="block mt-1 w-full" type="text" name="permiso"
                            :value="old('permiso')" wire:model.defer="permiso" autofocus required />
                        <small class="mt-1">* Formato del permiso es => modulo:accion </small>
                        @error('permiso')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="nombre" class="block font-semibold text-base text-black">Nombre del permiso</label>
                        <x-jet-input wire:model.defer="nombre_permiso" id="nombre" class="block mt-1 w-full" type="text"
                            name="nombre" :value="old('nombre')" required />
                        @error('nombre_permiso')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="descripcion" class="block font-semibold text-base text-black">Descripcion del
                            permiso:</label>
                        <x-jet-input wire:model.defer="descripcion" id="descripcion" class="block mt-1 w-full"
                            type="text" name="descripcion" :value="old('descripcion')" required />
                        @error('descripcion')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                    </div>
                    <div class="mt-2" wire:ignore>
                        <label for="roles" class="block font-semibold text-base text-blac">Roles adjuntos:</label>
                        <select name="roles_seleccionados[]" id="select_rol"
                            class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            multiple>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->name }}" {{ isset($roles_seleccionados) ? in_array($rol->name, $roles_seleccionados) ? 'selected' : '' : '' }}> {{ $rol->display_name }} </option>
                                @endforeach
                        </select>
                        @error('roles')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                    </div>
                    <div class="mt-2" wire:ignore>
                        <label for="roles" class="block font-semibold text-base text-blac">Usuarios:</label>
                        <select name="usuarios_seleccionados[]" id="select_user"
                            class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            multiple>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ in_array($usuario->name, $usuarios_seleccionados) ? 'selected' : '' }}> {{ $usuario->name }} </option>
                            @endforeach
                        </select>
                        @error('roles')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                    </div>
                    <div class="px-4 py-3 sm:px-6 sm:flex justify-center space-x-4">
                        <x-boton.boton-aceptar wire:click="guardar">Guardar</x-boton.boton-aceptar>
                        <x-boton.boton-cancelar wire:click="cerrarModal()">Cancelar</x-boton.boton-cancelar>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $('.select-multiple').on('change', function(e) {
            const data_rol = $('#select_rol').selectize().val();
            const data_user = $('#select_user').selectize().val();
            @this.set('roles_seleccionados', data_rol);
            @this.set('usuarios_seleccionados', data_user)
        });
        $('.select-multiple').selectize({
            plugins: ["remove_button"],
            highlight: true
        });
    </script>

</div>
