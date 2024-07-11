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
        @if (count($roles) <= 0)
            <table class="table table-bordered table-striped">
                <tr>
                    <td class="p-3 text-center">[-] No hay registros.</td>
                </tr>
            </table>
        @else

            <x-table.table class="table-fixed">

                <x-table.table-header
                    :encabezados="['Rol', 'Nombre', 'Descripción', 'Permisos Adjuntos', 'Usuarios', 'Acciones']"
                />

                <tbody>
                    @foreach ($roles as $rol)
                        <tr>
                            <td class="text-gray-900 text-center"> {{ $rol->name }} </td>
                            <td class="text-gray-900 text-center"> {{ $rol->display_name }} </td>
                            <td class="text-gray-900 text-center"> {{ $rol->description }} </td>
                            <td class="text-center">
                                <div class="hov-dropdown p-2">
                                    <button class="dropbtn" data-toggle="dropdown" aria-expanded="true">
                                        <span class="badge badge-primary badge-pill">
                                            {{ $rol->permissions_count }}
                                        </span>
                                    </button>
                                    <ul class="hov-dropdown-content dropdown-menu hov-dropdown-menu animated fadeIn hidden-caret"
                                        aria-labelledby="dropdownMenu_Parroquia_{{ $rol->id }}"
                                        id="dropdownMenu_Parroquia_{{ $rol->id }}">
                                        <li class="text-center">
                                            <button type="button" wire:click="detallePermisos({{ $rol->id }})"
                                                class="mr-2 btn btn-icon btn-round btn-primary btn-border icon-eye btn-show-detail"
                                                title="Ver permisos adjuntos">
                                            </button>
                                            <button type="button" wire:click="adjuntarPermiso({{ $rol->id }})"
                                                class="btn btn-icon btn-round btn-primary btn-border icon-pin"
                                                title="Adjuntar un permiso">
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="hov-dropdown p-2">
                                    <button class="dropbtn" data-toggle="dropdown" aria-expanded="true">
                                        <span class="badge badge-primary badge-pill">
                                            {{ $rol->users_count }}
                                        </span>
                                    </button>
                                    <ul class="hov-dropdown-content dropdown-menu hov-dropdown-menu animated fadeIn hidden-caret"
                                        aria-labelledby="dropdownMenu_Parroquia_{{ $rol->id }}"
                                        id="dropdownMenu_Parroquia_{{ $rol->id }}">
                                        <li class="text-center">
                                            <button type="button" wire:click="detalleUsuarios({{ $rol->id }})"
                                                class="mr-2 btn btn-icon btn-round btn-primary btn-border icon-eye btn-show-detail"
                                                title="Ver usuarios con el rol">
                                            </button>
                                            <button type="button" wire:click="adjuntarUsuario({{ $rol->id }})"
                                                class="btn btn-icon btn-round btn-primary btn-border icon-pin"
                                                title="Adjuntar un usuario">
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <x-table.td-action>
                                <x-boton.boton-action class="icon-note" title="Editar"
                                    wire:click="$emit('editRol',({{ $rol->id }}))">
                                </x-boton.boton-action>
                                <x-boton.boton-action class="icon-trash" title="Eliminar"
                                    wire:click="deleteConfirm({{ $rol->id }})">
                                </x-boton.boton-action>
                            </x-table.td-action>
                        </tr>
                        @if ($rol_name == $rol->name)
                            <tr>
                                @if ($is_permiso)
                                    <x-table.td-detalle id="rol-{{ $loop->index }}" colspan="6" >
                                        {{ $permisos_roles }}
                                    </x-table.td-detalle>
                                @else
                                    <x-table.td-detalle id="permiso-{{ $loop->index }}" colspan="6" >
                                        {{ $usuarios_roles }}
                                    </x-table.td-detalle>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>

            </x-table.table>

            <div class="card-footer justify-center">
                {{ $roles->links() }}
            </div>
        @endif
    </div>
</div>

