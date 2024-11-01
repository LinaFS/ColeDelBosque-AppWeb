<?php
    include '../php/conexion.php';

    date_default_timezone_set('America/Mexico_City');

    $columns = ['id_cuenta','fecha', 'concepto', 'subcuenta', 'entrada', 'salida'];
    $table = "finanzas";

    $limit=10;
    $page=isset($_POST['page'])?(int)$_POST['page']:1;
    $offset=($page - 1) * $limit;

    $concepto = isset($_POST['ver']) ? mysqli_real_escape_string($conexion, $_POST['ver']) : null;
    $fechaDesde = isset($_POST['fecha_desde']) ? mysqli_real_escape_string($conexion, $_POST['fecha_desde']) : null;
    $fechaHasta = isset($_POST['fecha_hasta']) ? mysqli_real_escape_string($conexion, $_POST['fecha_hasta']) : null;

    $where = '';

    $currentDate = date('Y-m-d');

    if($concepto!="elegir"){
        if($concepto === "hoy"){
            $where.= "WHERE fecha ='$currentDate'";
        }elseif ($concepto === 'semana') {
            $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $where .= "WHERE fecha BETWEEN '$sevenDaysAgo' AND '$yesterday'";
        }elseif($concepto === 'mes'){
            $firstDayOfLastMonth = date('Y-m-01', strtotime('-1 month'));
            // Calcula el último día del mes pasado
            $lastDayOfLastMonth = date('Y-m-t', strtotime('-1 month'));
            // Aplica la condición para el mes pasado
            $where .= "WHERE fecha BETWEEN '$firstDayOfLastMonth' AND '$lastDayOfLastMonth'";
        }elseif ($concepto === 'hace_tres') {
            $firstDayOfCurrentMonth = date('Y-m-01');
            // Calcula el primer día del mes 3 meses atrás
            $firstDayOfThreeMonthsAgo = date('Y-m-01', strtotime('-3 months'));
            // Calcula el último día del mes 3 meses atrás
            $lastDayOfThreeMonthsAgo = date('Y-m-t', strtotime('-3 months'));
            // Aplica la condición para los últimos 3 meses excluyendo el mes actual
            $where .= "WHERE fecha BETWEEN '$firstDayOfThreeMonthsAgo' AND '$lastDayOfThreeMonthsAgo'";
        }

    }

    if($fechaDesde!=null&&$fechaHasta!=null){
        $where = "WHERE fecha BETWEEN '$fechaDesde' AND '$fechaHasta'";
    }

    $countSql="SELECT COUNT(*) as total from $table $where";
    $countResult=mysqli_query($conexion,$countSql);
    $totalRecords=mysqli_fetch_assoc($countResult)['total'];
    $totalPages=ceil($totalRecords/$limit);

    $sql = "SELECT " . implode(", ", $columns) . " FROM $table $where LIMIT $limit OFFSET $offset";
    $resultado = mysqli_query($conexion, $sql);
    if (!$resultado) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }
    
    $num_rows = mysqli_num_rows($resultado);
    
    $tabla = '';

    if ($num_rows > 0) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $tabla .= '<tr>';
            $tabla .= '<td>' . $row['fecha'] . '</td>';
            $tabla .= '<td>' . $row['concepto'] . '</td>';
            $tabla .= '<td>' . $row['subcuenta'] . '</td>';
            $tabla .= '<td>' . $row['entrada'] . '</td>';
            $tabla .= '<td>' . $row['salida'] . '</td>';
            $tabla .= '<td class="iconsT"><a href="../admin/edit_finanzas.php?id='.urlencode($row['id_cuenta']).'"><img src="../img/admin/editar.png"></a><a href="../admin/delete_finanzas.php?id='.urlencode($row['id_cuenta']).'"><img src="../img/admin/eliminar.png"></a></td>';
            $tabla .= '</tr>';
        }
    } else {
        $tabla .= '<tr>';
        $tabla .= '<td colspan="6">Sin resultados</td>';
        $tabla .= '</tr>';
    }

    $pagination = '';

    // Botón "Anterior"
    if ($page > 1) {
        $pagination .= '<button onclick="getData(' . ($page - 1) . ')">&laquo;</button>';
    }

    // Rango de botones a mostrar (puedes ajustar $maxVisiblePages según lo que necesites)
    $maxVisiblePages = 5;
    $startPage = max(1, $page - floor($maxVisiblePages / 2));
    $endPage = min($totalPages, $startPage + $maxVisiblePages - 1);

    if ($endPage - $startPage < $maxVisiblePages - 1) {
        $startPage = max(1, $endPage - $maxVisiblePages + 1);
    }

    for ($i = $startPage; $i <= $endPage; $i++) {
        $activeClass = ($i === $page) ? 'active' : ''; // Aplica la clase 'active' a la página actual
        $pagination .= '<button class="' . $activeClass . '" onclick="getData(' . $i . ')">' . $i . '</button>';
    }

    // Botón "Siguiente"
    if ($page < $totalPages) {
        $pagination .= '<button onclick="getData(' . ($page + 1) . ')">&raquo;</button>';
    }
    
    $response = array(
        'tabla' => $tabla,           // Aquí se envía el HTML de la tabla
        'paginacion' => $pagination  // Aquí se envía el HTML de la paginación
    );
    
    // Devolver la respuesta en formato JSON
    echo json_encode($response);
?>
