<div>
    <x-jet-validation-errors class="mt-4 mx-4 mb-2" />

    @if (session('success'))
        <x-session-alert type="success">
            {{ session('success') }}
        </x-session-alert>
    @endif

    <form method="POST" class="px-4 pb-4 pt-2" wire:submit.prevent="save" >

        @csrf

        <div>
            <x-jet-label for="name" value="Nombres y Apellidos" />
            <x-jet-input wire:model.lazy="name" id="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name')" required autofocus />
        </div>

        <div class="mt-4">
            <x-jet-label for="cedula" value="Cédula" />
            <select wire:model.defer="nacionalidad" name="nacionalidad"
                class="mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                required>
                <option value="v">V</option>
                <option value="e">E</option>
                <option value="p">P</option>
            </select>
            <x-jet-input wire:model.defer="numero_cedula" id="cedula" class="mt-1 w-auto" type="text" name="cedula"
                :value="old('cedula')" required />
        </div>

        @unless($mode_edit)
            <div class="mt-4">
                <x-jet-label for="username" value="Usuario" />
                <div class="h-11 mt-1 pt-2 px-3 pb-3 border border-gray-400 rounded-md shadow-sm font-bold">
                    {{ $username ?? 'El usuario sera generado por el sistema' }}
                </div>
            </div>
        @endunless

        <div class="mt-4">
            <x-jet-label for="email" value="Correo electrónico" />
            <x-jet-input wire:model.defer="email" id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required />
        </div>
        <div class="mt-4" wire:ignore>
            <x-jet-label for="roles" value="Roles" />
            <div x-data="selectRoles" x-init="cargarOpciones()" x-on:reset-select.window="resetearSelect"
                class="rounded-md border" wire:key="roles">
                <!-- Select -->
                <div id="select" class="flex justify-between bg-transparent border h-10">
                    <div class="flex flex-wrap gap-1 justify-between">
                        <template x-for="[id, value] in Object.entries(seleccionados)" :key="id">
                            <div class="flex items-center gap-2 m-1 p-2 rounded-md bg-gray-200 text-sm text-slate-600 h-7"
                                x-bind:data-value="value.value">
                                <span x-text="value.texto"></span>
                                <span class="cursor-pointer" @click="removerSeleccionados($el)">&#215;</span>
                            </div>
                        </template>
                    </div>
                    <div class="flex gap-2 items-center">
                        <template x-if="existenSeleccionados()">
                            <button type="button" class="rounded-full cursor-pointer text-blue-600 text-xl"
                                @click="resetearSelect()">x</button>
                        </template>
                        <div class="p-2 bg-gray-200 text-xl select-none" @click="toggleOpen()" x-html="flecha">
                            &#709;
                        </div>
                    </div>
                </div>

                <!-- Buscador -->
                <input placeholder="Busqueda..." type="search" x-show="open" x-cloak x-model="search"
                    class="border-4 w-full border-gray-300 p-2">

                <!-- Opciones -->
                <div x-show="open" x-cloak>
                    <template x-for="[id, value] in Object.entries(searchResults)" :key="id">
                        <div @click="agregarElemento($el)" x-bind:data-value="value.value" x-text="value.texto"
                            class="p-2 hover:bg-gray-200 text-slate-700"></div>
                    </template>
                </div>
            </div>
        </div>
        <div class="mt-4" wire:ignore>
            <x-jet-label for="permisos" value="Permisos" />
            <div
                x-data="selectPermisos"
                x-init="cargarOpciones()"
                x-on:reset-select.window="resetearSelect"
                x-on:reset-select-permisos.window="actualizarPermisos"
                @if ($mode_edit)
                    x-on:init-select-permisos.window="inicializarSeleccionados"
                @endif
                class="rounded-md border"
                wire:key="permisos"
                id="selectPermiso"
            >
                <!-- Select -->
                <div id="select" class="flex justify-between bg-transparent border h-10">
                    <div class="flex flex-wrap gap-1 justify-between">
                        <template x-for="[id, value] in Object.entries(seleccionados)" :key="id">
                            <div class="flex items-center gap-2 m-1 p-2 rounded-md bg-gray-200 text-sm text-slate-600 h-7"
                                x-bind:data-value="value.value">
                                <span x-text="value.texto"></span>
                                <span class="hover:cursor-pointer" @click="removerSeleccionados($el)">&#215;</span>
                            </div>
                        </template>
                    </div>
                    <div class="flex gap-2 items-center">
                        <template x-if="existenSeleccionados()">
                            <button type="button" class="rounded-full cursor-pointer text-blue-600 text-xl"
                                @click="resetearSelect()">x</button>
                        </template>
                        <div class="p-2 bg-gray-200 text-xl select-none" @click="toggleOpen()" x-html="flecha">
                            &#709;
                        </div>
                    </div>
                </div>

                <!-- Buscador -->
                <input placeholder="Busqueda..." type="search" x-show="open" x-cloak x-model="search"
                    class="border-4 w-full border-gray-300 p-2">

                <!-- Opciones -->
                <div x-show="open" x-cloak>
                    <template x-for="[id, value] in Object.entries(searchResults)" :key="id">
                        <div @click="agregarElemento($el)" x-bind:data-value="value.value" x-text="value.texto"
                            class="p-2 hover:bg-gray-200 text-slate-700"></div>
                    </template>
                </div>
            </div>
        </div>
        <div>
            <div class="mt-2">
                <details class="bg-info rounded p-2 text-white font-bold text-base">
                    <summary class="mb-2">
                        Permisos que adquiere el usuario por los roles seleccionados
                        ({{ count($display_permisos_roles) }})
                    </summary>
                    <div class="grid grid-cols-6 text-center">
                        @foreach ($display_permisos_roles as $permisos_roles)
                            <p class="pl-2 text-base"> {{ $permisos_roles }} </p>
                        @endforeach
                    </div>
                </details>
            </div>
        </div>

        @if (!$mode_edit)
            <div class="mt-4">
                <x-jet-label for="password" value="Contraseña" />
                <div class="h-11 mt-1 pt-2 px-3 pb-3 border border-gray-400 rounded-md shadow-sm">
                    La contraseña es el número de cédula del usuario (sin la v).
                </div>
            </div>
        @endif

        <div class="card-footer flex justify-between mt-4">
            @if ($mode_edit)
                <button type="button" wire:click="resetearPassword"
                    class="btn btn-info btn-border btn-round border px-4 py-2">Resetear Contraseña</button>
            @else
                <x-boton.boton-cancelar wire:click="limpiarForm">Limpiar Campos</x-boton.boton-cancelar>
            @endif
            <x-boton.boton-aceptar wire:click="save">
                @if ($mode_edit)
                    Modificar
                @else
                    Guardar
                @endif
            </x-boton.boton-aceptar>
        </div>

    </form>
    <button class="bg-blue-500 rounded-md p-2 text-white" id="prueba">Prueba</button>
    @push('scripts')
        <script>

            const btn_prueba = document.getElementById('prueba');
            btn_prueba.addEventListener('click', () => {
                window.dispatchEvent(new CustomEvent('init-select-permisos'));
            });


            window.addEventListener('reiniciarSelects', () => {
                window.dispatchEvent(new CustomEvent('reset-select'));
            });

            window.addEventListener('reiniciarSelectPermisos', () => {
                window.dispatchEvent(new CustomEvent('reset-select-permisos'));
            });

            document.addEventListener('alpine:init', () => {

                Alpine.data('selectRoles', () => ({

                    opciones: [],
                    seleccionados: [],
                    search: '',
                    open: false,
                    flecha: '&#709;',

                    get searchResults() {
                        return this.opciones.filter(
                            i => i.texto.includes(this.search)
                        )
                    },

                    cargarOpciones() {
                        this.opciones = this.$wire.roles;
                    },

                    agregarElemento(el) {

                        const data = {
                            texto: el.textContent,
                            value: el.dataset.value
                        };

                        this.seleccionados.push(data);

                        this.actualizarWireRoles();

                        this.removerElemento(el);
                    },

                    actualizarWireRoles() {

                        roles_values = this.seleccionados.map(el => {
                            return el.value;
                        });

                        this.$wire.roles_seleccionados = roles_values;
                    },

                    removerElemento(el) {
                        this.opciones = this.opciones.filter(element => {
                            return element.value != el.dataset.value;
                        });
                    },

                    removerSeleccionados(el) {
                        const parentElement = el.parentElement;
                        const texto = parentElement.querySelector("[x-text]").textContent;
                        const valor = parentElement.dataset.value;

                        this.opciones.push({
                            texto: texto,
                            value: valor
                        });

                        this.opciones.sort((a, b) => {
                            if (a.texto < b.texto) {
                                return -1;
                            } else if (a.texto > b.texto) {
                                return 1;
                            } else {
                                return 0;
                            }
                        });

                        this.seleccionados = this.seleccionados.filter(element => {
                            return element.value != valor;
                        });

                        this.actualizarWireRoles();
                    },

                    toggleOpen() {
                        this.open = !this.open;
                        if (this.open) {
                            this.flecha = '&#708;';
                        } else {
                            this.flecha = '&#709;';
                        }
                    },

                    existenSeleccionados() {
                        return this.seleccionados.length > 0;
                    },

                    resetearSelect() {
                        this.seleccionados = [];
                        this.actualizarWireRoles();
                        this.cargarOpciones();
                    }

                }));

                Alpine.data('selectPermisos', () => ({

                    opciones: [],
                    seleccionados: [],
                    search: '',
                    open: false,
                    flecha: '&#709;',

                    get searchResults() {
                        return this.opciones.filter(
                            i => i.texto.includes(this.search)
                        )
                    },

                    cargarOpciones() {
                        this.opciones = this.$wire.permisos;
                    },

                    agregarElemento(el) {

                        const data = {
                            texto: el.textContent,
                            value: el.dataset.value
                        };

                        this.seleccionados.push(data);

                        this.actualizarWirePermisos();

                        this.removerElemento(el);
                    },

                    actualizarWirePermisos() {

                        permisos_values = this.seleccionados.map(el => {
                            return el.value;
                        });

                        this.$wire.permisos_seleccionados = permisos_values;
                    },

                    removerElemento(el) {
                        this.opciones = this.opciones.filter(element => {
                            return element.value != el.dataset.value;
                        });
                    },

                    removerSeleccionados(el) {
                        const parentElement = el.parentElement;
                        const texto = parentElement.querySelector("[x-text]").textContent;
                        const valor = parentElement.dataset.value;

                        this.opciones.push({
                            texto: texto,
                            value: valor
                        });

                        this.opciones.sort((a, b) => {
                            if (a.texto < b.texto) {
                                return -1;
                            } else if (a.texto > b.texto) {
                                return 1;
                            } else {
                                return 0;
                            }
                        });

                        this.seleccionados = this.seleccionados.filter(element => {
                            return element.value != valor;
                        });
                    },

                    toggleOpen() {
                        this.open = !this.open;
                        if (this.open) {
                            this.flecha = '&#708;';
                        } else {
                            this.flecha = '&#709;';
                        }
                    },

                    existenSeleccionados() {
                        return this.seleccionados.length > 0;
                    },

                    resetearSelect() {
                        this.seleccionados = [];
                        this.actualizarWirePermisos();
                        this.cargarOpciones();
                    },

                    actualizarPermisos() {

                        permisos_name = this.$wire.permisos.map(permiso => {
                            return permiso.name ?? permiso.value;
                        });

                        if (permisos_name.length == 0) {
                            this.seleccionados = [];
                        }

                        this.opciones = this.$wire.permisos;
                    },

                    inicializarSeleccionados() {
                        const component = document.getElementById('selectPermiso');
                        console.log(this.$wire.permisos_usuario.map( item => {
                            return item.value;
                        } ));
                        [...component.querySelectorAll('[data-value]')].forEach( item => {
                            item.click();
                        } );
                    }

                }))

            });
        </script>
    @endpush

</div>
