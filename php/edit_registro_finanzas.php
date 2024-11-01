<?php
    include '../php/conexion.php';
    $id = $_POST['id_cuenta'];
    $nwfecha = $_POST['fecha'];
    $nwconcepto = $_POST['concepto'];
    $nwsubcuenta = $_POST['subcuenta'];
    $e = $_POST['entrada'];
    $s = $_POST['salida'];

    $sql="SELECT * FROM finanzas WHERE id_cuenta=$id";
    $resultado=mysqli_query($conexion,$sql);
    if(mysqli_num_rows($resultado)>0){
        while($row=mysqli_fetch_assoc($resultado)){
            $entrada=floatval($row['entrada']);
            $salida=floatval($row['salida']);
        }
    }
    //Actualizar los valores monetarios para la cuenta final
    $sql = "SELECT monto, id_total FROM total WHERE cuenta_id >= $id ORDER BY cuenta_id ASC";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $monto = floatval($row['monto']);
            echo "\n"."MONTO ANTES: " . $monto;
            
            $total = $monto - $entrada;
            $total += $salida;
            echo "\n"."MONTO AHORA: " . $total . " ID: " . $row['id_total'];
            
            $total = $monto + $e;
            $total = $monto - $s;
            echo "\n"."MONTO ACTUALIZADO: " . $total . " ID: " . $row['id_total'];
            
            $id_total = $row['id_total'];
            $sql_update = "UPDATE total SET monto = $total WHERE id_total = $id_total";
        }
    }else{
        $mensaje=urldecode("No se pudo actualizar la información");
        header("Location: ../admin/finanzas.php?mensaje=$mensaje&modal=true");
        exit;
    }

    $sql = "UPDATE finanzas SET fecha='$nwfecha', concepto='$nwconcepto', subcuenta='$nwsubcuenta', entrada='$e', salida='$s' WHERE id_cuenta = $id";
    $resultado=mysqli_query($conexion, $sql);
    if($resultado){
        $mensaje=urldecode("Se ha actualizado la información");
        header("Location: ../admin/finanzas.php?mensaje=$mensaje&modal=true");
        exit;
    }
    
?>