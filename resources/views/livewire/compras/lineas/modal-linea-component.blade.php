<script>
    document.addEventListener('limpiaForm-linea', function() {
        $('.error').html('');
        $('#permiso').select().focus();
    });

    function check(e) {
        tecla = (document.all) ? e.keyCode : e.which;

        //Tecla de retroceso para borrar, siempre la permite
        if (tecla == 8) {
            return true;
        }

        // Patrón de entrada, en este caso solo acepta numeros y letras
        patron = /[A-Za-z0-9]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }

</script>
<div class="fixed z-10 inset-0 ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-middle bg-blue-50 rounded-lg text-left overflow-visible shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <h2 class="text-black fw-bold ml-3 mt-3"> Agregar Linea</h2>
            <hr class="my-1">
            <form>
                <div class="bg-blue-50 pt-4 px-6 pb-2">
                    <div class="mt-2">
                        <label for="descripcion" class="block font-semibold text-base text-black">Descripción</label>
                        <x-jet-input wire:model="descripcion" style="text-transform:uppercase;" id="descripcion" class="block mt-1 w-full" type="text" name="descripcion" :value="old('descripcion')" required />
                        @error('descripcion')
                            <x-error> {{ $message }}</x-error>
                        @enderror
                    </div>
                    <div class="px-4 py-3 sm:px-6 sm:flex justify-center space-x-4">
                        <x-boton.boton-aceptar wire:click="guardar()">Guardar</x-boton.boton-aceptar>
                        <x-boton.boton-cancelar wire:click="cerrarModal()">Cancelar</x-boton.boton-cancelar>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
