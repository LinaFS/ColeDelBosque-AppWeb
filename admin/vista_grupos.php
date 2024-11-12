<?php
    include '../php/conexion.php';
    include '../php/crypto.php';

    session_start();
    if(isset($_SESSION["permiso"])!="1"){
        session_destroy();
        header("Location: ../index.html");
    }
    $user=$_SESSION["usuario"];
    $sql = "SELECT * FROM grupo ORDER BY FIELD(grado, 'Primero', 'Segundo', 'Tercero', 'Cuarto', 'Quinto', 'Sexto')";;
    $resultado = mysqli_query($conexion, $sql);
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
    <link rel="stylesheet" href="../css/grupos.css">
    <script src="../js/vista_grupos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/logo.png">
    <title> Vista de grupos - Colegio del bosque</title>
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
            <h2>Vista de grupos</h2>
        </div>
        <div class="datos">
            <div class="datosSelect">
                <p>Grupo</p>
                <select name="grupo" id="grupo">
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
            </div>
            <p>Responsable:</p>
            <input type="text" class="asignado" id="asignado" disabled>
        </div>
        <div class="content-viewGrup">
            <div class="movContentViewGrup">
                <h2>Alumnos incritos</h2>
                <table class="table-desktop" id="alumnos-table">
                    <thead>
                        <tr>
                            <th>Nombre completo</th>
                        </tr>
                    </thead>
                    <tbody id="contentA">
                        
                    </tbody>
                </table>
                <div id="pagina-table" class="pagination">
                
                </div>
            </div>
            <div class="movContentViewGrup">
                <h2>Materias registradas</h2>
                <table class="table-desktop" id="materias-table">
                    <thead>
                        <tr>
                            <th>Nombre de la materia</th>
                        </tr>
                    </thead>
                    <tbody id="contentM">
                        
                    </tbody>
                </table>
                <div id="pagina-table2" class="pagination">
                
                </div>
            </div>
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
