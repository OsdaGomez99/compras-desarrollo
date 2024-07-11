<x-guest-layout>

    <x-jet-authentication-card>

        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-slot name="titulo">
            Sistema de Compras de Bienes y Servicios<span class="text-xs">(version)</span>
        </x-slot>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <x-honeypot/>

            <div>
                <x-jet-label for="username" value="{{ __('Usuario') }}" />
                <input type="text"
                    class="form-control border-gray-300 focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm w-full mt-1"
                    name="username" :value="old('username')" required autofocus>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Constraseña') }}" />
                <input id="password"
                    class="form-control border-gray-300 focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm w-full mt-1"
                    type="password" name="password" required autocomplete="current-password">
            </div>

            <div class="mt-4">
                <div id="captcha_container" class="flex justify-center">
                    {!! captcha_img('flat') !!}
                    <button id="btn_reload" type="button" class="ml-1 rounded h-11 w-10 bg-gray-200 fas fa-redo-alt">
                    </button>
                </div>
                <div class="mt-2 flex justify-center">
                    <input type="text"
                        class="form-control h-8 border-gray-300 focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1"
                        name="captcha" required placeholder="Código de seguridad">
                </div>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">Recuerdame</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                <button type="submit"
                    class="ml-4 bg-blue-700 rounded-md px-4 py-2 uppercase text-xs
                        text-white tracking-widest hover:bg-blue-500 active:bg-blue-900">
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </x-jet-authentication-card>
    @push('scripts')
        <script>
            const btn_reload = document.getElementById('btn_reload');
            const captcha_container = document.getElementById('captcha_container');

            const disableButton = () => {
                btn_reload.disabled = true;
                btn_reload.title = "Espere 2seg antes de pedir el siguiente captcha";
                setTimeout(() => {
                    btn_reload.disabled = false;
                    btn_reload.title = "";
                }, 2000);
            }

            btn_reload.addEventListener('click', async e => {
                await axios.get('/reload_captcha').then(resp => {
                    const captcha = captcha_container.querySelector('img');
                    captcha_container.removeChild(captcha);
                    captcha_container.innerHTML = resp.data.captcha;
                    captcha_container.append(btn_reload);
                    disableButton();
                });
            });
        </script>
    @endpush

</x-guest-layout>
