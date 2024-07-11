<?php

namespace App\Http\Livewire\Segurity\Roles;

use Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;

class RolesComponent extends Component
{
    use WithPagination;

    public $permisos_roles, $rol_name, $usuarios_permisos, $is_permiso, $usuarios_roles;
    public $busqueda;

    protected $queryString = ['busqueda'];

    protected $listeners = [
        'rol:actualizar' => 'actualizar',
        'rol:deleteData' => 'deleteData',
        'rol:limpiarDetalle' => 'limpiarDetalles',
        'rol:busqueda' => 'busqueda'
    ];

    public function render()
    {
        if ($this->busqueda) {
            $roles = Role::select(['id', 'name', 'display_name', 'description'])->search($this->busqueda)->withCount([
                'users',
                'permissions'
            ])->paginate(10);
        } else {
            $roles = Role::select(['id', 'name', 'display_name', 'description'])->withCount([
                'users',
                'permissions'
            ])->paginate(10);
        }
        return view('livewire.segurity.roles.roles-component', ['roles' => $roles]);
    }

    public function busqueda($busqueda)
    {
        $this->busqueda = $busqueda;
    }

    public function actualizar($tipo, $mensaje)
    {
        $this->limpiarDetalles();
        session()->flash($tipo, $mensaje);
    }

    public function detallePermisos(Role $rol)
    {
        if ($this->rol_name != $rol->name || !$this->is_permiso) {
            $this->fill([
                'rol_name' => $rol->name,
                'permisos_roles' => implode(', ', $rol->permissions()->pluck('display_name')->toArray()),
                'is_permiso' => true
            ]);
        } else {
            $this->limpiarDetalles();
        }
    }

    public function detalleUsuarios($id)
    {
        $rol = Role::findOrFail($id);

        if ($this->rol_name != $rol->name || $this->is_permiso) {
            $this->fill([
                'rol_name' => $rol->name,
                'usuarios_roles' => implode(', ', $rol->users()->pluck('name')->toArray()),
                'is_permiso' => false
            ]);
        } else {
            $this->limpiarDetalles();
        }
    }

    public function limpiarDetalles()
    {
        $this->fill([
            'rol_name' => '',
            'permisos_roles' => '',
            'usuarios_roles' => '',
            'is_permiso' => false,
            'is_rol' => false
        ]);
    }

    public function deleteConfirm(Role $rol)
    {
        if ($rol->permissions()->count() != 0 || $rol->users()->count() != 0) {
            if (!auth()->user()->hasRole('root')) {
                $this->dispatchBrowserEvent('notDelete', [
                    'title' => 'Error',
                    'message' => 'No se puede borrar <strong>' . $rol->name . '</strong> porque existen permisos y/o usuarios con el rol',
                ]);
            } else {
                $this->dispatchBrowserEvent('deleteConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres eliminar el rol <strong>' . $rol->name . '.</strong> El rol sera eliminado de todos los permisos y usuarios que los tengan',
                    'id' => $rol->id,
                    'modulo' => 'rol'
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('deleteConfirm', [
                'title' => '¿Estas seguro?',
                'message' => 'Que quieres eliminar el permiso <strong>' . $rol->name . '</strong>',
                'id' => $rol->id,
                'modulo' => 'rol'
            ]);
        }
    }

    public function adjuntarPermiso($id)
    {
        $this->emit('adjuntarPermiso', $id);
    }

    public function adjuntarUsuario($id)
    {
        $this->emit('adjuntarUsuario', $id);
    }

    public function deleteData($id)
    {
        $rol = Role::findOrFail($id);

        if ($rol->users()) {
            if (auth()->user()->hasRole('root')) {
                $rol->users()->detach();
            } else {
                abort(403);
            }
        }

        if ($rol->permissions()) {
            if (auth()->user()->hasRole('root')) {
                $rol->permissions()->detach();
            } else {
                abort(403);
            }
        }

        $rol->delete();

        $this->emitSelf('rol:actualizar', 'success', '[-] Rol eliminado satisfactoriamente');
    }
}
