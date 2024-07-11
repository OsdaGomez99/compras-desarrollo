<?php

namespace App\Http\Livewire\Segurity\Roles;

use Livewire\Component;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;

class ModalRolesComponent extends Component
{
    public $id_rol, $rol, $descripcion, $nombre_rol;
    public $modal = false;
    public $modal_adjuntar_permiso = false;
    public $modal_adjuntar_usuario = false;
    public $permisos;
    public $permisos_seleccionados = [];
    public $usuarios;
    public $usuarios_seleccionados = [];

    protected $rules = [
        'rol' => 'required|unique:App\Models\Permission,name',
        'nombre_rol' => 'required',
        'descripcion' => 'required',
    ];

    protected $listeners = [
        'adjuntarPermiso' => 'abrirModalAdjuntarPermiso',
        'actualizar' => '$refresh',
        'editRol' => 'editar',
        'adjuntarUsuario' => 'abrirModalAdjuntarUsuario'
    ];

    public function render()
    {
        $this->fill([
            'usuarios' => User::all(['id', 'name'])->sortBy('name'),
            'permisos' => Permission::all(['id', 'name', 'display_name'])
        ]);
        return view('livewire.segurity.roles.modal-roles-component');
    }

    public function crear()
    {
        $this->id_rol = -1;
        $this->limpiarCampos();
        $this->abrirModal();
    }

    public function limpiarCampos()
    {
        $this->fill([
            'rol' => '',
            'descripcion' => '',
            'nombre_rol' => '',
            'permisos_seleccionados' => []
        ]);
    }

    public function abrirModal()
    {
        $this->modal = true;
        $this->dispatchBrowserEvent('limpiaForm');
        $this->emit('rol:limpiarDetalle');
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function guardar()
    {

        if ($this->rol == -1) {
            $this->validate();
        } else { // Si es edicion no verificar que el campo de permiso sea unico
            $this->validate([
                'rol' => 'required',
                'nombre_rol' => 'required',
                'descripcion' => 'required',
            ]);
        }

        $mensajes = ($this->id_rol == -1 ? '[+] Rol Ingresado Correctamente.' : '[*] Rol Modificado Correctamente.');

        $rol = Role::updateOrCreate(
            ['id' => $this->id_rol],
            [
                'name' => $this->rol,
                'display_name' => $this->nombre_rol,
                'description' => $this->descripcion
            ]
        );

        $rol->permissions()->sync(Permission::whereIn('name', $this->permisos_seleccionados)->pluck('id'));

        $rol->users()->sync($this->usuarios_seleccionados);

        $this->emit('rol:actualizar', 'success', $mensajes);

        $this->cerrarModal();
    }

    public function abrirModalAdjuntarPermiso($id)
    {
        $this->modal_adjuntar_permiso = true;
        $this->emitSelf('actualizar');
        $this->dispatchBrowserEvent('limpiaForm');
        $this->emit('rol:limpiarDetalle');

        $rol = Role::findOrFail($id);
        $this->fill([
            'id_rol' => $rol->id,
            'permisos_seleccionados' => $rol->permissions()->pluck('name')->toArray()
        ]);
    }

    public function abrirModalAdjuntarUsuario($id)
    {
        $this->modal_adjuntar_usuario = true;
        $this->emitSelf('actualizar');
        $this->dispatchBrowserEvent('limpiaForm');
        $this->emit('rol:limpiarDetalle');

        $rol = Role::findOrFail($id);
        $this->fill([
            'id_rol' => $rol->id,
            'usuarios_seleccionados' => $rol->users()->pluck('name')->toArray()
        ]);
    }

    public function editar($id)
    {
        $rol = Role::findOrFail($id);
        $this->fill([
            'id_rol' => $id,
            'rol' => $rol->name,
            'nombre_rol' => $rol->display_name,
            'descripcion' => $rol->description,
            'permisos_seleccionados' => $rol->permissions()->pluck('name')->toArray(),
            'usuarios_seleccionados' => $rol->users()->pluck('name')->toArray()
        ]);
        $this->abrirModal();
        $this->emit('rol:limpiarDetalle');
    }

    public function actualizarAdjuntarPermiso()
    {
        $rol = Role::find($this->id_rol);
        $rol->permissions()->sync(Permission::whereIn('name', $this->permisos_seleccionados)->pluck('id'));
        $this->emit('rol:actualizar', 'success', '[*] Registro Actualizado Correctamente.');
        $this->cerrarModalAdjuntarPermiso();
    }

    public function cerrarModalAdjuntarPermiso()
    {
        $this->limpiarCampos();
        $this->modal_adjuntar_permiso = false;
    }

    public function actualizarAdjuntarUsuario()
    {
        $rol = Role::find($this->id_rol);
        $rol->users()->sync($this->usuarios_seleccionados);
        $this->emit('rol:actualizar', 'success', '[*] Registro Actualizado Correctamente.');
        $this->cerrarModalAdjuntarUsuario();
    }

    public function cerrarModalAdjuntarUsuario()
    {
        $this->limpiarCampos();
        $this->modal_adjuntar_usuario = false;
    }
}
