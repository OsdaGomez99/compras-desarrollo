@extends('./layouts/app')

@section('titulo', ' - Usuarios')

@section('titulo-pagina', 'Lista de Usuarios')

@section('buscar')
<form id="search-form" class="navbar-left navbar-form nav-search mr-md-3" action="{{route('user.table')}}">
    <div class="input-group bg-white btn-round">
        <input name="buscar" id="input-search" type="text" placeholder="Buscar..." class="btn-round w-0 hidden border-blue-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
        <div class="input-group-prepend">
            <button id="btn-busqueda" type="submit" class="fa fa-search btn text-blue-500 ">
            </button>
        </div>
    </div>
</form>

@endsection

@section('button')
    <a href="{{route('user.registro')}}" class="btn bg-white btn-round fas fa-plus" title= "Agregar Usuario"> Agregar
    </a>
@endsection

@section('contenido')

@if (session('exito'))
    <div class="alert alert-success">
        {{ session('exito') }}
    </div>
@endif

<table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-primary-gradient">
            <tr>
                <th scope="col" class="px-6 py-3 text-center font-bold text-white tracking-wider">
                    Usuario
                </th>
                <th scope="col" class="px-6 py-3 text-center font-bold text-white tracking-wider">
                    Cedula
                </th>
                <th scope="col" class="px-6 py-3 text-center font-bold text-white tracking-wider">
                    Genero
                </th>
                <th scope="col" class="px-6 py-3 text-center font-bold text-white tracking-wider">
                    Teléfono
                </th>
                <th scope="col" class="px-6 py-3 text-center font-bold text-white tracking-wider">
                    Status
                </th>
                <th scope="col" class="relative px-6 py-3">
                </th>
                <th scope="col" class="relative px-6 py-3">
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($users as $user)
            <tr>
                <td class="px-3 py-2 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <img class="h-10 w-10 rounded-full" src="{{$user->profile_photo_url}}" alt="">
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{$user->name}} ({{$user->username}})
                      </div>
                      <div class="text-sm text-gray-500">
                        {{$user->email}}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-3 py-2 text-center whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{$user->cedula}}</div>
                </td>
                <td class="px-3 py-2 text-center whitespace-nowrap">
                    @if ($user->sexo == 'M')
                        Masculino
                    @else
                        Femenino
                    @endif
                </td>
                <td class="px-3 py-2 text-center whitespace-nowrap text-gray-500">
                  {{$user->telefono}}
                </td>
                <td class="px-3 py-2 text-center whitespace-nowrap">
                    <span class="px-2 inline-flex leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        {{$user->status_nombre}}
                    </span>
                  </td>
                  <td>
                    <a class="btn btn-success btn-sm" href="#" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
                <td>
                    <form action="{{route('user.eliminar', $user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="btn_eliminar btn btn-danger btn-sm" title="Eliminar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if(!is_a($users, 'Illuminate\Database\Eloquent\Collection'))
        {{$users->render()}}
    @endif

@endsection


