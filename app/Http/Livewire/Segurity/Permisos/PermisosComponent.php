<?php

namespace App\Http\Livewire\Segurity\Permisos;

use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use App\Models\User;

class PermisosComponent extends Component
{
    use WithPagination;

    public $roles_permisos, $permiso_name, $usuarios_permisos, $is_rol, $usuarios_roles;
    public $busqueda;

    protected $queryString = ['busqueda'];

    protected $listeners = [
        'permiso:actualizar' => 'actualizar',
        'permisos:deleteData' => 'deleteData',
        'permiso:limpiarDetalle' => 'limpiarDetalles',
        'permisos:busqueda' => 'busqueda'
    ];

    public function busqueda($busqueda){
        $this->busqueda = $busqueda;
    }

    public function render()
    {
        if($this->busqueda){
            $permisos = Permission::select(['id', 'name', 'display_name', 'description'])->search($this->busqueda)->withCount([
                'users',
                'roles',
                'user_roles'
            ])->paginate(10);
        }else{
            $permisos = Permission::select(['id', 'name', 'display_name', 'description'])->withCount([
                'users',
                'roles',
                'user_roles'
            ])->paginate(10);
        }

        return view('livewire.segurity.permisos.permisos-component', ['permisos' => $permisos]);
    }

    public function actualizar($tipo, $mensaje)
    {
        $this->limpiarDetalles();
        session()->flash($tipo, $mensaje);
    }

    public function detalleRoles(Permission $permiso)
    {
        if($this->permiso_name != $permiso->name || !$this->is_rol)
        {
            $this->fill([
                'permiso_name' => $permiso->name,
                'roles_permisos' => implode(', ', $permiso->roles()->pluck('display_name')->toArray()),
                'is_rol' => true
            ]);

        }else
        {
            $this->limpiarDetalles();
        }
    }

    public function detalleUsuarios($id)
    {

        $permiso = Permission::findOrFail($id);

        if($this->permiso_name != $permiso->name || $this->is_rol)
        {
            $this->permiso_name = $permiso->name;
            $vector_usuarios_permisos = $permiso->users()->pluck('name')->toArray();
            $vector_permisos_roles = User::wherePermissionIs($permiso->name)->pluck('name')->toArray();

            $this->fill([
                'usuarios_roles' => implode(', ', array_diff($vector_permisos_roles, $vector_usuarios_permisos)),
                'usuarios_permisos' => implode(', ', $vector_usuarios_permisos),
                'is_rol' => false
            ]);

        }else
        {
            $this->limpiarDetalles();
        }
    }

    public function deleteConfirm(Permission $permiso)
    {
        if($permiso->roles()->count() != 0 || $permiso->users()->count() != 0)
        {
            if(!auth()->user()->hasRole('root')) {
                $this->dispatchBrowserEvent('notDelete', [
                    'title' => 'Error',
                    'message' => 'No se puede borrar <strong>' . $permiso->name . '</strong> porque existen roles y/o usuarios con el permiso',
                ]);

            }else
            {
                $this->dispatchBrowserEvent('deleteConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres eliminar el permiso <strong>' . $permiso->name . '.</strong> El permiso sera eliminado de todos los roles y usuarios que los tengan',
                    'id' => $permiso->id,
                    'modulo' => 'permisos'
                ]);
            }

        }else
        {
            $this->dispatchBrowserEvent('deleteConfirm', [
                'title' => '¿Estas seguro?',
                'message' => 'Que quieres eliminar el permiso <strong>' . $permiso->name . '</strong>',
                'id' => $permiso->id,
                'modulo' => 'permisos'
            ]);
        }

    }

    public function adjuntarRol($id)
    {
        $this->emit('adjuntarRol', $id);
    }

    public function adjuntarUsuario($id)
    {
        $this->emit('adjuntarUsuario', $id);
    }

    public function deleteData($id)
    {

        $permiso = Permission::findOrFail($id);

        if($permiso->users())
        {
            if(auth()->user()->hasRole('root')){
                $permiso->users()->detach();
            }else {
                abort(403);
            }
        }

        if($permiso->roles())
        {
            if(auth()->user()->hasRole('root')){
                $permiso->roles()->detach();
            }else {
                abort(403);
            }
        }

        $permiso->delete();

        $this->emitSelf('permiso:actualizar', 'success', '[-] Permiso eliminado satisfactoriamente');
    }

    public function limpiarDetalles(){
        $this->fill([
            'permiso_name' => '',
            'roles_permisos' => '',
            'is_rol' => false,
            'usuarios_permisos' => ''
        ]);
    }

}
