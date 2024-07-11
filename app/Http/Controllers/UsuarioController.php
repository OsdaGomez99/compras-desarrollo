<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\ActualizarPerfilUsuario;
use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Str;
use App\Actions\Fortify\UpdateUserPassword;
use App\Models\User;
use App\Classes\CollectionHelper;

class UsuarioController extends Controller
{
    //
    public function crearUsuario(Request $request)
    {

        $user = new CreateNewUser();

        $cedula = Str::upper($request->nacionalidad) . $request->cedula;

        $user->create([
            'name' => $request->name,
            'username' => $request->username,
            'cedula' => $cedula,
            'genero' => $request->genero,
            'telefono' => $request->telefono ?? '',
            'email' => $request->email,
            'password' => $request->cedula
        ]);

        return redirect('principal')->with('exito', 'Usuario creado satisfactoriamente');
    }

    public function actualizarUsuario(Request $request)
    {
        $data = [];

        if(isset($request->email) || isset($request->telefono)){

            if($request->telefono)
            {
                $data['telefono'] = $request->telefono;
            }

            if($request->email)
            {
                $data['email'] = $request->email;
            }

            $actualizarUsuario = new ActualizarPerfilUsuario();

            $actualizarUsuario->update(auth()->user(), $data);

        }

        if(isset($request->password)){

            $updateUserPassword = new UpdateUserPassword();

            $updateUserPassword->update(auth()->user(), [
                'current_password' => $request->current_password,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation
                ]
            );
        }

        return redirect('usuario/configuracion')->with('exito', 'Datos modificados satisfactoriamente');
    }

    public function mostrarUsuarios(Request $request){

        $busqueda = trim($request['buscar']);

        if($busqueda != '')
        {
            // Comprobamos si es un status
            if(stripos($busqueda, "Activo") !== false || stripos($busqueda, "Inactivo") !== false)
            {
                $codigo = User::$status_codigo[ucfirst($busqueda)];

                $users = User::where('status',$codigo)->orderBy('id','ASC')->paginate(10);

            // Comprobamos si es un correo electronico
            }else if(preg_match('/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/', $busqueda) !== 0)
            {
                $users = User::where("status", ">", 0)->where('email', 'ilike', '%' . $busqueda . '%')->get(['profile_photo_path', 'name', 'username', 'email', 'cedula', 'sexo', 'telefono', 'id', 'status']);

            // Comprobamos si es un numero telefonico
            }else if(preg_match('/^0[2,4][0-9]{9}$/', $busqueda) !== 0)
            {
                $users = User::where("status", ">", 0)->where('telefono', $busqueda)->get(['profile_photo_path', 'name', 'username', 'email', 'cedula', 'sexo', 'telefono', 'id', 'status']);

            // Comprobamos si es una cedula
            }else if(preg_match('/^(V|v|E|e|P|p)\d{8}$/', $busqueda) !== 0)
            {
                $users = User::where("status", ">", 0)
                ->where('cedula', ucfirst($busqueda))
                ->get(
                    ['profile_photo_path', 'name', 'username', 'email', 'cedula',
                    'sexo', 'telefono', 'id', 'status'
                    ]
                );

            }else
            {
                $users = User::where('name', 'ilike', '%'.$busqueda.'%')
                ->orWhere('username', 'ilike', '%'.$busqueda.'%')
                ->orWhere('email', 'ilike', '%'.$busqueda.'%')
                ->orWhere('cedula', 'ilike', '%'.$busqueda.'%')
                ->orWhere('telefono', 'ilike', '%'.$busqueda.'%')
                ->orderBy('id', 'ASC')->paginate(10);

            }

        }else{

            $users = User::where("status", ">", 0)->orderBy('id', 'ASC')->paginate(10);

        }

        return view('users.usertable', ['users' => $users]);
    }

    public function eliminarUsuario(User $user)
    {
        $user->status = 0;
        $user->save();
        return redirect()->route('user.table')->with('exito', "Usuario $user->name borrado.");
    }

}
