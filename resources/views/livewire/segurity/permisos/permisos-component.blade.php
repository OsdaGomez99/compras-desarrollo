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

    <div class="card-body">
        @if (count($permisos) <= 0)
            <table class="table table-bordered table-striped">
                <tr>
                    <td class="p-3 text-center">[-] No hay registros.</td>
                </tr>
            </table>
        @else

            <x-table.table class="table-fixed">

                <x-table.table-header
                    :encabezados="['Permiso', 'Nombre', 'Descripción', 'Roles Adjuntos', 'Usuarios', 'Acciones']"
                />

                <tbody>
                    @foreach ($permisos as $permiso)
                        <tr>
                            <td class="text-gray-900 text-center"> {{ $permiso->name }} </td>
                            <td class="text-gray-900 text-center"> {{ $permiso->display_name }} </td>
                            <td class="text-gray-900 text-center"> {{ $permiso->description }} </td>
                            <td class="text-center">
                                <div class="hov-dropdown p-2">
                                    <button class="dropbtn" data-toggle="dropdown" aria-expanded="true">
                                        <span class="badge badge-primary badge-pill">
                                            {{ $permiso->roles_count }}
                                        </span>
                                    </button>
                                    <ul class="hov-dropdown-content dropdown-menu hov-dropdown-menu animated fadeIn hidden-caret"
                                        aria-labelledby="dropdownMenu_Parroquia_{{ $permiso->id }}"
                                        id="dropdownMenu_Parroquia_{{ $permiso->id }}">
                                        <li class="text-center">
                                            <button type="button" wire:click="detalleRoles({{ $permiso->id }})"
                                                class="mr-2 btn btn-icon btn-round btn-primary btn-border icon-eye btn-show-detail"
                                                title="Ver roles adjuntos">
                                            </button>
                                            <button type="button" wire:click="adjuntarRol({{ $permiso->id }})"
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
                                            {{ $permiso->users_count + $permiso->user_roles_count }}
                                        </span>
                                    </button>
                                    <ul class="hov-dropdown-content dropdown-menu hov-dropdown-menu animated fadeIn hidden-caret"
                                        aria-labelledby="dropdownMenu_Parroquia_{{ $permiso->id }}"
                                        id="dropdownMenu_Parroquia_{{ $permiso->id }}">
                                        <li class="text-center">
                                            <button type="button" wire:click="detalleUsuarios({{ $permiso->id }})"
                                                class="mr-2 btn btn-icon btn-round btn-primary btn-border icon-eye btn-show-detail"
                                                title="Ver usuarios con el permiso">
                                            </button>
                                            <button type="button" wire:click="adjuntarUsuario({{ $permiso->id }})"
                                                class="btn btn-icon btn-round btn-primary btn-border icon-pin"
                                                title="Adjuntar un usuario">
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <x-table.td-action>
                                <x-boton.boton-action class="icon-note" title="Editar"
                                    wire:click="$emit('editPermiso',({{ $permiso->id }}))">
                                </x-boton.boton-action>
                                <x-boton.boton-action class="icon-trash" title="Eliminar"
                                    wire:click="deleteConfirm({{ $permiso->id }})">
                                </x-boton.boton-action>
                            </x-table.td-action>
                        </tr>
                        @if ($permiso_name == $permiso->name)
                            <tr>
                                @if ($is_rol)
                                    <x-table.td-detalle id="permiso-{{ $loop->index }}" colspan="6" >
                                        {{ $roles_permisos }}
                                    </x-table.td-detalle>
                                @else
                                    <x-table.td-detalle id="permiso-{{ $loop->index }}" colspan="6" >
                                        @if ($usuarios_roles)
                                            <div>
                                                <div class="text-base">Adjunto a un rol: </div>
                                                {{ $usuarios_roles }}
                                            </div>
                                        @endif
                                        @if ($usuarios_permisos)
                                            <div {{ $usuarios_roles ? "class=mt-2" : '' }}>
                                                <div class="text-base">Por permiso: </div>
                                                {{ $usuarios_permisos }}
                                            </div>
                                        @endif
                                    </x-table.td-detalle>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>

            </x-table.table>

            <div class="card-footer justify-center">
                {{ $permisos->links() }}
            </div>
        @endif
    </div>
</div>
