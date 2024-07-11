@extends('./layouts/app')

@section('titulo', ' - Configurar Usuario')

@section('titulo-pagina', 'Información de Usuario')

@section('descripcion-pagina', 'Actualiza la información de tu usuario.')

@section('contenido')

@if (session('exito'))
    <div class="alert alert-success">
        {{ session('exito') }}
    </div>
@endif

<form class="p-4" method="POST" action="{{route('user.configuracion')}}">

    <x-jet-validation-errors class="mb-4" />

    @csrf

    <fieldset class="border border-solid border-gray-300 p-3">
        <legend class="text-base">Datos del usuario</legend>
        <div>
            <x-jet-label for="email" value="Correo electrónico" />
            <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
        </div>

        <div class="mt-4">
            <x-jet-label for="telefono" value="Teléfono" />
            <x-jet-input id="telefono" class="block mt-1 w-full" type="tel" name="telefono" :value="old('telefono')" />
            <x-jet-input-error for="telefono" class="mt-2" />
        </div>
    </fieldset>

    <fieldset class="mt-4 border border-solid border-gray-300 p-3">
        <legend class="text-base">Cambiar contraseña</legend>
        <div>
            <x-jet-label for="current_password" value="Contraseña actual" />
            <x-jet-input id="current_password" class="block mt-1 w-full" type="password" name="current_password" :value="old('current_password')" />
        </div>

        <div class="mt-4">
            <x-jet-label for="password" value="Nueva contraseña" />
            <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" />
        </div>

        <div class="mt-4">
            <x-jet-label for="password_confirmation" value="Confirmar contraseña" />
            <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
        </div>
    </fieldset>

    <div class="flex items-center justify-end mt-4">
        <x-jet-button class="ml-4">
            Actualizar
        </x-jet-button>
    </div>

</form>

@endsection
