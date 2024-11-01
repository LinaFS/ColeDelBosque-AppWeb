//función para mostrar finanzas en la tabla

document.addEventListener('DOMContentLoaded', function() {
    getData(1);
    getData(1); // Inicialmente cargar la primera página
    document.getElementById('ver').addEventListener('change', function() {
        getData(1); // Reiniciar a la primera página cuando cambian los filtros
    });
    document.getElementById('fecha_desde').addEventListener('change', function() {
        getData(1); // Reiniciar a la primera página cuando cambia la fecha
    });
    document.getElementById('fecha_hasta').addEventListener('change', function() {
        getData(1); // Reiniciar a la primera página cuando cambia la fecha
    });
});

function getData(page) {
    let input = document.getElementById("ver").value;
    let fechaDesde = document.getElementById("fecha_desde").value;
    let fechaHasta = document.getElementById("fecha_hasta").value;
    let content = document.getElementById("contentT");
    let paginacion = document.getElementById("pagina-table");
    let url = "../php/mostrar_actividad.php";
    let formData = new FormData();
    formData.append('ver', input);
    formData.append('fecha_desde', fechaDesde);
    formData.append('fecha_hasta', fechaHasta);
    formData.append('page', page);

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        content.innerHTML = data.tabla;
        paginacion.innerHTML = data.paginacion;
        updatePaginationButtons(page);
    })
    .catch(err => console.log(err));
}

function updatePaginationButtons(currentPage) {
    const buttons = document.querySelectorAll('.pagination button');
    
    buttons.forEach(button => {
        if (parseInt(button.textContent) === currentPage) {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }
    });
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


// Llamar a la función cuando se cargue la página
document.addEventListener('DOMContentLoaded', mostrarModal);


//función para redirigir a páginas

function mView(){
    window.location.href="../admin/movimientos.php"
}

function fView(){
    window.location.href="../admin/finanzas.php"
}

function pview(){
    window.location.href="../paneldecontrol.php"
}
