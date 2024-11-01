function toggleMenu() {
    var menu = document.getElementById("menuV");
    var menuButton = document.getElementById("indexMenu");

    // Si el menú está visible, lo oculta; si está oculto, lo muestra
    if (menu.style.display === "flex") {
        menu.style.display = "none";
    } else {
        menu.style.display = "flex";
    }
}

// Evento para abrir/cerrar el menú al hacer clic en el icono del menú
document.getElementById("indexMenu").addEventListener("click", function(event) {
    event.stopPropagation(); // Evita que el clic en el icono cierre el menú
    toggleMenu();
});

// Evento para cerrar el menú al hacer clic fuera del menú
document.addEventListener("click", function(event) {
    var menu = document.getElementById("menuV");
    var menuButton = document.getElementById("indexMenu");

    // Verifica si el clic fue fuera del menú y del icono del menú
    if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
        menu.style.display = "none";
    }
});

// Evita que el menú se cierre si se hace clic dentro del menú
document.getElementById("menuV").addEventListener("click", function(event) {
    event.stopPropagation();
});

function visit(){
    window.location.href="actividades.html";
}

//mensaje personalizado

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