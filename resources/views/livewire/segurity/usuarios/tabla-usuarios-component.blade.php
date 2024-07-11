<div>
    @if (session('success'))
        <x-session-alert :type="success">
            {{ session('success') }}
        </x-session-alert>
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
            @foreach ($usuarios as $usuario)
                <tr>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="{{ $usuario->profile_photo_url }}" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $usuario->name }} ({{ $usuario->username }})
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $usuario->email }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-2 text-center whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $usuario->cedula }}</div>
                    </td>
                    <td class="px-3 py-2 text-center whitespace-nowrap">
                        @if ($usuario->sexo == 'M')
                            Masculino
                        @else
                            Femenino
                        @endif
                    </td>
                    <td class="px-3 py-2 text-center whitespace-nowrap text-gray-500">
                        {{ $usuario->telefono }}
                    </td>
                    <td class="px-3 py-2 text-center whitespace-nowrap">
                        <span class="px-2 inline-flex leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $usuario->status_nombre }}
                        </span>
                    </td>
                    <td>
                        <a class="btn btn-success btn-sm" href="#" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('user.eliminar', $usuario->id) }}" method="POST">
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
    @if (!is_a($usuarios, 'Illuminate\Database\Eloquent\Collection'))
        {{ $usuarios->render() }}
    @endif
</div>
