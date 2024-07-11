                </div>
                    <div class="px-4 py-3 sm:px-6 sm:flex justify-center space-x-4">
                        <span class="flex w-full rounded-md shadow-sm sm:w-auto">
                            <x-boton.boton-aceptar  wire:click="actualizarAuth({{ $id_caja }})">Guardar</x-boton>
                        </span>
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <x-boton.boton-cancelar wire:click="cerrarModalAuth()">Cancelar</x-boton>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
