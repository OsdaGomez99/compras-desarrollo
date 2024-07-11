<div>
    <x-boton.boton-agregar wire:click="crear" title="Agregar Permiso" />
    @if($modal)
        @include('livewire.segurity.permisos.modal-permisos-crear')
    @endif
    @if ($modal_adjuntar_rol)
        @include('livewire.segurity.permisos.modal-adjuntar-rol')
    @endif
    @if ($modal_adjuntar_usuario)
        @include('livewire.segurity.permisos.modal-adjuntar-usuario')
    @endif
</div>
