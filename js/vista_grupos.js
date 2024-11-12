function grupos(){
    window.location.href="../admin/panel_grupos.php";
}

document.addEventListener('DOMContentLoaded', function(){
    getData(1,1);
    document.getElementById('grupo').addEventListener('change', function(){
        getData(1,1);
    });
});

function getData(pageAlumnos, pageMaterias){
    let grupo = document.getElementById("grupo").value;
    let maestra = document.getElementById("asignado");
    let content = document.getElementById("contentA");
    let paginacion = document.getElementById("pagina-table");
    let content2 = document.getElementById("contentM");
    let paginacion2 = document.getElementById("pagina-table2");
    let url = "../php/mostrar_grupo.php";
    let formData = new FormData();
    formData.append('grupo',grupo);
    formData.append('pageAlumnos', pageAlumnos);
    formData.append('pageMaterias', pageMaterias);

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data=>{
        maestra.value = data.maestra;
        content.innerHTML = data.tabla;
        paginacion.innerHTML = data.paginacion;
        content2.innerHTML = data.tabla2;
        paginacion2.innerHTML = data.paginacion2;
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

