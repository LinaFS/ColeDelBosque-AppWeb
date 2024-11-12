<?php
include 'conexion.php';

$id = $_POST['id_cuenta'];

$sql = "SELECT usuario_id FROM cuenta WHERE id_cuenta='$id'";
$resultado = mysqli_query($conexion,$sql);
if(mysqli_num_rows($resultado)>0){
    $row = mysqli_fetch_assoc($resultado);
    $usuario_id = $row['usuario_id'];

    $sql = "DELETE FROM cuenta WHERE id_cuenta='$id'";
    $resultado = mysqli_query($conexion,$sql);
    if($resultado){
        $sql = "DELETE FROM usuario WHERE id_usuario='$usuario_id'";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $mensaje=urldecode("Se ha eliminado el registro");
            header("Location: ../admin/panel_maestros.php?mensaje=$mensaje&modal=true");
            exit;
        }
    }else{
        $mensaje=urldecode("No se ha podido eliminar el registro");
        header("Location: ../admin/panel_maestros.php?mensaje=$mensaje&modal=true");
        exit;
    }
}else{
    $mensaje=urldecode("Advertencia, no se obtuvo el id de usuario (usuario_id)");
        header("Location: ../admin/panel_maestros.php?mensaje=$mensaje&modal=true");
        exit;
}
