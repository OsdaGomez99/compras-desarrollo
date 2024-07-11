<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <a href="/">
                <x-jet-authentication-card-logo />
            </a>
        </x-slot>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <div class="mb-4 text-sm text-gray-600 text-justify">
            {{ __('¿Olvidaste tu contraseña? No hay problema. Simplemente háganos saber su dirección de correo electrónico y le enviaremos un enlace de restablecimiento de contraseña que le permitirá elegir una nueva.') }}
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <x-honeypot/>

            <div class="block">
                <x-jet-label for="email" value="{{ __('Correo Electrónico') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus />
            </div>

            <div class="flex items-center justify-center mt-4">
                <button type="submit"
                    class="bg-blue-600 text-white rounded-md px-4 py-2 uppercase font-semibold text-xs tracking-widest hover:bg-blue-700 active:bg-blue-900 active:shadow active:shadow-blue-300">
                    Enviar enlace para restablecer la contraseña
                </button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
