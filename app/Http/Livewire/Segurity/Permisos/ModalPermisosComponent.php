<?php

namespace App\Http\Livewire\Segurity\Permisos;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Livewire\Component;

class ModalPermisosComponent extends Component
{
    public $id_permiso, $permiso, $descripcion, $nombre_permiso;
    public $modal = false;
    public $modal_adjuntar_rol = false;
    public $modal_adjuntar_usuario = false;
    public $roles;
    public $roles_seleccionados = [];
    public $usuarios;
    public $usuarios_seleccionados = [];

    protected $rules = [
        'permiso' => 'required|regex:/^\w+:{1}\w+$/|unique:App\Models\Permission,name',
        'nombre_permiso' => 'required',
        'descripcion' => 'required',
    ];

    protected $listeners = [
        'adjuntarRol' => 'abrirModalAdjuntarRol',
        'actualizar' => '$refresh',
        'editPermiso' => 'editar',
        'adjuntarUsuario' => 'abrirModalAdjuntarUsuario'
    ];

    public function render()
    {
        $this->fill([
            'usuarios' => User::all(['id', 'name'])->sortBy('name'),
            'roles' => Role::where('name', 'not like', 'root')->get(['name', 'display_name'])
        ]);

        return view('livewire.segurity.permisos.modal-permisos-component');
    }

    public function crear()
    {

        $this->id_permiso = -1;
        $this->limpiarCampos();
        $this->abrirModal();
    }

    public function limpiarCampos()
    {
        $this->fill([
            'permiso' => '',
            'descripcion' => '',
            'nombre_permiso' => '',
            'roles_seleccionados' => []
        ]);
    }

    public function abrirModal()
    {
        $this->modal = true;
        $this->dispatchBrowserEvent('limpiaForm');
        $this->emit('permiso:limpiarDetalle');
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function guardar()
    {

        if ($this->id_permiso == -1) {
            $this->validate();
        } else { // Si es edicion no verificar que el campo de permiso sea unico
            $this->validate([
                'permiso' => 'required|regex:/^\w+:{1}\w+$/',
                'nombre_permiso' => 'required',
                'descripcion' => 'required',
            ]);
        }

        $mensajes = ($this->id_permiso == -1 ? '[+] Permiso Ingresado Correctamente.' : '[*] Permiso Modificado Correctamente.');

        $permiso = Permission::updateOrCreate(
            ['id' => $this->id_permiso],
            [
                'name' => $this->permiso,
                'display_name' => $this->nombre_permiso,
                'description' => $this->descripcion,

            ]
        );

        $permiso->roles()->sync(Role::whereIn('name', [...$this->roles_seleccionados, 'root'])->pluck('id'));

        $permiso->users()->sync($this->usuarios_seleccionados);

        $this->emit('permiso:actualizar', 'success', $mensajes);

        $this->cerrarModal();
    }

    public function abrirModalAdjuntarRol($id)
    {
        $this->modal_adjuntar_rol = true;
        $this->emitSelf('actualizar');
        $this->dispatchBrowserEvent('limpiaForm');
        $this->emit('permiso:limpiarDetalle');

        $permiso = Permission::findOrFail($id);
        $this->fill([
            'id_permiso' => $permiso->id,
            'roles_seleccionados' => $permiso->roles()->pluck('name')->toArray()
        ]);
    }

    public function abrirModalAdjuntarUsuario($id)
    {
        $this->modal_adjuntar_usuario = true;
        $this->emitSelf('actualizar');
        $this->dispatchBrowserEvent('limpiaForm');
        $this->emit('permiso:limpiarDetalle');

        $permiso = Permission::findOrFail($id);
        $this->fill([
            'id_permiso' => $permiso->id,
            'usuarios_seleccionados' => $permiso->users()->pluck('name')->toArray()
        ]);
    }

    public function editar($id)
    {
        $permiso = Permission::findOrFail($id);
        $this->fill([
            'id_permiso' => $id,
            'permiso' => $permiso->name,
            'nombre_permiso' => $permiso->display_name,
            'descripcion' => $permiso->description,
            'roles_seleccionados' => $permiso->roles()->pluck('name')->toArray(),
            'usuarios_seleccionados' => $permiso->users()->pluck('name')->toArray()
        ]);
        $this->abrirModal();
        $this->emit('permiso:limpiarDetalle');
    }

    public function actualizarAdjuntarRol()
    {
        $permiso = Permission::find($this->id_permiso);
        $permiso->roles()->sync(Role::whereIn('name', $this->roles_seleccionados)->pluck('id'));
        $this->emit('permiso:actualizar', 'success', '[*] Registro Actualizado Correctamente.');
        $this->cerrarModalAdjuntarRol();
    }

    public function cerrarModalAdjuntarRol()
    {
        $this->limpiarCampos();
        $this->modal_adjuntar_rol = false;
    }

    public function actualizarAdjuntarUsuario()
    {
        $permiso = Permission::find($this->id_permiso);
        $permiso->users()->sync($this->usuarios_seleccionados);
        $this->emit('permiso:actualizar', 'success', '[*] Registro Actualizado Correctamente.');
        $this->cerrarModalAdjuntarUsuario();
    }

    public function cerrarModalAdjuntarUsuario()
    {
        $this->limpiarCampos();
        $this->modal_adjuntar_usuario = false;
    }
}
