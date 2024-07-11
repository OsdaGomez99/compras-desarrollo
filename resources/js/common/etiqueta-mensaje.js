const crearContenedorMensaje = (tipo_alerta, e) => {

    const card = document.getElementById('card-main');

    const contenedor_mensaje = document.createElement('div');
    contenedor_mensaje.classList.add('alert', tipo_alerta, 'fade', 'show');
    contenedor_mensaje.setAttribute('role', 'alert');
    contenedor_mensaje.innerHTML = e.detail.mensaje;

    const boton_cerrar = document.createElement('button');
    boton_cerrar.classList.add('close');
    boton_cerrar.setAttribute('data-dismiss', 'alert');
    boton_cerrar.setAttribute('aria-label', 'close');

    const span = document.createElement('span');
    span.setAttribute('aria-hidden', 'true');
    span.textContent = "x";

    boton_cerrar.append(span);

    contenedor_mensaje.append(boton_cerrar);

    card.prepend(contenedor_mensaje);

}

document.addEventListener('messageSuccess', e => {

    crearContenedorMensaje('alert-success', e);

});

document.addEventListener('messageError', e => {

    crearContenedorMensaje('alert-danger', e);

});
