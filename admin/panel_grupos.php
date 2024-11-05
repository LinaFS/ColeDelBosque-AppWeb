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
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/panel_admin.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/logo.png">
    <title>Panel de grupos - Colegio del bosque</title>
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
            <h1>Panel de control de grupo</h1>
            <h2>Administración de grupo</h2>
        </div>
        <div class="contentGrup">
            <div class="add" onclick="addGrup()">
                <h2>Añadir</h2>
                <img src="../img/admin/añadir.png">
            </div>
            <div class="mod" onclick="modGrup()">
                <h2>Modificar</h2>
                <img src="../img/admin/editar.png">
            </div>
            <div class="del">
                <h2>Eliminar</h2>
                <img src="../img/admin/eliminar.png">
            </div>
        </div>
        <p class="view" onclick="viewGrup()">Vista previa</p>
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