<div>
    <x-boton.boton-agregar wire:click="crear" title="Agregar Rol" />
    @if($modal)
        @include('livewire.segurity.roles.modal-roles-create')
    @endif
    @if ($modal_adjuntar_permiso)
        @include('livewire.segurity.roles.modal-adjuntar-permiso')
    @endif
    @if ($modal_adjuntar_usuario)
        @include('livewire.segurity.roles.modal-adjuntar-usuario')
    @endif
</div>
