<?php
include 'conexion.php';

$maestra = $_POST['maestra'];
$id_maestra = $_POST['id_maestra'];
$grupo = $_POST['grado'];
$nuevoGrupo = isset($_POST['gradoNuevo']) ? $_POST['gradoNuevo'] : 'actual';
$mensaje = "Cambios aplicados: ";
$n = 0;


if (isset($_POST['materias'])) {
    $materias = json_decode($_POST['materias'], true);
} else {
    $materias = [];
}

if (isset($_POST['materiasEliminar'])) {
    $materiasEliminar = json_decode($_POST['materiasEliminar'], true);
} else {
    $materiasEliminar = [];
}


if(!empty($materias) && $grupo !== "0"){
    // Insertar nuevas materias
    foreach ($materias as $materia) {
        $materia = mysqli_real_escape_string($conexion, $materia);
        $sql = "INSERT INTO materia (nombre, grupo_id) VALUES ('$materia', '$grupo')";
        $result = mysqli_query($conexion, $sql);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Error al agregar materias']);
            exit;
        } else {
            $n += 1;
        }
    }
    $mensaje .= "se agregaron $n materias, ";
}

// Eliminar materias especificadas
if (!empty($materiasEliminar)) {
    foreach ($materiasEliminar as $materia) {
        $id_materia = intval($materia['id']); // Accede a 'id' en cada objeto
        $sql = "DELETE FROM materia WHERE id_materia = $id_materia";
        $result = mysqli_query($conexion, $sql);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar las materias']);
            exit;
        } else {
            $n += 1;
        }
    }
    $mensaje .= "se eliminaron $n materias, ";
}


// Desasignar la maestra actual
if ($grupo !== "0") {
    if($id_maestra !=="Sin asignar"){
        $sql_update = "UPDATE cuenta SET grupo_id = 0 WHERE id_cuenta = $id_maestra";
        $result = mysqli_query($conexion, $sql_update);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Error al modificar la maestra anterior']);
            exit;
        }else{
            $n += 1;
        }
    }
    // Asignar nueva maestra al grupo
    if($maestra!== "actual"){
        $sql = "UPDATE cuenta SET grupo_id = $grupo WHERE id_cuenta = $maestra";
        $result = mysqli_query($conexion, $sql);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'No se pudo asignar nueva maestra al grupo']);
            exit;
        } else {
            $n += 1;
            $mensaje .= " Se actualizó la maestra asignada, ";
        }
    }
}

// Actualizar el nombre del grupo
if ($grupo !== "0" && $nuevoGrupo !== "actual") {
    $sql = "UPDATE grupo SET nombre = '$nuevoGrupo' WHERE id_grupo = $grupo";
    $result = mysqli_query($conexion, $sql);
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el grupo']);
        exit;
    } else {
        $n += 1;
        $mensaje .= "Se ha cambiado el grupo ";
    }
}

// Mensaje final
if ($n == 0) {
    echo json_encode(['success' => false, 'message' => 'No hay cambios']);
} else {
    echo json_encode(['success' => false, 'message' => $mensaje]);
}
exit;
?>
