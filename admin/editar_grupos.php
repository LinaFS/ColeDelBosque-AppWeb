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
    <script src="../js/grupos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/logo.png">
    <title>Editar grupo - Colegio del bosque</title>
</head>
<body>
    <dialog id="warning">
        <p id="mensaje"><?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ''; ?></p>
        <div class="btnModal">
            <button id="btnAcept">Aceptar</button>
        </div>
    </dialog>
    <dialog id="modal">
        <p>¿Está seguro de aplicar los cambios?</p>
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
            <h2>Edición de grupo</h2>
        </div>
        <div class="contentGrupEdit">
            <form id="modGroupForm" method="post" action="../php/modGroup.php" class="addGrup-content">
                <div class="content-form">
                    <p>Seleccionar grado a modificar</p>
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
                <div class="newGrup-Data">
                    <h2>Modificar Datos:</h2>
                    <div class="newGrup">
                        <div class="content-form">
                            <p>Nuevo grado</p>
                            <select name="gradoNuevo" id="newGrade">
                                <option value="actual">Actual</option>
                                <option value="Primero">Primero</option>
                                <option value="Segundo">Segundo</option>
                                <option value="Tercero">Tercero</option>
                                <option value="Cuarto">Cuarto</option>
                                <option value="Quinto">Quinto</option>
                                <option value="Sexto">Sexto</option>
                            </select>

                        </div>
                        <div class="content-form">
                            <p>Maestra asignada</p>
                            <select name="maestra" id="maestra">
                                <option value="actual">Actual</option>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <option value="<?php echo $row['id_cuenta']; ?>">
                                            <?php echo htmlspecialchars($row['nombre'])." ".htmlspecialchars($row['paterno']); ?>
                                        </option>
                                    <?php endwhile; ?>
                            <?php else: ?>
                                <option value="no">No disponibles</option>
                            <?php endif; ?>
                            </select>
                        </div>
                        <div class="content-form" id="materias">
                            <p>Agregar nueva materia</p>
                            <input type="text" name="materia">
                            <button type="button" id="agregar">+</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-classes">
                <h2>Editar materias</h2>
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
        <div class="btnEditGrup"><button onclick="modal('modGroupForm')">Editar</button><p onclick="viewGrup()">Vista de grupos</p></div>
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