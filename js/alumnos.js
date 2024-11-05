document.addEventListener('DOMContentLoaded', function(){
    getData(1);
    getData(1);
    document.getElementById('nombre').addEventListener('keyup', function(){
        getData(1);
    });
    document.getElementById('matricula').addEventListener('keyup', function(){
        getData(1);
    });
    document.getElementById('grupo').addEventListener('change', function(){
        getData(1);
    });
});

function getData(page) {
    let grupo = document.getElementById("grupo").value;
    let matricula = document.getElementById("matricula").value;
    let nombre = document.getElementById("nombre").value;
    let content = document.getElementById("contentT");
    let paginacion = document.getElementById("pagina-table");
    let url = "../php/vista_alumnos.php";
    let formData = new FormData();
    formData.append('grupo', grupo);
    formData.append('matricula', matricula);
    formData.append('nombre', nombre);
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