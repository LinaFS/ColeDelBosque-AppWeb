function viewGrup() {
    window.location.href = "../admin/vista_grupos.php";
}

function grupos() {
    window.location.href = "../admin/panel_grupos.php";
}

function enviarFormulario() {
    sendData();
}

const materiasArray = [];
const materiasEliminarArray = [];

function modal(id) {
    event.preventDefault();

    const aceptarBtn = document.getElementById('btnAceptar');
    const closeBtn = document.getElementById('btnCancelar');
    const modal = document.querySelector('#modal');

    modal.showModal();

    aceptarBtn.addEventListener('click', () => {
        modal.close();
        enviarFormulario();
    });

    closeBtn.addEventListener('click', () => {
        modal.close();
    });
}

function mostrarModal() {
    var urlParams = new URLSearchParams(window.location.search);
    var mensaje = urlParams.get('mensaje');
    var activarModal = urlParams.get('modal');

    if (activarModal === 'true' && mensaje.trim() !== '') {
        var modal = document.getElementById('warning');
        modal.showModal();
    }

    document.getElementById('btnAcept').addEventListener('click', function () {
        var modal = document.getElementById('warning');
        modal.close();
        history.replaceState(null, null, window.location.pathname);
        window.location.reload();
    });
}

document.addEventListener('DOMContentLoaded', mostrarModal);


document.addEventListener("DOMContentLoaded", function (){
    const $form = document.getElementById('modGroupForm');
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

function sendData() {
    const form = document.getElementById('modGroupForm');
    const formData = new FormData(form);

    formData.append('maestra', document.getElementById("maestra").value);
    formData.append('grado', document.getElementById("grupoSelect").value);
    formData.append('gradoNuevo', document.getElementById("newGrade").value);
    formData.append('materias', JSON.stringify(materiasArray));
    formData.append('materiasEliminar', JSON.stringify(materiasEliminarArray));

    fetch('../php/modGroup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('mensaje').innerText = data.message;
        document.getElementById('warning').showModal();
        if (data.success) {
            materiasArray.length = 0;
            materiasEliminarArray.length = 0;
            const notis = document.getElementById('noti');
            while (notis.firstChild) {
                notis.removeChild(notis.firstChild);
            }
            notis.style.display = 'none';
        } else {
            console.error("No se pudo redirigir, revise los parámetros de respuesta:", data);
        }
    })
    .catch(error => console.error('Error:', error));
}


document.addEventListener('DOMContentLoaded', function () {
    getData(1);
    getData(1);
    document.getElementById('grupoSelect').addEventListener('change', function () {
        getData(1);
    });
    document.querySelectorAll(".iconsT img").forEach(function (icon) {
        icon.addEventListener("click", function () {
            const materiaId = this.closest("tr").querySelector(".idTd").getAttribute("data-id");
            const materiaNombre = this.closest("tr").querySelector(".nombreTd").textContent.trim(); // Suponiendo que el nombre está en una celda con clase 'nombreTd'
    
            console.log("ID de la materia capturado:", materiaId); // Verifica en la consola si se captura el ID
            
            if (materiaId && !materiasEliminarArray.some(materia => materia.id === materiaId)) {
                // Agregar a la lista de materias a eliminar
                materiasEliminarArray.push({ id: materiaId, nombre: materiaNombre });
    
                // Crear notificación para la materia a eliminar
                const $divEliminar = document.createElement("div");
                $divEliminar.classList.add("notification");
                $divEliminar.innerHTML = templateEliminarElement(materiaNombre); // Usamos el nombre aquí
    
                $notis.insertBefore($divEliminar, $notis.firstChild);
                console.log("Materias marcadas para eliminar:", materiasEliminarArray);
                $notis.style.display = 'flex';
            }
        });
    });
    
    
    const templateEliminarElement = data => {
        return (`<span class="close-noti">x</span>
                <strong>Materia a eliminar:&nbsp</strong> ${data}`);
    };
});

function getData(page) {
    let grupo = document.getElementById("grupoSelect").value;
    let content = document.getElementById("contentT");
    let paginacion = document.getElementById("pagina-table");
    let maestra = document.getElementById("maestra-a");
    let id_maestra = document.getElementById("id_maestra");
    let url = "../php/viewMateriasGroup.php";
    let formData = new FormData();
    formData.append('maestra',maestra);
    formData.append('id_maestra',id_maestra);
    formData.append('grupo', grupo);
    formData.append('page', page);

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        maestra.value = data.maestra;
        id_maestra.value = data.id;
        content.innerHTML = data.tabla;
        paginacion.innerHTML = data.paginacion;
        updatePaginationButtons(page);
        const $notis = document.getElementById('noti');
        
        document.querySelectorAll(".iconsT img").forEach(function (icon) {
            icon.addEventListener("click", function () {
                const materiaId = this.closest("tr").querySelector(".idTd").getAttribute("data-id");
                const materiaNombre = this.closest("tr").querySelector(".nombreTd").textContent.trim(); // Suponiendo que el nombre está en una celda con clase 'nombreTd'
        
                console.log("ID de la materia capturado:", materiaId); // Verifica en la consola si se captura el ID
                
                if (materiaId && !materiasEliminarArray.some(materia => materia.id === materiaId)) {
                    // Agregar a la lista de materias a eliminar
                    materiasEliminarArray.push({ id: materiaId, nombre: materiaNombre });
        
                    // Crear notificación para la materia a eliminar
                    const $divEliminar = document.createElement("div");
                    $divEliminar.classList.add("notification");
                    $divEliminar.innerHTML = templateEliminarElement(materiaNombre); // Usamos el nombre aquí
        
                    $notis.insertBefore($divEliminar, $notis.firstChild);
                    console.log("Materias marcadas para eliminar:", materiasEliminarArray);
                    $notis.style.display = 'flex';
                }
            });
        });
        

        const templateEliminarElement = data => {
            return (`<span class="close-noti">x</span>
                    <strong>Materia a eliminar:&nbsp</strong> ${data}`);
        };
        
    }).catch(err => console.log(err));
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
