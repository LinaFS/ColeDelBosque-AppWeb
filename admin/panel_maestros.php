<?php
    include "../php/conexion.php";
    session_start();
    if(isset($_SESSION["permiso"])!="1"){
        session_destroy();
        header("Location: ../index.html");
    }
    $sql_maestra = "SELECT 
                        usuario.nombre AS nombre, 
                        usuario.paterno AS paterno, 
                        cuenta.matricula AS matricula,
                        cuenta.id_cuenta AS id,
                        grupo.grado AS grupo
                    FROM cuenta
                    LEFT JOIN usuario ON cuenta.usuario_id = usuario.id_usuario
                    LEFT JOIN grupo ON cuenta.grupo_id = grupo.id_grupo
                    WHERE cuenta.permiso_id = 2";
    $result = mysqli_query($conexion,$sql_maestra);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/panel.css">
    <script src="../js/maestros.js"></script>
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
            <h2>Panel de control de maestros</h2>
        </div>
        <div class="añadir-Maestro">
                <p>Añadir</p>
                <img src="../img/admin/añadir.png" onclick="addMaestro()">
            </div>
        </div>
        <div class="movContent">
            <h2> <br><br>Maestros inscritos <br><br></h1>
            <table class="table-desktop" id="movimientos-table">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nombre completo</th>
                        <th>Grado</th>
                    </tr>
                </thead>
                <tbody id="contentM">
                <?php
                    include '../php/crypto.php';
                    if (mysqli_num_rows($result) > 0) {
                        // Recorre los resultados de la consulta y crea una fila para cada registro
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . decrypt($row['matricula']) . "</td>";
                            echo "<td>" . $row['nombre'] . " " . $row['paterno'] . "</td>";
                            echo "<td>" . $row['grupo'] . "</td>";
                            echo '<td class="iconsT"><a href="../admin/editar_maestro.php?id='.urlencode($row['id']).'"><img src="../img/admin/editar.png"></a><a href="../admin/delete_maestros.php?id='.urlencode($row['id']).'"><img src="../img/admin/eliminar.png"></a></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No hay maestros registrados.</td></tr>";
                    }
                    ?>
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