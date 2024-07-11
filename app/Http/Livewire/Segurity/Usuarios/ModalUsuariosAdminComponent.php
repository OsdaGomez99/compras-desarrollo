<?php

namespace App\Http\Livewire\Segurity\Usuarios;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class ModalUsuariosAdminComponent extends Component
{

    public $modal_adjuntar_rol, $modal_adjuntar_permiso;
    public $id_usuario;
    public $roles_seleccionados;
    public $permisos_seleccionados;
    public $roles;
    public $permisos;

    public $listeners = [
        'mdlusuarios:adjuntarRol' => 'abrirModalAdjuntarRol',
        'mdlusuarios:actualizar' => '$refresh',
        'mdlusuarios:adjuntarPermiso' => 'abrirModalAdjuntarPermiso'
    ];

    public function render()
    {
        if($this->permisos) {
            $this->fill([
                'roles' => Role::where('name', 'not like', 'root')->get(['name', 'display_name'])
            ]);
        } else {
            $this->fill([
                'roles' => Role::where('name', 'not like', 'root')->get(['name', 'display_name']),
                'permisos' => Permission::all(['id', 'name', 'display_name'])
            ]);
        }
        return view('livewire.segurity.usuarios.modal-usuarios-admin-component');
    }

    public function cerrarModalAdjuntarRol()
    {
        $this->limpiarCampos();
        $this->modal_adjuntar_rol = false;
    }

    public function limpiarCampos()
    {
        $this->fill([
            'roles_seleccionados' => [],
            'permisos_seleccionados' => []
        ]);
    }

    public function actualizarAdjuntarRol()
    {
        $usuario = User::find($this->id_usuario);
        $usuario->adjuntarRoles($this->roles_seleccionados, 'name');

        $this->emit('usuarios:actualizar', 'success', '[*] Registro Actualizado Correctamente.');
        $this->cerrarModalAdjuntarRol();
    }

    public function cerrarModalAdjuntarPermiso()
    {
        $this->limpiarCampos();
        $this->modal_adjuntar_permiso = false;
    }

    public function abrirModalAdjuntarRol($id)
    {
        $this->modal_adjuntar_rol = true;
        $this->emitSelf('mdlusuarios:actualizar');
        $this->dispatchBrowserEvent('limpiaForm');
        $this->emit('usuarios:limpiarDetalles');

        $usuario = User::findOrFail($id);
        $this->fill([
            'id_usuario' => $usuario->id,
            'roles_seleccionados' => $usuario->roles()->pluck('name')->toArray()
        ]);
    }

    public function abrirModalAdjuntarPermiso($id)
    {
        $this->modal_adjuntar_permiso = true;
        $this->emitSelf('mdlusuarios:actualizar');
        $this->dispatchBrowserEvent('limpiaForm');
        $this->emit('usuarios:limpiarDetalles');

        $usuario = User::where('id', $id)->with('permissions', 'roles')->first();

        // Obtenemos los permisos que tiene el usuario a partir de la coleccion
        $permisos_usuario_name = $usuario['permissions']->flatten()->pluck('name');

        $permisos_usuario = $usuario['permissions']->map( function ($item, $key) {
            return ['id' => $item['id'], 'name' => $item['name'], 'display_name' => $item['display_name'] ];
        } );

        // Obtenemos los roles que tiene el usuario
        $roles_usuario_id = $usuario['roles']->flatten()->pluck('id');

        // Obtenemos los permisos que tiene el usuario por sus roles
        $permisos_roles = Role::whereIn('id', $roles_usuario_id)->with('permissions')->get()->map( function ($item, $key) {
            return $item['permissions']->pluck('name');
        } )->flatten()->unique();

        // Juntamos ambos permisos (usuario y por roles) para que no aparezca en las opciones
        $permisos_usuario_totales = $permisos_usuario_name->merge($permisos_roles)->unique();

        $this->fill([
            'id_usuario' => $id,
            'permisos_seleccionados' => $permisos_usuario,
            'permisos' => Permission::whereNotIn('name', $permisos_usuario_totales)->get(['id', 'name', 'display_name'])
        ]);

    }

    public function actualizarAdjuntarPermiso()
    {
        $usuario = User::find($this->id_usuario);
        $usuario->permissions()->sync(Permission::whereIn('name', $this->permisos_seleccionados)->pluck('id'));
        $this->emit('usuarios:actualizar','success','[*] Registro Actualizado Correctamente.');
        $this->cerrarModalAdjuntarPermiso();
    }

}
