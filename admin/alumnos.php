<?php
    include '../php/conexion.php';
    session_start();
    if(isset($_SESSION["permiso"])!="1"){
        session_destroy();
        header("Location: ../index.html");
    }
    $user=$_SESSION["usuario"];
    $sql = "SELECT * FROM grupo";
    $resultado = mysqli_query($conexion, $sql);
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
            <h1>Estás en la sección de alumnos</h1>
            <h2>Añadir un alumno</h2>
        </div>
        <div class="alumni">
            <form class="alumniForm" action="../php/alumni_altas.php" method="post">
                <p>Nombre</p>
                <input type="text" name="nombre" required>
                <p>Apellido Paterno</p>
                <input type="text" name="paterno" required>
                <p>Apellido Materno</p>
                <input type="text" name="materno" required>
                <p>Grado</p>
                <select name="grado" class="gradeSelect">
                    <?php if (mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                            <option value="<?php echo $row['id_grupo']; ?>">
                                <?php echo htmlspecialchars($row['grado']); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="no">No disponibles</option>
                    <?php endif; ?>
                </select>
                <p>Matrícula</p>
                <input type="text" name="matricula" required>
                <button type="submit">Enviar</button>
                <h3 onclick="alumnos()">Vista previa</h3>
            </form>
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