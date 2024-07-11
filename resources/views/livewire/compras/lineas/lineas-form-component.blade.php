<div>
    <x-boton.boton-agregar-tipo title="Agregar Linea" />
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item cursor-pointer" wire:click="create('BIENES')">Linea de Suministro</a>
        <a class="dropdown-item cursor-pointer" wire:click="create('SERVICIOS')">Linea de Servicio</a>
    </div>
    @if($modal)
        @include('livewire.compras.lineas.modal-linea-component')
    @endif
</div>
