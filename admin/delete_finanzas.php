<?php
    session_start();
    if(isset($_SESSION["permiso"])!="2"){
        session_destroy();
        header("Location: ../index.html");
    }

    include '../php/conexion.php';
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conexion, $_GET['id']);
        $sql = "SELECT * FROM finanzas WHERE id_cuenta='$id'";
        $resultado = mysqli_query($conexion, $sql);
        if(mysqli_num_rows($resultado)){
            $row=mysqli_fetch_assoc($resultado);
            $concepto = $row['concepto'];
            $subcuenta = $row['subcuenta'];
            $fecha = $row["fecha"];
            $entrada = $row['entrada'];
            $salida = $row['salida'];
        }
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
    <dialog id="modal">
        <p>¿Estás seguro de continuar?</p>
        <div class="btnModal">
            <button id="btnCancelar">Cancelar</button>
            <button id="btnAceptar">Aceptar</button>
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
                <h2>Eliminar un registro</h2>
                <div class="contentf">
                    <form action="../php/delete_registro_finanzas.php" method="post">
                        <h2>Registro a Eliminar: </h2>
                        <p>Fecha</p>
                        <input type="date" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>">
                        <p>Concepto</p>
                        <input type="text" name="concepto" value="<?php echo htmlspecialchars($concepto); ?>">
                        <p>Subcuenta</p>
                        <input type="text" name="subcuenta" value="<?php echo htmlspecialchars($subcuenta); ?>">
                        <p>Entrada</p>
                        <input type="text" name="entrada" value="<?php echo htmlspecialchars($entrada); ?>">
                        <p>Salida</p>
                        <input type="text" name="salida" value="<?php echo htmlspecialchars($salida); ?>">
                        <input type="hidden" name="id_cuenta" value="<?php echo htmlspecialchars($id); ?>">
                        <button type="submit">Eliminar</button>
                        <h3 onclick="mView()">Ver movimientos</h3>
                    </form>
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