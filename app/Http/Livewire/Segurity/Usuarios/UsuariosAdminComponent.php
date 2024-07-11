<?php

namespace App\Http\Livewire\Segurity\Usuarios;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class UsuariosAdminComponent extends Component
{

    use WithPagination;

    public $busqueda;
    protected $queryString = ['busqueda'];
    public $detalle_name, $detalle_usuario, $is_permiso, $is_rol, $is_user, $detalle_permiso;

    protected $listeners = [
        'usuario:busqueda' => 'busqueda',
        'usuarios:limpiarDetalles' => 'limpiarDetalles',
        'usuarios:actualizar' => '$refresh'
    ];

    public function render()
    {

        $data_select = ['id', 'name', 'username', 'email', 'cedula', 'last_login', 'status'];
        $data_count = ['roles', 'permissions', 'user_permisos_roles'];

        if ($this->busqueda) {

            $usuarios = User::select($data_select)
                ->search($this->busqueda)
                ->orderBy('name')
                ->withCount($data_count)
                ->paginate(10);
        } else {
            $usuarios = User::select($data_select)
                ->orderBy('name')
                ->withCount($data_count)
                ->paginate(10);
        }

        return view('livewire.segurity.usuarios.usuarios-admin-component', ['usuarios' => $usuarios]);
    }

    public function busqueda($busqueda)
    {
        $this->busqueda = $busqueda;
    }

    public function detalleRoles($id)
    {
        $usuario = User::findOrFail($id);

        if ($this->detalle_name != $usuario->username || !$this->is_rol) {

            $this->fill([
                'detalle_name' => $usuario->username,
                'detalle_usuario' => implode(', ', $usuario->roles()->pluck('name')->toArray()),
                'is_permiso' => false,
                'is_rol' => true,
                'is_user' => false
            ]);
        } else {
            $this->limpiarDetalles();
        }
    }

    public function detallePermisos($id)
    {
        $usuario = User::findOrFail($id);

        if ($this->detalle_name != $usuario->username || !$this->is_permiso) {

            $this->fill([
                'detalle_name' => $usuario->username,
                'detalle_usuario' => implode(', ', $usuario->permissions()->pluck('name')->toArray()),
                'detalle_permiso' => $usuario->roles()->with('permissions')->get()->map(function ($item, $key) {
                    $permisos = implode(', ', $item['permissions']->pluck('display_name')->toArray());
                    return ['role' => $item->display_name, 'permisos' => $permisos];
                }),
                'is_permiso' => true,
                'is_rol' => false,
                'is_user' => false
            ]);
        } else {
            $this->limpiarDetalles();
        }
    }

    public function detalleUsuario($id)
    {
        $usuario = User::findOrFail($id);

        if ($this->detalle_name != $usuario->username || !$this->is_user) {

            $status = match($usuario->status) {
                0 => 'Eliminado',
                1 => 'Activo',
                2 => 'Inactivo',
                default => 'Desconocido'
            };

            $this->fill([
                'detalle_name' => $usuario->username,
                'detalle_usuario' => [
                    "Nombre: $usuario->name",
                    "Usuario: $usuario->username",
                    "Correo: $usuario->email",
                    "Cédula: $usuario->cedula",
                    "Estatus: $status",
                    "Última vez: $usuario->last_login",
                    "Última IP: $usuario->last_ip_login",
                ],
                'is_permiso' => false,
                'is_rol' => false,
                'is_user' => true
            ]);

        } else {
            $this->limpiarDetalles();
        }
    }

    public function limpiarDetalles()
    {
        $this->fill([
            'detalle_name' => '',
            'detalle_usuario' => '',
            'is_permiso' => false,
            'is_rol' => false,
            'is_user' => false
        ]);
    }

    public function adjuntarRoles($id){
        $this->emit('mdlusuarios:adjuntarRol', $id);
    }

    public function adjuntarPermisos($id){
        $this->emit('mdlusuarios:adjuntarPermiso', $id);
    }

    public function modificarEstatus(User $usuario, $status) {
        $usuario->status = $status;
        $usuario->save();
    }

}
