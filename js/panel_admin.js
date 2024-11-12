function alumnos(){
    window.location.href="../admin/panel_alumno.php";
}

function maestros(){
    window.location.href="../admin/panel_maestros.php";
}

function grupos(){
    window.location.href="../admin/panel_grupos.php";
}

function finanzas(){
    window.location.href="../admin/finanzas.php";
}

function backPanel(){
    window.location.href="../paneldecontrol.php";
}

function addAlumni(){
    window.location.href="../admin/alumnos.php";
}

function addMaestro(){
    window.location.href="../admin/maestros.php";
}

function viewGrup(){
    window.location.href="../admin/vista_grupos.php";
}

function addGrup(){
    window.location.href="../admin/añadir_grupos.php";
}

function modGrup(){
    window.location.href="../admin/editar_grupos.php";
}

function delGrup(){
    window.location.href="../admin/delete_grupos.php";
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

const materiasArray = [];


function sendData() {
    const form = document.getElementById('addGroupForm');
    const formData = new FormData(form); // Obtener los datos del formulario

    //Añadir las materias
    formData.append('materias',JSON.stringify(materiasArray));

    fetch('../php/addGroup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Aquí puedes manejar la respuesta del servidor
        document.getElementById('mensaje').innerText = data.message; // Muestra el mensaje en el diálogo
        document.getElementById('warning').showModal(); // Muestra el diálogo
        if (data.success) {
            materiasArray.length = 0; // Limpiar el array
            const notis = document.getElementById('noti');
            while (notis.firstChild) {
                notis.removeChild(notis.firstChild); // Eliminar notificaciones
            }
            notis.style.display = 'none'; // Ocultar notis
        }
    })
    .catch(error => console.error('Error:', error)); // Manejar errores
}



document.addEventListener("DOMContentLoaded", function (){
    const $form = document.getElementById('addGroupForm');
    const $notis = document.getElementById('noti');
    const $btnAdd = document.getElementById('agregar');

    const templateElement = data => {
        return (`<span class="close-noti">x</span>
                <strong> Materia agregada:&nbsp</strong> ${data}
                `)
    }

    $btnAdd.addEventListener('click', (event) =>{

        event.preventDefault();
        const materiaValue = $form.materia.value.trim();
        if(!materiaValue){
            mostrarModal("Ingresa una materia");
        }else{
            const $div = document.createElement("div");
            $div.classList.add("notification");
            $div.innerHTML = templateElement(`${$form.materia.value}`);
            $notis.insertBefore($div, $notis.firstChild);
            $form.reset();
        }

        materiasArray.push(materiaValue);
        $notis.style.display = 'flex';

    });

    $notis.addEventListener('click', function(event) {
        if (event.target.classList.contains('close-noti')) {
            const notificationDiv = event.target.closest('.notification'); // Encontrar el div padre más cercano
            if (notificationDiv) {
                const materiaValue = event.target.nextSibling.textContent.trim(); // Obtener el valor de la materia
                materiasArray.splice(materiasArray.indexOf(materiaValue), 1); // Eliminar del array
                console.log("Materias en el array después de eliminar:", materiasArray); // Mostrar contenido del array después de eliminar
                notificationDiv.remove(); // Eliminar el div de la notificación
                // Opcional: Si quieres ocultar $notis si no hay notificaciones
                if ($notis.children.length === 0) {
                    $notis.style.display = 'none';
                }
            }
        }
    });
});