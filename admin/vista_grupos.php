<?php
    session_start();
    if(isset($_SESSION["permiso"])!="1"){
        session_destroy();
        header("Location: ../index.html");
    }
    $user=$_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/panel_admin.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/logo.png">
    <title> Administración de grupo - Colegio del bosque</title>
</head>
<body>
    <dialog id="warning">
        <p id="mensaje"><?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ''; ?></p>
        <div class="btnModal">
            <button id="btnAcept">Aceptar</button>
        </div>
    </dialog>
    <header>
        <a href="../index.html"><img src="../img/logo.png" alt="Colegio del Bosque"></a>
        <div class="sesion">
            <p><a href="../php/cerrar_sesion.php">Cerrar Sesión</a></p>
            <img src="../img/sesion.png">
        </div>
    </header>
    <main>
        <div class="panelTitle">
            <h2>Administración de grupo</h2>
        </div>
        <div class="datos">
            <p>Grupo:</p>
            <p>Responsable:</p>
            <div class="addGrup">
                <p>Añadir materias</p>
                <img src="../img/admin/añadir.png">
            </div>
        </div>

        <!-- Tabla de Alumnos Inscritos -->
        <div class="movContent">
            <h2> <br><br>Alumnos incritos <br><br></h2>
            <table class="table-desktop" id="alumnos-table">
                <thead>
                    <tr>
                        <th>Nombre completo</th>
                    </tr>
                </thead>
                <tbody id="contentA">
                    <tr>
                        <td>Nombre del alumno</td>
                        <td class="iconsT">
                            <img src="../img/admin/eliminar.png" alt="Eliminar">
                            <img src="../img/admin/editar.png" alt="Editar">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Materias Registradas -->
        <div class="movContent">
            <h2> <br><br>Materias registradas <br><br></h2>
            <table class="table-desktop" id="materias-table">
                <thead>
                    <tr>
                        <th>Nombre de la materia</th>
                    </tr>
                </thead>
                <tbody id="contentM">
                    <tr>
                        <td>Nombre de la materia</td>
                        <td class="iconsT">
                            <img src="../img/admin/eliminar.png" alt="Eliminar">
                            <img src="../img/admin/editar.png" alt="Editar">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="back" onclick="grupos()">
            <img src="../img/admin/regresar.png" alt="Regresar">
            <p>Regresar al panel del grupo</p>
        </div>
    </main>
    <footer>
        <div class="footerContent">
            <img src="../img/logo.png" alt="Logo">
        </div>
    </footer>
</body>
</html>