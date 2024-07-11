<script>
    document.addEventListener('limpiaForm', function() {
        $('.error').html('');
        $('#select_usuario').select().focus();
    });
</script>
<div class="fixed z-10 inset-0 ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <h2 class="text-black fw-bold ml-3 mt-3">Adjuntar Usuarios</h2>
            <hr class="my-1">
            <form>
                <div class="bg-white sm:p-6 sm:pb-4">
                    <div class="mt-1 mb-2" wire:ignore>
                        <label for="roles" class="block font-medium text-sm text-gray-700">Usuarios adjuntos:</label>
                        <select name="roles_seleccionados[]" id="select_usuario"
                            class="select-multiple block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            multiple>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ in_array($usuario->name, $usuarios_seleccionados) ? 'selected' : '' }}> {{ $usuario->name }} </option>
                            @endforeach
                        </select>
                        @error('roles')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="px-4 py-3 sm:px-6 sm:flex justify-center space-x-4">
                        <x-boton.boton-aceptar wire:click="actualizarAdjuntarUsuario()" >Guardar</x-boton.boton-aceptar>
                        <x-boton.boton-cancelar wire:click="cerrarModalAdjuntarUsuario()">Cancelar</x-boton.boton-cancelar>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $('.select-multiple').on('change', function(e) {
            let data = $('#select_usuario').selectize().val();
            @this.set('usuarios_seleccionados', data);
        });
        $('.select-multiple').selectize({
            plugins: ["remove_button"],
            highlight: true
        });
    </script>

</div>
