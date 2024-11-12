<?php
include 'conexion.php';
include 'crypto.php';

$id = $_POST['id_cuenta'];
$nombre = $_POST['nombre'];
$paterno = $_POST['paterno'];
$materno = $_POST['materno'];
$grado = $_POST['grado'];
$matricula = encrypt($_POST['matricula']);

$sql = "SELECT usuario_id FROM cuenta WHERE id_cuenta = '$id'";
$resultado = mysqli_query($conexion,$sql);
if(mysqli_num_rows($resultado)>0){
    $row = mysqli_fetch_assoc($resultado);
    $usuario_id = $row['usuario_id'];
}

$sql = "UPDATE usuario SET nombre='$nombre', paterno='$paterno', materno='$materno' WHERE id_usuario='$usuario_id'";
$resultado = mysqli_query($conexion,$sql);
if($resultado){
    if($grado !== "0"){
        $sql = "UPDATE cuenta SET matricula='$matricula', grupo_id='$grado' WHERE id_cuenta = $id";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $mensaje=urldecode("Se ha actualizado la información");
            header("Location: ../admin/panel_maestros.php?mensaje=$mensaje&modal=true");
            exit;
        }else{
            $mensaje=urldecode("No se ha actualizado la cuenta");
            header("Location: ../admin/panel_maestros.php?mensaje=$mensaje&modal=true");
            exit;
        }
    }else{
        $sql = "UPDATE cuenta SET matricula='$matricula' WHERE id_cuenta = $id";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $mensaje=urldecode("Se ha actualizado la información");
            header("Location: ../admin/panel_maestros.php?mensaje=$mensaje&modal=true");
            exit;
        }else{
            $mensaje=urldecode("No se ha actualizado la cuenta");
            header("Location: ../admin/panel_maestros.php?mensaje=$mensaje&modal=true");
            exit;
        }
    }
}else{
    $mensaje=urldecode("No se ha actualizado el usuario");
        header("Location: ../admin/panel_maestros.php?mensaje=$mensaje&modal=true");
        exit;
}



