<div id="modal" class="fixed z-10 inset-0 ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <h2 class="text-black fw-bold ml-3 mt-3">
                <b>{{ componentName }}</b>
            </h2>
            <form>
                <div class="bg-white sm:p-6 sm:pb-4">
                    <div class="mt-4" wire:ignore>
