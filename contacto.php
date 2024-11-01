<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../coledelbosque/css/reset.css">
    <link rel="stylesheet" href="../coledelbosque/css/style.css">
    <link rel="stylesheet" href="../coledelbosque/css/contacto.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="../coledelbosque/js/logica.js"></script>
    <link rel="icon" href="../coledelbosque/img/logo.png">
    <title>Contacto - Colegio del Bosque</title>
</head>
<body>
    <header>
        <a href="index.html"><img src="../coledelbosque/img/logo.png" alt="Colegio del Bosque"></a>
        <nav class="menu">
            <span id="indexMenu" class="material-symbols-outlined" onclick="toggleMenu()">menu</span>
            <ul id="menuV">
                <li><a href="../coledelbosque/index.html">Inicio</a></li>
                <li><a href="../coledelbosque/oferta_educativa.html">Oferta educativa</a></li>
                <li><a href="../coledelbosque/contacto.php" class="active">Contacto</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <dialog id="warning">
            <p id="mensaje"><?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ''; ?></p>
            <div class="btnModal">
                <button id="btnAcept">Aceptar</button>
            </div>
        </dialog>
        <div class="containerC">
            <div class="ubicacion">
                <h1>Ubicación</h1>
                <p>Dirección: Privada Serafín Hernández SN, C. Benito Juárez SNI, Adolfo Lopez Mateos, 52030 San Pedro Tultepec, Méx.</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3766.114947476909!2d-99.51624072533004!3d19.277366845621135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cdf5c27a1ed76b%3A0x499ca042bfc9f5be!2sSalida%20de%20Tultepec!5e0!3m2!1ses!2smx!4v1722023698948!5m2!1ses!2smx" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="redes">
                    <h3 class="redes_tl">Nuestras redes sociales:</h3>
                    <div class="redes_iconos">
                        <a href="https://www.facebook.com/profile.php?id=100063510279404&mibextid=ZbWKwL"><img class="facebook" src="../coledelbosque/img/facebook-icon.png"><h1 class="infoCon">Facebook</h1></a>
                        <a href="#"><img class="instagram" src="../coledelbosque/img/Instagram-Icon.png"><h1 class="infoCon">Instagram</h1></a>
                    </div>
                </div>
            </div>
            <div class="contacto">
                <h1 class="titleContact">¡Contáctanos!</h1>
                <h2>* Utilizamos tu información sólo para contactarnos contigo</h2>
                <form method="post" action="../php/mailAction.php">
                    <div class="nombreContacto">
                        <p for="correoelectronico">Nombre completo</p>
                        <input name="nombre" type="text" id="correoelectronico" required placeholder="Nombre Apellido Apellido">
                    </div>
                    <div class="telContacto">
                        <p for="telefono">Teléfono</p>
                        <input name="tel" type="tel" id="telefono" required placeholder="(XX) XXXX-XXXX">
                    </div>
                    <div class="comentContacto">
                        <p for="comentario">Comentario</p>
                        <textarea name="coment" cols="70" rows="10" id="comentario" required></textarea>
                    </div>
                    <div class="btnEnviar">
                        <input type="submit" value="Enviar" class="enviar" required>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <div class="footerContent">
            <img src="../coledelbosque/img/logo.png">
            <div class="footerContact">
                <a href="../coledelbosque/contacto.html"><p><img src="img/whatsapp.png">  7229064022</p></a>
                <a href="../coledelbosque/contacto.php"><p>colegio.del<br>bosque06@gmail.com  <img src="img/gmail.png"></p></a>
            </div>
        </div>
    </footer>
</body>
</html>