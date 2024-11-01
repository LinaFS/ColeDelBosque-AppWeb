<?php

$nombre=$_POST['nombre'];
$tel=$_POST['tel'];
$coment=$_POST['coment'];

$header .= "Content-Type: text/plain";

$mensaje = "¡Hola colegio del bosque!, has recibido un mensaje de: " . $nombre . " de la página web Colegio del Bosque. ¡Contáctate lo más pronto posible!\r\n";
$mensaje .= "Este es su teléfono de contacto: " . $tel . " \r\n";
$mensaje .= "Te ha puesto este comentario: " . $coment . " \r\n";
$mensaje .= "Enviado el: " . date('d/m/Y',time());

$para = 'paufusa123@gmail.com';
$asunto = 'Contacto del sitio web';

if (!mb_check_encoding($mensaje, 'UTF-8')){
    $mensaje = mb_convert_encoding($mensaje, 'UTF-8', 'auto');
}

mail($para, $asunto, $mensaje, $header);

$msj=urlencode("Se ha enviado su respuesta y se comunicarán con usted en breves");
header('Location: ../coledelbosque/contacto.php?mensaje=$msj&modal=true');
exit;
?>