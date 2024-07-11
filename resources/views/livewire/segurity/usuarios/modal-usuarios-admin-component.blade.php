<div>
    <x-boton.boton-agregar link='/admin/usuarios/create' title="Agregar Usuario" />
    @if ($modal_adjuntar_rol)
        @include('livewire.segurity.usuarios.modal-adjuntar-rol')
    @endif
    @if ($modal_adjuntar_permiso)
        @include('livewire.segurity.usuarios.modal-adjuntar-permiso')
    @endif
</div>
