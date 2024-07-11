<form id="search-form" class="navbar-left navbar-form nav-search mr-md-3" action="#">
    <div class="input-group bg-white btn-round">
        <input wire:model.debounce.500ms="busqueda" name="buscar" id="input-search"
        type="text" placeholder="Buscar..."
        class="btn-round border-blue-300 focus:border-indigo-300
        focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm {{ isset($busqueda) ? '' : 'w-0 hidden' }}">
        <div class="input-group-prepend">
            <button id="btn-busqueda" type="submit" class="fa fa-search btn text-blue-500 ">
            </button>
        </div>
    </div>
</form>
