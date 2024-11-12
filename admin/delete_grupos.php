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

    $sql_maestra = "SELECT 
                        usuario.nombre AS nombre, 
                        usuario.paterno AS paterno, 
                        cuenta.id_cuenta AS id_cuenta
                    FROM cuenta
                    LEFT JOIN usuario ON cuenta.usuario_id = usuario.id_usuario
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
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/grupos.css">
    <script src="../js/del_grupo.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/logo.png">
    <title>Eliminar grupo - Colegio del bosque</title>
</head>
<body>
    <dialog id="warning">
        <p id="mensaje"><?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ''; ?></p>
        <div class="btnModal">
            <button id="btnAcept">Aceptar</button>
        </div>
    </dialog>
    <dialog id="modal">
        <p>¿Está seguro de eliminar el grupo?</p>
        <div class="btnModal">
            <button id="btnCancelar">Cancelar</button>
            <button id="btnAceptar">Aceptar</button>
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
            <h2>Eliminar grupo</h2>
        </div>
        <div class="contentGrupEdit">
            <form id="delGroupForm" method="post" action="../php/delGroup.php" class="addGrup-content">
                <div class="content-form">
                    <p>Seleccionar grado a eliminar</p>
                    <select name="grado" id="grupoSelect">
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
                <div class="content-form">
                    <p>Maestra asignada</p>
                    <input type="text" name="maestraA" id="maestra-a" style="text-align:center;">
                    <input type="text" name="id_maestra" id="id_maestra" style="display:none;">
                </div>
            </form>
            <div class="table-classes">
                <h2>Eliminar materias</h2>
                <table>
                    <thead>
                        <tr>
                            <th class="idTd">Id</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody id="contentT">
                        
                    </tbody>
                </table>
                <div id="pagina-table" class="pagination">
                
                </div>
            </div>
        </div>
        <div class="content-noti" id="noti">
            
        </div>
        <div class="btnEditGrup"><button onclick="modal()">Eliminar</button><p onclick="viewGrup()">Vista de grupos</p></div>
        <div class="back" onclick="grupos()">
            <img src="../img/admin/regresar.png">
            <p>Regresar al panel de grupos</p>
        </div>
    </main>
    <footer>
        <div class="footerContent">
            <img src="../img/logo.png">
        </div>
    </footer>
</body>
</html>