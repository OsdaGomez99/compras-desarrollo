<?php

namespace App\Http\Livewire\Segurity\Usuarios;

use Livewire\Component;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Role;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\MessageBag;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UsuariosFormComponent extends Component
{

    public $name, $nacionalidad, $numero_cedula, $username, $email;
    public $roles;
    public $permisos = null;
    public $roles_seleccionados = [];
    public $permisos_seleccionados = [];
    public $permisos_usuario = [];
    public $mode_edit;
    public $roles_permisos = [];
    public $display_permisos_roles = [];

    protected $listeners = [
        'actualizar:usuarios' => '$refresh'
    ];

    public function mount($user)
    {
        if($user)
        {
            $usuario = User::where('username', $user)->with('permissions')->first();

            $permisos_usuario = $usuario->permissions->map( function ($item, $key) {
                return ['texto' => $item['display_name'], 'value' => $item['name']];
            } );

            //dd($usuario->roles()->with('permissions')->get());

            $this->fill([
                'mode_edit' => true,
                'name' => $usuario->name,
                'nacionalidad' => Str::lower($usuario->cedula[0]),
                'numero_cedula' => substr($usuario->cedula, 1),
                'username' => $usuario->username,
                'email' => $usuario->email
            ]);

            $this->roles = Role::select('display_name as texto', 'name as value')->where('name', "not like", 'root')->get()->toArray();

            $this->permisos = Permission::all(['display_name as texto', 'name as value'])->toArray();

            // Uso un permisos seleccionados distinto en el edit porque el formato es diferente
            $this->permisos_usuario = $permisos_usuario;

            $this->emitSelf('actualizar:usuarios');

        }
        else
        {
            $this->mode_edit = false;

            $this->roles = Role::select('display_name as texto', 'name as value')->where('name', "not like", 'root')->get()->toArray();

            $this->permisos = Permission::all(['display_name as texto', 'name as value'])->toArray();
        }

    }

    public function render()
    {
        return view('livewire.segurity.usuarios.usuarios-form-component');
    }

    public function updatedName()
    {
        if(!$this->mode_edit)
        {
            $this->name = trim($this->name);
            $split_name = explode(' ', $this->name);

            if (count($split_name) < 2) {

                $this->setErrorBag(new MessageBag(['Debe colocar por lo menos un nombre y un apellido']));
                $this->username = '';
            } else {

                $username = strtolower($split_name[0][0] . ($split_name[2] ?? end($split_name)));

                if (!User::where('username', $username)->get()->isEmpty()) {
                    $username = strtolower($split_name[0][0] . $split_name[1][0] . ($split_name[2] ?? end($split_name)));
                }
                $this->username = $username;
            }
        }
    }

    public function updatedRolesSeleccionados()
    {
        $permisos_roles = Role::whereIn('name', $this->roles_seleccionados)->with('permissions')->get();

        if ($permisos_roles->isNotEmpty()) {

            $this->roles_permisos = $permisos_roles->map(function ($item, $key) {
                return ['rol' => $item['display_name'], 'permisos' =>  $item['permissions']->pluck('display_name') ];
            })->map(function ($item, $key) {
                return $item['permisos']->map( function ($item_permisos, $key_permisos) use ($item, $key) {
                    return $item_permisos . $item['rol'];
                });
            } );

            $name_permisos_roles = $permisos_roles->map(function ($item, $key) {
                return $item['permissions']->pluck('name');
            })->flatten()->unique();

            $this->display_permisos_roles = $permisos_roles->map(function ($item, $key) {
                return $item['permissions']->pluck('display_name');
            })->flatten()->unique();

            $this->permisos = Permission::whereNotIn('name', $name_permisos_roles)->get(['display_name as texto', 'name as value'])->toArray();

        }else {
            $this->permisos = Permission::all(['display_name as texto', 'name as value'])->toArray();
            $this->display_permisos_roles = [];
        }

        $this->dispatchBrowserEvent('reiniciarSelectPermisos');
    }

    public function resetearPassword()
    {
        $usuario = User::find($this->usuario_id);
        $usuario->update(['password' => Hash::make(substr($usuario->cedula, 1))]);
        session()->flash('success', 'Contraseña reiniciada, el usuario puede acceder ahora con su número de cédula');
        $this->dispatchBrowserEvent('scrollToUp');
    }

    public function limpiarForm()
    {
        $this->fill([
            'name' => '',
            'nacionalidad' => '',
            'numero_cedula' => '',
            'username' => '',
            'email' => '',
            'roles_seleccionados' => [],
            'permisos_seleccionados' => []
        ]);
        $this->dispatchBrowserEvent('reiniciarSelects');
    }

    public function save()
    {
        $user = new CreateNewUser();

        $cedula_completa = Str::upper($this->nacionalidad ?? 'v') . $this->numero_cedula;

        $usuario_creado = $user->create([
            'name' => $this->name,
            'username' => $this->username,
            'cedula' => $cedula_completa,
            'email' => $this->email,
            'password' => $this->numero_cedula,
            'permisos_seleccionados' => Permission::whereIn('name', $this->permisos_seleccionados)->pluck('id'),
            'roles_seleccionados' => Role::whereIn('name', $this->roles_seleccionados)->pluck('id')
        ]);

        if($usuario_creado) {
            return redirect()->route('admin.user.index')->with('success', 'Usuario creado satisfactoriamente');

        } else {
            $this->setErrorBag(new MessageBag(['Error al crear el usuario']));
        }

    }

    public function update() {

        $user = new UpdateUserProfileInformation();
    }

}
