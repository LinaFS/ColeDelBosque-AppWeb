<?php
include 'conexion.php';

// Obtener el grado y las materias del formulario
$grado = $_POST['grado'];
$materias = json_decode($_POST['materias'], true);

if (empty($materias)) {
    echo json_encode(['success' => false, 'message' => '¡Rellena todos los campos!']);
    exit;
}

$sql = "SELECT * FROM grupo WHERE grado = '$grado'";
$resultado = mysqli_query($conexion, $sql);
if (mysqli_num_rows($resultado) > 0) {
    echo json_encode(['success' => false, 'message' => 'Ya existe ese grupo']);
    exit;
} else {
    $sql = "INSERT INTO grupo (grado) VALUES ('$grado')";
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado) {
        $grupo_id = mysqli_insert_id($conexion);
        $inserted = true;
        foreach ($materias as $materia) {
            $sql = "INSERT INTO materia (nombre, grupo_id) VALUES ('$materia', '$grupo_id')";
            $resultado = mysqli_query($conexion, $sql);
            if (!$resultado) {
                $inserted = false; // Marcar como fallido si alguna inserción falla
                break; // Salir del bucle en caso de error
            }
        }
        if ($inserted) {
            echo json_encode(['success' => true, 'message' => '¡Se ha creado el grupo y las materias!']);
            exit;
        } else {
            // Si alguna inserción falló, eliminar el grupo creado
            $sql = "DELETE FROM grupo WHERE id = '$grupo_id'"; // Asegúrate de que tienes el ID del grupo
            mysqli_query($conexion, $sql);
            echo json_encode(['success' => false, 'message' => 'Error, no se pudo insertar algunas materias']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo crear el grupo']);
        exit;
    }
}
?>