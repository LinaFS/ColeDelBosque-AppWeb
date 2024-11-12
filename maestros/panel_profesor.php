<?php
session_start();
if (isset($_SESSION["permiso"]) != "2") {
    session_destroy();
    header("Location: ../index.html");
}

$user = $_SESSION['usuario'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/maestros.css">
    <link rel="icon" href="../img/logo.png">
    <script src="../js/maestros.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Panel de maestros - Colegio del bosque</title>
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
        <div class="panelTitle2">
            <h1>¡Te damos la bienvenida <?php echo htmlspecialchars($user) ?>!</h1>
            <h2>Alumnos inscritos en tu grupo</h2>
        </div>

        <div class="alumni">
            <form class="filtrosAlumni">
                <div class="mat">
                    <p>Filtrar por matrícula:</p>
                    <input type="text" id="matricula" name="matricula">
                </div>
                <div class="mat">
                    <p>Filtrar por nombre:</p>
                    <input type="text" id="nombre" name="nombre">
                </div>
            </form>
        </div>

        <div class="movContent">
                <table class="table-desktop2" id="movimientos-table">
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Nombre completo</th>
                        </tr>

                    </thead>
                    <tbody id="contentT">

                    </tbody>
                </table>
                <div id="pagina-table" class="pagination">

                </div>
        </div>
    </main>
    <footer>
        <div class="footerContent">
            <img src="../img/logo.png">
        </div>
    </footer>
</body>

</html>