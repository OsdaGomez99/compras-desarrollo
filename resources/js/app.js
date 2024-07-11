require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

require('./common/modal-borrar');

require('./compras/alerts-compras');

require('./common/buscador-expandible');

require('./common/etiqueta-mensaje');

require('./common/miscelaneos');

if (window.location.href.includes("/login")) {
    require('./segurity/login');
}

if(window.location.href.includes("/usuarios/create") ||
    (window.location.href.includes('/admin/usuarios') && window.location.href.endsWith('/edit')))
{
    require('./common/select-config');
}



