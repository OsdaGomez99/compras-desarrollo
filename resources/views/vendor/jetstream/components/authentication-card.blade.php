<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div>
        {{ $logo }}
    </div>

    @isset($titulo)
        <p class="text-center text-2xl mt-3 text-gray-700">
            {{ $titulo }}
        </p>
    @endisset

    <div class="lg:w-2/6 sm:w-max md:w-4/6 mt-4 px-6 py-4 bg-white rounded-xl shadow-2xl">
        {{ $slot }}
    </div>
</div>
