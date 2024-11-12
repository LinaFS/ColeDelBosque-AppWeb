function viewGrup() {
    window.location.href = "../admin/vista_grupos.php";
}

function grupos() {
    window.location.href = "../admin/panel_grupos.php";
}

function enviarFormulario() {
    sendData();
}

const materiasEliminarArray = [];

function modal() {
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

function sendData() {
    const form = document.getElementById('delGroupForm');
    const formData = new FormData(form);

    formData.append('maestra', document.getElementById("maestra-a").value);
    formData.append('grado', document.getElementById("grupoSelect").value);
    formData.append('materiasEliminar', JSON.stringify(materiasEliminarArray));

    fetch('../php/delGroup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('mensaje').innerText = data.message;
        document.getElementById('warning').showModal();
    })
    .catch(error => console.error('Error:', error));
}


document.addEventListener('DOMContentLoaded', function () {
    getData(1);
    getData(1);
    document.getElementById('grupoSelect').addEventListener('change', function () {
        getData(1);
    });
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
        
        document.querySelectorAll(".iconsT img").forEach(function (icon) {
            icon.style.visibility="hidden";
        });
        
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
