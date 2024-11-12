function maestros(){
    window.location.href="../admin/panel_maestros.php";
}

function addMaestro(){
    window.location.href="../admin/maestros.php";
}

function backPanel(){
    window.location.href="../paneldecontrol.php";
}

function enviarFormulario(id){
    document.getElementById(id).submit();
}

// lógica para las pantallas de alerta

function modal(id) {
    event.preventDefault();

    const aceptarBtn = document.getElementById('btnAceptar');
    const closeBtn = document.getElementById('btnCancelar');
    const modal = document.querySelector('#modal');

    modal.showModal();

    aceptarBtn.addEventListener('click', () => {
        modal.close();
        enviarFormulario(id);
    });

    closeBtn.addEventListener('click', () => {
        modal.close();
        catalogo();
    });
}

function mostrarModal() {
    
    var urlParams = new URLSearchParams(window.location.search);
    var mensaje = urlParams.get('mensaje');
    var activarModal = urlParams.get('modal');

    if (activarModal === 'true' && mensaje.trim() !== '') {
        var modal = document.getElementById('warning');
        modal.showModal(); // Abre el modal
    }

    // Agregar un evento al botón de Aceptar para cerrar el modal
    document.getElementById('btnAcept').addEventListener('click', function() {
        var modal = document.getElementById('warning');
        modal.close(); // Cierra el modal

       //Elimina el mensaje de la URL
        history.replaceState(null, null, window.location.pathname);
    });
    
}

document.addEventListener('DOMContentLoaded', mostrarModal);

