<?php
    include '../php/conexion.php';
    $id = $_POST['id_cuenta'];
    $e = $_POST['entrada'];
    $s = $_POST['salida'];

    $entrada = !empty($e) ? floatval($e) : 0;
    $salida = !empty($s) ? floatval($s) : 0;

    $sql ="DELETE FROM total WHERE cuenta_id=$id";
    $resultado = mysqli_query($conexion,$sql);
    if($resultado){
        $sql = "DELETE FROM finanzas WHERE id_cuenta='$id'";
        $resultado = mysqli_query($conexion,$sql);

        if($resultado){
            $sql = "SELECT monto, id_total FROM total WHERE cuenta_id > $id ORDER BY cuenta_id ASC";
            $resultado=mysqli_query($conexion,$sql);
            if(mysqli_num_rows($resultado)>0){
                while($row = mysqli_fetch_assoc($resultado)){
                    $monto = floatval($row['monto']);
                    echo "\nMONTO ANTES: ". $monto;
                    $total=$monto-$entrada;
                    $total+=$salida;
                    echo "\nMONTO AHORA:".$total."ID: ".$row['id_total'];
                    $id_total=$row['id_total'];
                    $sql_update="UPDATE total SET monto = $total WHERE id_total=$id_total";
                    
                } 
            }else{
                $mensaje=urldecode("Se ha eliminado el registro");
                header("Location: ../admin/finanzas.php?mensaje=$mensaje&modal=true");
                exit;
            }
            $mensaje=urldecode("Se ha actualizado la información y se ha eliminado el registros");
            header("Location: ../admin/finanzas.php?mensaje=$mensaje&modal=true");
            exit;
        }else{
            $mensaje=urldecode("No se ha podido eliminar el registro");
            header("Location: ../admin/finanzas.php?mensaje=$mensaje&modal=true");
            exit;
        }
    }else{
        $mensaje=urldecode("No se ha podido eliminar el registro");
        header("Location: ../admin/finanzas.php?mensaje=$mensaje&modal=true");
        exit;
    }
    
?>