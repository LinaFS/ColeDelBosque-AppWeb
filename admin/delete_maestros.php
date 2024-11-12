<?php
    include '../php/conexion.php';
    include '../php/crypto.php';

    session_start();
    if(isset($_SESSION["permiso"])!="1"){
        session_destroy();
        header("Location: ../index.html");
    }

    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conexion, $_GET['id']);
        $sql = "SELECT cuenta.id_cuenta, cuenta.matricula, usuario.nombre, usuario.paterno, usuario.materno, COALESCE(grupo.grado, 'No asignado') AS grado
            FROM cuenta
            LEFT JOIN usuario ON cuenta.usuario_id = usuario.id_usuario
            LEFT JOIN grupo ON cuenta.grupo_id = grupo.id_grupo
            WHERE cuenta.id_cuenta = '$id'";
            $resultado = mysqli_query($conexion,$sql);
            if(mysqli_num_rows($resultado)>0){
                $row = mysqli_fetch_assoc($resultado);
                $matricula = decrypt($row['matricula']);
                $nombre = $row['nombre'];
                $paterno = $row['paterno'];
                $materno = $row['materno'];
                $grupo = $row['grado'];
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
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/maestros.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/logo.png">
    <title>Editar Alumnos - Colegio del bosque</title>
</head>
<body>
    <dialog id="warning">
        <p id="mensaje"><?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ''; ?></p>
        <div class="btnModal">
            <button id="btnAcept">Aceptar</button>
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
        <div class="panelTitle">
            <h1>Estás en la sección de alumnos</h1>
            <h2>Editar un alumno</h2>
        </div>
        <div class="alumni">
            <form class="alumniForm" action="../php/maestros_delete.php" method="post" id="eliminar">
                <p>Nombre</p>
                <input type="text" name="nombre" disabled value="<?php echo htmlspecialchars($nombre) ?>">
                <p>Apellido Paterno</p>
                <input type="text" name="paterno" disabled value="<?php echo htmlspecialchars($paterno) ?>">
                <p>Apellido Materno</p>
                <input type="text" name="materno" disabled value="<?php echo htmlspecialchars($materno) ?>">
                <p>Grado asignado</p>
                <input type="text" name="aGrado" disabled value="<?php echo htmlspecialchars($grupo) ?>">
                <p>Matrícula</p>
                <input type="text" name="matricula" disabled value="<?php echo htmlspecialchars($matricula) ?>">
                <input type="hidden" name="id_cuenta" value="<?php echo htmlspecialchars($id); ?>">
                <button type="button" onclick="modal('eliminar')">Eliminar</button>
            </form>
        </div>
        <div class="back" onclick="maestros()">
            <img src="../img/admin/regresar.png">
            <p>Regresar al panel de maestros</p>
        </div>
    </main>
    <footer>
        <div class="footerContent">
            <img src="../img/logo.png">
        </div>
    </footer>
</body>
</html>