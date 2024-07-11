import swal from 'sweetalert2';

const btns_eliminar = [...document.querySelectorAll('.btn_eliminar')];

btns_eliminar.forEach( element => {
    element.addEventListener( 'click', e => {
        e.preventDefault();

        swal.fire({
          title: '¿Estas seguro?',
          text: "Esta acción no se podrá revertir",
          icon: 'warning',
          width: '16rem',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, Eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
              if(e.target.tagName.toLowerCase() == "i"){
                e.target.parentNode.parentNode.submit();
              }else {
                  e.target.parentNode.submit();
              }
          }
        })

    } )
}
);

window.addEventListener('deleteConfirm', e => {
    swal.fire(
        {
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
        }
    ).then( result => {
        if(result.value){
            const modulo = e.detail.modulo ? e.detail.modulo + ':deleteData'  : 'deleteData';
            window.livewire.emit(modulo, e.detail.id);
        }
    } );
});

window.addEventListener('notDelete', e => {
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

window.addEventListener('eventSuccess', e => {
    swal.fire({
        icon: 'success',
        title: e.detail.title,
        html: e.detail.message,
        imageWidth: 48,
        imageHeight: 48,
        width: 300,
        confirmButtonColor: '#1269db',
        confirmButtonClass: "btn btn-primary btn-border btn-round border"
    });
});
