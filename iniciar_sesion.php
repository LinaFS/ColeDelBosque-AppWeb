
<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width-device-width,user-scalable-no,initial-scale=1.0,maximum-scale=1.0,minimun-scale=1.0">
        <title>Inicio de sesión - Bolsa de trabajo</title>
        <link rel="stylesheet" href="../coledelbosque/css/reset.css">
        <link rel="stylesheet" href="../coledelbosque/css/sesion.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <script src="../coledelbosque/js/funcion_inicio.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    </head>
    <body>
        <dialog id="warning">
            <p id="mensaje"><?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ''; ?></p>
            <div class="btnModal">
                <button id="btnAcept" >Aceptar</button>
            </div>
        </dialog>
        <div class="frase">
            <p>Construyendo <br> un futuro <br> juntos.</p>
        </div>
        <div class="iniciarSesion" id="modal">
            <div class="inicioSesion" id="is">
               <h1>Inicio de Sesión</h1>
               <p class="info">Plataforma de Colegio del Bosque Lerma</p>
               <form action="../coledelbosque/php/inicio_sesion.php" method="POST">
                    <p class="ingresaUsuario">Ingresa el ID</p>
                    <img class="verContra" id="imgVerContrasena" src="../coledelbosque/img/ver.png">
                    <input id="pass" type="password" name="matricula" required> 
                    <p class="olvidaContra" onclick="reestablecerC()">He olvidado la matrícula</p>
                    <button class="ISbtn" id="isbtn" type="submit">Iniciar sesión</button>
               </form>
            </div>
            <form class="recuperacion" id="reestablecerContra" action="#" method="POST">
                
            </form>
            <div class="imgSesion">
                <img class="tache" id="cerrarSesion" src="../coledelbosque/img/close.png" onclick="reset()">
            </div>
            <h1></h1>
        </div>
    </body>
</html>