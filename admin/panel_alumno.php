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
    <script src="../js/panel_admin.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Alumnos - Colegio del bosque</title>
</head>
<body>
    <dialog id="warning">
        <p id="mensaje"><?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ''; ?></p>
        <div class="btnModal">
            <button id="btnAcept">Aceptar</button>
        </div>
    </dialog>
    <header>
        <a href="index.html"><img src="../img/logo.png" alt="Colegio del Bosque"></a>
        <div class="sesion">
            <p><a href="../php/cerrar_sesion.php">Cerrar Sesión</a></p>
            <img src="../img/sesion.png">
        </div>
    </header>
    <main>
        <div class="panelTitle">
            <h2>Panel de control de alumnos</h2>
        </div>
        <div class="alumni">
            <form class="filtrosAlumni">
                <div class="mat">
                    <p>Filtrar por matrícula:</p>
                    <input type="text" name="matricula">
                </div>
                <div class="mat">
                    <p>Filtrar por nombre:</p>
                    <input type="text" name="nombre">
                </div>
                <div class="grup">
                    <p>Filtrar por grupo:</p>
                    <select name="grupo">
                        <option value="Sin seleccionar">Sin seleccionar</option>
                        <option value="1">Primero</option>
                        <option value="2">Segundo</option>
                        <option value="3">Tercero</option>
                        <option value="4">Cuarto</option>
                        <option value="5">Quinto</option>
                        <option value="6">Sexto</option>
                    </select>
                </div>
            </form>
            <div class="materias" onclick="addAlumni()">
                <p>Añadir</p>
                <img src="../img/admin/añadir.png">
            </div>
        </div>
        <div class="movContent">
            <h2> <br><br>Alumnos incritos <br><br></h1>
            <table class="table-desktop" id="movimientos-table">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nombre completo</th>
                        <th>Grado</th>
                    </tr>
                </thead>
                <tbody id="contentA">
                    
                </tbody>
            </table>
        </div>
        <div class="back" onclick="backPanel()">
            <img src="../img/admin/regresar.png">
            <p>Regresar al panel principal</p>
        </div>
    </main>
    <footer>
        <div class="footerContent">
            <img src="../img/logo.png">
        </div>
    </footer>
</body>
</html>