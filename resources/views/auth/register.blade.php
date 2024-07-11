<x-jet-validation-errors class="mb-4" />

    <form method="POST" class="p-4" action="{{ route('user.registro') }}">
        @csrf

        <div>
            <x-jet-label for="name" value="Nombre" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
        </div>

        <div class="mt-4">
            <x-jet-label for="cedula" value="Cédula"/>
                <select name="nacionalidad" class="mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                    <option value="v">V</option>
                    <option value="e">E</option>
                    <option value="p">P</option>
                </select>
                <x-jet-input id="cedula" class="mt-1 w-auto" type="text" name="cedula" :value="old('cedula')" required/>
        </div>

        <div class="mt-4">
            <x-jet-label for="username" value="Usuario" />
            <x-jet-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required />
        </div>

            <div class="mt-4">
                <x-jet-label for="telefono" value="Teléfono"/>
                <x-jet-input id="telefono" class="block mt-1 w-full" type="tel" name="telefono" :value="old('telefono')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="Correo electrónico" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <small> * La contraseña es el numero de cédula del usuario </small>
            </div>

            <div class="card-footer mt-4">
                <a class="btn btn-danger float-right inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" href="{{route('user.table')}}">
                        Cancelar
                </a>
                <x-jet-button class="btn btn-primary">
                        Guardar
                </x-jet-button>
            </div>

        </form>
