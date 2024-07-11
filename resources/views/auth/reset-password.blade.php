<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <a href="/">
                <x-jet-authentication-card-logo />
            </a>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <x-honeypot/>

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-jet-label for="email" value="Correo Electrónico" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="Nueva Contraseña" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="Confirmar Contraseña" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-center mt-4">
                <button type="submit"
                class="bg-blue-700 rounded-md px-4 py-2 uppercase text-xs
                    text-white tracking-widest hover:bg-blue-500 active:bg-blue-900"
                >
                    Reiniciar contraseña
                </button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
