import swal from 'sweetalert2';

window.addEventListener('errorAlert', e => {
    swal.fire({
        icon: 'error',
        title: e.detail.title,
        html: e.detail.message,
        imageWidth: 48,
        imageHeight: 48,
        width: 300,
        confirmButtonColor: '#1269db',
        confirmButtonClass: "btn btn-primary btn-border btn-round border"
    });
});

//evento para cambiar estatus de un registro
window.addEventListener('changeConfirm', e => {
    swal.fire({
        title: e.detail.title,
        imageWidth: 48,
        imageHeight: 48,
        html: e.detail.message,
        showCloseButton: true,
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, eliminar",
        confirmButtonClass: "btn btn-primary btn-border btn-round border",
        cancelButtonClass: "btn btn-danger btn-border btn-round border",
        cancelButtonColor: "#d33",
        confirmButtonColor: "#3085d6",
        width: 300,
        allowOutsideClick: false
    }).then( result => {
        if(result.value){
            const modulo = e.detail.modulo ? e.detail.modulo + ':changeStatus'  : 'changeStatus';
            window.livewire.emit(modulo, e.detail.id);
        }
    } );
});

window.addEventListener('aprobarConfirm', e => {
    swal.fire(
        {
            title: e.detail.title,
            imageWidth: 48,
            imageHeight: 48,
            html: e.detail.message,
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, aprobar",
            confirmButtonClass: "btn btn-primary btn-border btn-round border",
            cancelButtonClass: "btn btn-danger btn-border btn-round border",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            width: 300,
            allowOutsideClick: false
        }
    ).then( result => {
        if(result.value){
            const modulo = e.detail.modulo ? e.detail.modulo + ':aprobarData'  : 'aprobarData';
            window.livewire.emit(modulo, e.detail.id);
        }
    } );
});

window.addEventListener('rechazarConfirm', e => {
    swal.fire(
        {
            title: e.detail.title,
            imageWidth: 48,
            imageHeight: 48,
            html: e.detail.message,
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, rechazar",
            confirmButtonClass: "btn btn-primary btn-border btn-round border",
            cancelButtonClass: "btn btn-danger btn-border btn-round border",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            width: 300,
            allowOutsideClick: false
        }
    ).then( result => {
        if(result.value){
            const modulo = e.detail.modulo ? e.detail.modulo + ':rechazarData'  : 'rechazarData';
            window.livewire.emit(modulo, e.detail.id);
        }
    } );
});

window.addEventListener('anularConfirm', e => {
    swal.fire(
        {
            title: e.detail.title,
            imageWidth: 48,
            imageHeight: 48,
            html: e.detail.message,
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, anular",
            confirmButtonClass: "btn btn-primary btn-border btn-round border",
            cancelButtonClass: "btn btn-danger btn-border btn-round border",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            width: 300,
            allowOutsideClick: false
        }
    ).then( result => {
        if(result.value){
            const modulo = e.detail.modulo ? e.detail.modulo + ':anularData'  : 'anularData';
            window.livewire.emit(modulo, e.detail.id);
        }
    } );
});

window.addEventListener('reversarConfirm', e => {
    swal.fire(
        {
            title: e.detail.title,
            imageWidth: 48,
            imageHeight: 48,
            html: e.detail.message,
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, reversar",
            confirmButtonClass: "btn btn-primary btn-border btn-round border",
            cancelButtonClass: "btn btn-danger btn-border btn-round border",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            width: 300,
            allowOutsideClick: false
        }
    ).then( result => {
        if(result.value){
            const modulo = e.detail.modulo ? e.detail.modulo + ':reversarData'  : 'reversarData';
            window.livewire.emit(modulo, e.detail.id);
        }
    } );
});

window.addEventListener('enviarConfirm', e => {
    swal.fire(
        {
            title: e.detail.title,
            imageWidth: 48,
            imageHeight: 48,
            html: e.detail.message,
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, enviar",
            confirmButtonClass: "btn btn-primary btn-border btn-round border",
            cancelButtonClass: "btn btn-danger btn-border btn-round border",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            width: 300,
            allowOutsideClick: false
        }
    ).then( result => {
        if(result.value){
            const modulo = e.detail.modulo ? e.detail.modulo + ':enviarData'  : 'enviarData';
            window.livewire.emit(modulo, e.detail.id);
        }
    } );
});

window.addEventListener('aceptarConfirm', e => {
    swal.fire(
        {
            title: e.detail.title,
            imageWidth: 48,
            imageHeight: 48,
            html: e.detail.message,
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, aceptar",
            confirmButtonClass: "btn btn-primary btn-border btn-round border",
            cancelButtonClass: "btn btn-danger btn-border btn-round border",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            width: 300,
            allowOutsideClick: false
        }
    ).then( result => {
        if(result.value){
            const modulo = e.detail.modulo ? e.detail.modulo + ':aceptarData'  : 'aceptarData';
            window.livewire.emit(modulo, e.detail.id);
        }
    } );
});

window.addEventListener('reversarConfirm', e => {
    swal.fire(
        {
            title: e.detail.title,
            imageWidth: 48,
            imageHeight: 48,
            html: e.detail.message,
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, reversar",
            confirmButtonClass: "btn btn-primary btn-border btn-round border",
            cancelButtonClass: "btn btn-danger btn-border btn-round border",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            width: 300,
            allowOutsideClick: false
        }
    ).then( result => {
        if(result.value){
            const modulo = e.detail.modulo ? e.detail.modulo + ':reversarData'  : 'reversarData';
            window.livewire.emit(modulo, e.detail.id);
        }
    } );
});

window.addEventListener('recibidaConfirm', e => {
    swal.fire(
        {
            title: e.detail.title,
            imageWidth: 48,
            imageHeight: 48,
            html: e.detail.message,
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, recibir",
            confirmButtonClass: "btn btn-primary btn-border btn-round border",
            cancelButtonClass: "btn btn-danger btn-border btn-round border",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            width: 300,
            allowOutsideClick: false
        }
    ).then( result => {
        if(result.value){
            const modulo = e.detail.modulo ? e.detail.modulo + ':recibidaData'  : 'recibidaData';
            window.livewire.emit(modulo, e.detail.id);
        }
    } );
});
