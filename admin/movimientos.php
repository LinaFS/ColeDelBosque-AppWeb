<?php
    session_start();
    if(isset($_SESSION["permiso"])!="1"){
        session_destroy();
        header("Location: ../coledelbosque/index.html");
    }

    include('../php/conexion.php');
    $sql = "SELECT monto FROM total ORDER BY id_total DESC LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);
    if(mysqli_num_rows($resultado)>0){
        $fila = mysqli_fetch_assoc($resultado);
        $monto = $fila['monto'];
    }else{
        $monto = 0;
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
    <div class="mov" id="movimientos">
        <h1>Movimientos recientes</h1>
        <form id="filtro-form" method="post">
            <div class="filtros">
                <div class="filtro">
                    <p>Filtros</p>
                    <select name="ver" id="ver">
                        <option value="elegir">Todos</option>
                        <option value="hoy">Hoy</option>
                        <option value="semana">Últimos 7 días</option>
                        <option value="mes">Hace 1 mes</option>
                        <option value="hace_tres">Hace 3 meses</option>
                    </select>
                </div>
                <div class="filtro">
                    Personalizado:
                </div>
                <div class="filtro">
                    <p>Fecha desde:</p>
                    <input type="date" name="fecha_desde" id="fecha_desde">
                </div>
                <div class="filtro">
                    <p>Fecha hasta:</p>
                    <input type="date" name="fecha_hasta" id="fecha_hasta">
                </div>
            </div>
        </form>
        <div class="movContent">
            <h2>Monto: $<?php echo number_format($monto, 2); ?></h1>
            <table class="table-desktop" id="movimientos-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Concepto</th>
                        <th>Subcuenta</th>
                        <th>Entradas</th>
                        <th>Salidas</th>
                    </tr>
                </thead>
                <tbody id="contentT">

                </tbody>
            </table>
            <div id="pagina-table" class="pagination">
                
            </div>
        </div>
        <button class="volver" onclick="fView()">Volver al panel de finanzas</button>
    </div>
    </main>
    <footer>
        <div class="footerContent">
            <img src="../img/logo.png">
        </div>
    </footer>
</body>
</html>