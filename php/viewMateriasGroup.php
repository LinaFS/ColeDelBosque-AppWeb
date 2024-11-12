<?php
include 'conexion.php';
include 'crypto.php';

$limit = 5;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $limit;

$grupo = isset($_POST['grupo']) ? mysqli_real_escape_string($conexion, $_POST['grupo']) : null;

// Obtener el total de registros
$countSql = "SELECT COUNT(*) AS total FROM materia WHERE grupo_id='$grupo'";

$countResult = mysqli_query($conexion, $countSql);
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRecords / $limit);

$sql_maestra = "SELECT 
                        usuario.nombre AS nombre, 
                        usuario.paterno AS paterno, 
                        cuenta.id_cuenta AS id_cuenta
                    FROM cuenta
                    LEFT JOIN usuario ON cuenta.usuario_id = usuario.id_usuario
                    WHERE cuenta.permiso_id = 2 AND grupo_id = '$grupo'";
$resultado_maestra = mysqli_query($conexion,$sql_maestra);
if(mysqli_num_rows($resultado_maestra)>0){
    while ($row = mysqli_fetch_assoc($resultado_maestra)) {
        $maestra = $row['nombre']." ".$row['paterno'];
        $id = $row['id_cuenta'];
    }
}else{
    $maestra = "Sin asignar";
    $id = "Sin asignar";
}
// Obtener los registros
$sql = "SELECT id_materia, nombre FROM materia WHERE grupo_id='$grupo' LIMIT $limit OFFSET $offset";

$resultado = mysqli_query($conexion, $sql);

$tabla = '';
if (mysqli_num_rows($resultado) > 0) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        
        $tabla .= '<tr>';
        $tabla .= '<td class="idTd" data-id="' . htmlspecialchars($row['id_materia']) . '">' . htmlspecialchars($row['id_materia']) . '</td>';
        $tabla .= '<td class="nombreTd">' . htmlspecialchars($row['nombre']) . '</td>';
        $tabla .= '<td class="iconsT"><img src="../img/admin/eliminar.png"></td>';
        $tabla .= '</tr>';
    }
} else {
    $tabla .= '<tr>';
    $tabla .= '<td colspan="2">No hay materias</td>';
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
    'paginacion' => $pagination,
    'maestra' => $maestra,
    'id' => $id
);

echo json_encode($response);
?>
