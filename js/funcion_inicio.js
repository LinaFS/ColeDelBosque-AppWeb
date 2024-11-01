document.addEventListener("DOMContentLoaded", function() {
    const modal = document.querySelector("#modal");
    const CerrarModal = document.querySelector("#cerrarSesion");
    const pass= document.getElementById("pass");
    const icon= document.getElementById("imgVerContrasena");
    // Obtiene el valor del parámetro de consulta "origen" de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const origen = urlParams.get("origen");

    // Agrega un event listener al botón de cerrar modal
    CerrarModal.addEventListener("click", () => {
        // Redirige al usuario a la página de origen
        if (origen) {
            window.location.href = origen + ".html";
        } else {
            // Si no se especificó la página de origen, redirige a una página predeterminada
            window.location.href = "index.html";
        }
    });

    icon.addEventListener("click", (e) => {
        if(pass.type==="password"){
            pass.type="text";
        }else{
            pass.type="password";
        }
    });

});

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

// Llamar a la función cuando se cargue la página
document.addEventListener('DOMContentLoaded', mostrarModal);