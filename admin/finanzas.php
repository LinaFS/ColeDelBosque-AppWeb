<?php
    session_start();
    if(isset($_SESSION["permiso"])!="1"){
        session_destroy();
        header("Location: ../index.html");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/panel.css">
    <script src="../js/finanzas.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Panel de Control - Colegio del bosque</title>
</head>
<body>
    <dialog id="warning">
        <p id="mensaje"><?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ''; ?></p>
        <div class="btnModal">
            <button id="btnAcept" >Aceptar</button>
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
        <div class="finanzas" id="finanzas">
            <h2>Estás en la sección de tus finanzas personales</h2>
            <div class="contentf">
                <form action="../php/control_fin.php" method="post">
                    <p>Fecha</p>
                    <input type="date" name="fecha" required>
                    <p>Concepto</p>
                    <input type="text" name="concepto" required>
                    <p>Subcuenta</p>
                    <input type="text" name="subcuenta">
                    <p>Entrada</p>
                    <input type="text" name="entrada" placeholder="$">
                    <p>Salida</p>
                    <input type="text" name="salida" placeholder="$">
                    <button type="submit">Enviar</button>
                    <h3 onclick="mView()">Ver movimientos</h3>
                </form>
            </div>
            <div class="buttonback">
                <button onclick="pview()">Regresar al panel</button>
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