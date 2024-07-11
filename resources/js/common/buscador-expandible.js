const btn_busqueda = document.getElementById('btn-busqueda');

   if(btn_busqueda){
    btn_busqueda.addEventListener('click', e => {

        e.preventDefault();

        const input_search = document.getElementById('input-search');

        if(input_search.classList.contains('hidden')){
            input_search.classList.toggle('w-0');
            input_search.classList.toggle('hidden');
        }else{
            const search_form = document.getElementById('search-form');

            if(search_form.buscar.value == ''){
                input_search.classList.toggle('w-0');
                input_search.classList.toggle('hidden');
            }
        }

    });
}
