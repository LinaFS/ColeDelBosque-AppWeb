<?php
include 'conexion.php';

$maestra = $_POST['maestra'];
$grupo = $_POST['grado'];
$mensaje = "No se ha eliminado nada";

if ($grupo !== "0") {
    // Eliminar materias del grupo
    $sql = "DELETE FROM materia WHERE grupo_id = $grupo";
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado) {
        $mensaje = "Se han eliminado las materias, ";
    } else {
        $mensaje = "No hay materias que eliminar, ";
    }

    // Si hay una maestra asignada, actualizar su grupo
    if ($maestra !== "Sin asignar") {
        $sql_update = "UPDATE cuenta SET grupo_id = 0 WHERE id_cuenta = $maestra";
        $result = mysqli_query($conexion, $sql_update);
        if ($result) {
            $mensaje .= "se ha desasignado la maestra";
        } else {
            $mensaje .= "el grupo no tenía una maestra";
        }
    }

    // Eliminar el grupo
    $sql = "DELETE FROM grupo WHERE id_grupo = $grupo";
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado) {
        $mensaje .= " y el grupo.";
    } else {
        $mensaje .= ", no se eliminó el grupo.";
    }
} else {
    $mensaje = "Selecciona un grupo";
}

echo json_encode(['success' => true, 'message' => $mensaje]);
exit;
