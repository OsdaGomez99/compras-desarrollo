<?php

namespace App\Http\Livewire\Segurity\Usuarios;

use Livewire\Component;
use App\Models\User;

class TablaUsuariosComponent extends Component
{
    public function render()
    {
        $usuarios = User::where("status", ">", 0)->orderBy('id', 'ASC')->paginate(10);

        return view('livewire.segurity.usuarios.tabla-usuarios-component', ['usuarios' => $usuarios]);
    }
}
