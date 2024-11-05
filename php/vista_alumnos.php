<?php
include 'conexion.php';
include 'crypto.php';

$limit = 10;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $limit;

$matricula = isset($_POST['matricula']) ? mysqli_real_escape_string($conexion, $_POST['matricula']) : null;
$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($conexion, $_POST['nombre']) : null;
$grupo = isset($_POST['grupo']) ? mysqli_real_escape_string($conexion, $_POST['grupo']) : null;

$where = [];

// Condición para el nombre
if (!empty($nombre)) {
    $nombreParts = explode(' ', trim($nombre));
    if (count($nombreParts) == 3) {
        list($nombre, $paterno, $materno) = $nombreParts;
        $where[] = "usuario.nombre = '$nombre' AND usuario.paterno = '$paterno' AND usuario.materno = '$materno'";
    } else {
        $where[] = "(usuario.nombre LIKE '%$nombre%' OR usuario.paterno LIKE '%$nombre%' OR usuario.materno LIKE '%$nombre%')";
    }
}

// Condición para el campo matrícula
if (!empty($matricula)) {
    $encryptedMatricula = encrypt($matricula);  // Encriptar la matrícula para la búsqueda
    $where[] = "cuenta.matricula = '$encryptedMatricula'";
}

// Condición para el campo grupo (grado)
if ($grupo != "elegir") {
    $where[] = "grupo.grado LIKE '%$grupo%' COLLATE utf8mb4_general_ci";
}

$where[] = "cuenta.permiso_id = 3";


$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Obtener el total de registros
$countSql = "SELECT COUNT(*) AS total
             FROM cuenta 
             LEFT JOIN usuario ON cuenta.usuario_id = usuario.id_usuario
             LEFT JOIN grupo ON cuenta.grupo_id = grupo.id_grupo
             $whereSql";

$countResult = mysqli_query($conexion, $countSql);
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRecords / $limit);

// Obtener los registros
$sql = "SELECT cuenta.id_cuenta, cuenta.matricula, usuario.nombre, usuario.paterno, usuario.materno, 
               COALESCE(grupo.grado, 'No asignado') AS grado
        FROM cuenta 
        LEFT JOIN usuario ON cuenta.usuario_id = usuario.id_usuario
        LEFT JOIN grupo ON cuenta.grupo_id = grupo.id_grupo
        $whereSql
        LIMIT $limit OFFSET $offset";

$resultado = mysqli_query($conexion, $sql);

$tabla = '';
if (mysqli_num_rows($resultado) > 0) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $matriculaDesencriptada = decrypt($row['matricula']);
        $nombreCompleto = $row['nombre'] . ' ' . $row['paterno'] . ' ' . $row['materno'];
        
        $tabla .= '<tr>';
        $tabla .= '<td>' . htmlspecialchars($matriculaDesencriptada) . '</td>';
        $tabla .= '<td>' . htmlspecialchars($nombreCompleto) . '</td>';
        $tabla .= '<td>' . htmlspecialchars($row['grado']) . '</td>';
        $tabla .= '<td class="iconsT"><a href="../admin/edit_alumnos.php?id=' . urlencode($row['id_cuenta']) . '"><img src="../img/admin/editar.png"></a><a href="../admin/delete_alumnos.php?id=' . urlencode($row['id_cuenta']) . '"><img src="../img/admin/eliminar.png"></a></td>';
        $tabla .= '</tr>';
    }
} else {
    $tabla .= '<tr>';
    $tabla .= '<td colspan="4">Sin resultados</td>';
    $tabla .= '</tr>';
}

// Generar botones de paginación
$pagination = '';
if ($page > 1) {
    $pagination .= '<button onclick="getData(' . ($page - 1) . ')">&laquo;</button>';
}

$maxVisiblePages = 5;
$startPage = max(1, $page - floor($maxVisiblePages / 2));
$endPage = min($totalPages, $startPage + $maxVisiblePages - 1);

if ($endPage - $startPage < $maxVisiblePages - 1) {
    $startPage = max(1, $endPage - $maxVisiblePages + 1);
}

for ($i = $startPage; $i <= $endPage; $i++) {
    $activeClass = ($i === $page) ? 'active' : '';
    $pagination .= '<button class="' . $activeClass . '" onclick="getData(' . $i . ')">' . $i . '</button>';
}

if ($page < $totalPages) {
    $pagination .= '<button onclick="getData(' . ($page + 1) . ')">&raquo;</button>';
}

$response = array(
    'tabla' => $tabla,
    'paginacion' => $pagination 
);

echo json_encode($response);
?>
