<?php

include 'conexion.php';

$limit = 5;
$pageAlumnos = isset($_POST['pageAlumnos']) ? (int)$_POST['pageAlumnos'] : 1;
$pageMaterias = isset($_POST['pageMaterias']) ? (int)$_POST['pageMaterias'] : 1;
$offsetAlumnos = ($pageAlumnos - 1) * $limit;
$offsetMaterias = ($pageMaterias - 1) * $limit;

$grupo = isset($_POST['grupo']) ? mysqli_real_escape_string($conexion, $_POST['grupo']) : null;

$countSql = "SELECT COUNT(*) AS total FROM materia WHERE grupo_id='$grupo'";
$countSql2 = "SELECT COUNT(*) AS total
                FROM cuenta
                LEFT JOIN usuario ON cuenta.usuario_id = usuario.id_usuario
                WHERE cuenta.permiso_id = 3 AND grupo_id = '$grupo'";

$countResult = mysqli_query($conexion, $countSql);
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRecords / $limit);

$countResult2 = mysqli_query($conexion, $countSql2);
$totalRecords2 = mysqli_fetch_assoc($countResult2)['total'];
$totalPages2 = ceil($totalRecords2 / $limit);

$sql_maestra = "SELECT 
                        usuario.nombre AS nombre, 
                        usuario.paterno AS paterno,
                        usuario.materno AS materno, 
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

$sql = "SELECT 
            usuario.nombre AS nombre, 
            usuario.paterno AS paterno, 
            cuenta.id_cuenta AS id_cuenta
        FROM cuenta
        LEFT JOIN usuario ON cuenta.usuario_id = usuario.id_usuario
        WHERE cuenta.permiso_id = 3 AND grupo_id = '$grupo' 
        LIMIT $limit OFFSET $offsetAlumnos";
$sql2 = "SELECT id_materia, nombre FROM materia WHERE grupo_id='$grupo' LIMIT $limit OFFSET $offsetMaterias";

$resultado = mysqli_query($conexion, $sql);
$resultado2 = mysqli_query($conexion, $sql2);

//plantear la primera tabla (alumnos inscritos)
$tabla = '';
if (mysqli_num_rows($resultado) > 0) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $tabla .= '<tr>';
        $tabla .= '<td>' . $row['nombre']." ".$row['paterno'] . '</td>';
        $tabla .= '</tr>';
    }
} else {
    $tabla .= '<tr>';
    $tabla .= '<td colspan="1">No hay inscritos</td>';
    $tabla .= '</tr>';
}

//Segunda tabla (materiasS)
$tabla2 = '';
if (mysqli_num_rows($resultado2) > 0) {
    while ($row = mysqli_fetch_assoc($resultado2)) {
        $tabla2 .= '<tr>';
        $tabla2 .= '<td>' . $row['nombre']. '</td>';
        $tabla2 .= '</tr>';
    }
} else {
    $tabla2 .= '<tr>';
    $tabla2 .= '<td colspan="1">No hay materias</td>';
    $tabla2 .= '</tr>';
}

//paginación de tabla alumnos

$pagination = '';

    // Botón "Anterior"
    if ($pageAlumnos > 1) {
        $pagination .= '<button onclick="getData(' . ($pageAlumnos - 1) . ')">&laquo;</button>';
    }

    // Rango de botones a mostrar (puedes ajustar $maxVisiblePages según lo que necesites)
    $maxVisiblePages = 5;
    $startPage = max(1, $pageAlumnos - floor($maxVisiblePages / 2));
    $endPage = min($totalPages, $startPage + $maxVisiblePages - 1);

    if ($endPage - $startPage < $maxVisiblePages - 1) {
        $startPage = max(1, $endPage - $maxVisiblePages + 1);
    }

    for ($i = $startPage; $i <= $endPage; $i++) {
        $activeClass = ($i === $pageAlumnos) ? 'active' : ''; // Aplica la clase 'active' a la página actual
        $pagination .= '<button class="' . $activeClass . '" onclick="getData(' . $i . ')">' . $i . '</button>';
    }

    // Botón "Siguiente"
    if ($pageAlumnos < $totalPages) {
        $pagination .= '<button onclick="getData(' . ($pageAlumnos + 1) . ')">&raquo;</button>';
    }

//paginación de tabla materias

$pagination2 = '';

    // Botón "Anterior"
    if ($pageMaterias > 1) {
        $pagination2 .= '<button onclick="getData(' . ($pageMaterias - 1) . ')">&laquo;</button>';
    }

    // Rango de botones a mostrar (puedes ajustar $maxVisiblePages según lo que necesites)
    $maxVisiblePages2 = 5;
    $startPage2 = max(1, $pageMaterias - floor($maxVisiblePages2 / 2));
    $endPage2 = min($totalPages2, $startPage2 + $maxVisiblePages2 - 1);

    if ($endPage2 - $startPage2 < $maxVisiblePages2 - 1) {
        $startPage2 = max(1, $endPage2 - $maxVisiblePages2 + 1);
    }

    for ($f = $startPage2; $f <= $endPage2; $f++) {
        $activeClass2 = ($f === $pageMaterias) ? 'active' : ''; // Aplica la clase 'active' a la página actual
        $pagination2 .= '<button class="' . $activeClass2 . '" onclick="getData(' . $f . ')">' . $f . '</button>';
    }

    // Botón "Siguiente"
    if ($pageMaterias < $totalPages2) {
        $pagination2 .= '<button onclick="getData(' . ($pageMaterias + 1) . ')">&raquo;</button>';
    }

$response = array(
    'tabla' => $tabla,
    'paginacion' => $pagination,
    'tabla2' => $tabla2,
    'paginacion2' => $pagination2,
    'maestra' => $maestra
);

echo json_encode($response);