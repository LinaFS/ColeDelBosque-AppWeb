<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/grupos.css">
    <script src="../js/panel_admin.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/logo.png">
    <title>Crear grupo - Colegio del bosque</title>
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
            <h2>Edición de grupo</h2>
        </div>
        <div class="contentGrupEdit">
            <form id="modGroupForm" action="../php/addGroup.php" class="addGrup-content">
                <div class="content-form">
                    <p>Seleccionar grado</p>
                    <select name="grado">
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
                    <option value="seleccionar">Sin seleccionar</option>
                </select>
                </div>
            </form>
            <div class="table-classes">
            <p>Materias</p>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sin asignar</td>
                        <td class="iconsT">
                            <img src="../img/admin/eliminar.png">
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <div class="btnEditGrup"><button>Editar</button><p onclick="viewGrup()">Vista de grupos</p></div>
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