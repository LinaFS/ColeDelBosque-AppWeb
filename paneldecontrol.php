<?php
    session_start();
    if(isset($_SESSION["permiso"])!="1"){
        session_destroy();
        header("Location: index.html");
    }
    $user=$_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../coledelbosque/css/reset.css">
    <link rel="stylesheet" href="../coledelbosque/css/style.css">
    <link rel="stylesheet" href="../coledelbosque/css/panel.css">
    <script src="../coledelbosque/js/panel_admin.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Panel de Control - Colegio del bosque</title>
</head>
<body>
    <header>
        <a href="index.html"><img src="../coledelbosque/img/logo.png" alt="Colegio del Bosque"></a>
        <div class="sesion">
            <p><a href="../coledelbosque/php/cerrar_sesion.php">Cerrar Sesión</a></p>
            <img src="../coledelbosque/img/sesion.png">
        </div>
    </header>
    <main>
        <div class="panelTitle">
            <h1>Hola <?php echo htmlspecialchars($user);?></h1>
            <h2>¿Qué vamos a hacer hoy?</h2>
        </div>
        <div class="panel">
            <div class="secciones" onclick="alumnos()">
                <img src="../coledelbosque/img/admin/alumnos.png">
                <p>Gestión <br>Alumnos</p>
            </div>
            <hr>
            <div class="secciones" onclick="maestros()">
                <img src="../coledelbosque/img/admin/mestros.png">
                <p>Gestión <br>Mestros</p>
            </div>
            <hr>
            <div class="secciones" onclick="grupos()">
                <img src="../coledelbosque/img/admin/grupos.png">
                <p>Gestión <br>Grupos</p>
            </div>
            <hr>
            <div class="secciones" onclick="finanzas()">
                <img src="../coledelbosque/img/admin/finanzas.png">
                <p>Gestión <br>Finanzas</p>
            </div>
        </div>
    </main>
    <footer>
        <div class="footerContent">
            <img src="../coledelbosque/img/logo.png">
        </div>
    </footer>
</body>
</html>