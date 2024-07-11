<div>
    @if (session('success'))
        <x-session-alert type="success">
            {{ session('success') }}
        </x-session-alert>
    @elseif (session('error'))
        <x-session-alert type="danger">
            {{ session('error') }}
        </x-session-alert>
    @endif

    <div class="overflow-x-scroll">

        <x-table.table class="table-auto">

            <x-table.table-header :encabezados="['Usuario', 'Roles', 'Permisos', 'Ultima vez', 'Acciones']" />

            <tbody>
                @forelse ($usuarios as $usuario)

                    @php
                        if ($usuario->status == 1) {
                            $colortxt = 'text-blue-500';
                            $colorbg = 'border-blue-500';
                        } else {
                            $colortxt = 'text-red-500';
                            $colorbg = 'border-red-500';
                        }
                    @endphp

                    <tr>
                        <td class="px-3 py-2 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img wire:click="detalleUsuario({{ $usuario->id }})"
                                        class="h-10 w-10 rounded-full cursor-pointer border-2 border-solid {{ $colorbg }}"
                                        src="{{ $usuario->profile_photo_url }}" alt="">
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
                        <td class="text-center">
                            <div class="hov-dropdown p-2">
                                <button class="dropbtn" data-toggle="dropdown" aria-expanded="true">
                                    <span class="badge badge-primary badge-pill">
                                        {{ $usuario->roles_count }}
                                    </span>
                                </button>
                                <ul class="hov-dropdown-content dropdown-menu hov-dropdown-menu animated fadeIn hidden-caret"
                                    aria-labelledby="dropdownMenu_{{ $usuario->id }}"
                                    id="dropdownMenu_{{ $usuario->id }}">
                                    <li class="text-center">
                                        <button type="button" wire:click="detalleRoles({{ $usuario->id }})"
                                            class="mr-2 btn btn-icon btn-round btn-primary btn-border icon-eye btn-show-detail"
                                            title="Ver roles adjuntos">
                                        </button>
                                        <button type="button" wire:click="adjuntarRoles({{ $usuario->id }})"
                                            class="btn btn-icon btn-round btn-primary btn-border icon-pin"
                                            title="Adjuntar un rol">
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="hov-dropdown p-2">
                                <button class="dropbtn" data-toggle="dropdown" aria-expanded="true">
                                    <span class="badge badge-primary badge-pill">
                                        {{ $usuario->permissions_count + $usuario->user_permisos_roles_count }}
                                    </span>
                                </button>
                                <ul class="hov-dropdown-content dropdown-menu hov-dropdown-menu animated fadeIn hidden-caret"
                                    aria-labelledby="dropdownMenu_Parroquia_{{ $usuario->id }}"
                                    id="dropdownMenu_Parroquia_{{ $usuario->id }}">
                                    <li class="text-center">
                                        <button type="button" wire:click="detallePermisos({{ $usuario->id }})"
                                            class="mr-2 btn btn-icon btn-round btn-primary btn-border icon-eye btn-show-detail"
                                            title="Ver usuarios con el rol">
                                        </button>
                                        <button type="button" wire:click="adjuntarPermisos({{ $usuario->id }})"
                                            class="btn btn-icon btn-round btn-primary btn-border icon-pin"
                                            title="Adjuntar un Permiso">
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td class="text-gray-900 text-center"
                            title="{{ $usuario->last_login ? date_format(date_create($usuario->last_login), 'd/m/Y H:i:s') : '' }}">
                            {{ $usuario->last_login ? date_format(date_create($usuario->last_login), 'd/m/Y') : '' }}
                        </td>
                        <x-table.td-dropdown estilo="tw" colortxt="{{ $colortxt }}" colorbg="{{ $colorbg }}">
                            <x-boton.boton-dropdown modo="link" href="{{ route('admin.user.edit', $usuario->username) }}"
                                icon="icon-note" text="Editar" />
                            <x-boton.boton-dropdown wire:click="" icon="icon-trash" text="Eliminar" />
                            @if ($usuario->status == 1)
                                <x-boton.boton-dropdown wire:click="modificarEstatus({{ $usuario->id }}, 2)"
                                    icon="fa-solid fa-eye-slash" text="Desactivar" />
                            @else
                                <x-boton.boton-dropdown wire:click="modificarEstatus({{ $usuario->id }}, 1)"
                                    icon="fa-solid fa-eye" text="Activar" />
                            @endif
                        </x-table.td-dropdown>
                    </tr>
                    @if ($detalle_name == $usuario->username)
                        <tr>
                            <x-table.td-detalle id="{{ $loop->index }}" colspan="6">
                                @if ($is_permiso)
                                    @if ($detalle_usuario)
                                        <div>
                                            <div class="text-base">Por permiso: </div>
                                            {{ $detalle_usuario }}
                                        </div>
                                    @endif
                                    @if ($detalle_permiso)
                                        <div {{ $detalle_usuario ? 'class=mt-2' : '' }}>
                                            <div class="text-base">Adjunto a un rol: </div>
                                            <ul>
                                                @foreach ($detalle_permiso as $detalle)
                                                    <li class="ml-2 mt-1"> <span
                                                            class="font-black">{{ $detalle['role'] }}</span>:
                                                        {{ $detalle['permisos'] }}. </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @elseif (is_array($detalle_usuario))
                                    <ul>
                                        @foreach ($detalle_usuario as $detalle)
                                            <li>{{ $detalle }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $detalle_usuario }}
                                @endif
                            </x-table.td-detalle>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td class="p-3 text-center" colspan="5">[-] No hay registros.</td>
                    </tr>
                @endforelse
            </tbody>
        </x-table.table>

        <div class="card-footer justify-center">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>
