<?php
    include "../coledelbosque/php/conexion.php";

    $fecha = $_POST["fecha"];
    $concepto = $_POST["concepto"];
    $subcuenta = $_POST["subcuenta"];
    $e = $_POST["entrada"];
    $s = $_POST["salida"];

    $entrada = !empty($e) ? floatval($e) : 0;
    $salida = !empty($s) ? floatval($s) : 0;

    if(empty($e) && empty($s)){
        $mensaje=urldecode("Debes ingresar un cantidad de entrada o de salida");
        header("Location: ../coledelbosque/admin/finanzas.php?mensaje=$mensaje&modal=true");
        exit;
    }else{
        if(!empty($e)){
            if(filter_var($e, FILTER_VALIDATE_FLOAT) == false){
                $mensaje=urldecode("Entrada debe ser un número");
                header("Location: ../coledelbosque/admin/finanzas.php?mensaje=$mensaje&modal=true");
                exit;
            }else{
                if($entrada<=0){
                    $mensaje=urldecode("Debes ingresar una cantidad mayor a 0");
                    header("Location: ../coledelbosque/admin/finanzas.php?mensaje=$mensaje&modal=true");
                    exit;
                }
            }
        }

        if(!empty($s)){
            if(filter_var($s, FILTER_VALIDATE_FLOAT) == false){
                $mensaje=urldecode("Salida debe ser un número");
                header("Location: ../coledelbosque/adminfinanzas.php?mensaje=$mensaje&modal=true");
                exit;
            }else{
                if($salida<=0){
                    $mensaje=urldecode("Debes ingresar una cantidad mayor a 0");
                    header("Location: ../coledelbosque/admin/finanzas.php?mensaje=$mensaje&modal=true");
                    exit;
                }
            }
        }
    }

    $query = "INSERT INTO finanzas (fecha,concepto,subcuenta,entrada,salida) VALUES ('$fecha','$concepto','$subcuenta',$entrada,$salida)";

    $execute = mysqli_query($conexion,$query);

    if($execute){
        $id_op = mysqli_insert_id($conexion);
        $id = intval($id_op);
    }else{
        $mensaje=urldecode("Error, revisa la información");
        header("Location: ../coledelbosque/admin/finanzas.php?mensaje=$mensaje&modal=true");
        exit;
    }


    $query = "SELECT monto FROM total ORDER BY id_total DESC LIMIT 1";
    $execute = mysqli_query($conexion,$query);
    if(mysqli_num_rows($execute)){
        $row = mysqli_fetch_assoc($execute);
        $m = $row['monto'];
        if(!empty($m)){
            $monto = floatval($m);
            $monto+=$entrada;
            $monto-=$salida;
        }else{
            $mensaje=urldecode("Fallo al capturar los datos, revise la información");
            header("Location: ../coledelbosque/admin/finanzas.php?mensaje=$mensaje&modal=true");
            exit;    
        }
        $query = "INSERT INTO total (monto,cuenta_id) VALUES ($monto,'$id')";
        $execute = mysqli_query($conexion,$query);
        if($execute){
            $mensaje=urldecode("Se ha registrado correctamente la cantidad");
            header("Location: ../coledelbosque/admin/finanzas.php?mensaje=$mensaje&modal=true");
            exit;
        }else{
            $mensaje=urldecode("Fallo al capturar los datos, revise la información");
            header("Location: ../coledelbosque/admin/finanzas.php?mensaje=$mensaje&modal=true");
            exit;
        }
    }else{
        $monto=$entrada-$salida;
        $query = "INSERT INTO total (monto,cuenta_id) VALUES ($monto,'$id')";
        $execute = mysqli_query($conexion,$query);
        if($execute){
            $mensaje=urldecode("Se ha registrado correctamente la cantidad");
            header("Location: ../coledelbosque/admin/finanzas.php?mensaje=$mensaje&modal=true");
            exit;
        }else{
            $mensaje=urldecode("Fallo al capturar los datos, revise la información");
            header("Location: ../coledelbosque/admin/finanzas.php?mensaje=$mensaje&modal=true");
            exit;
        }
    }

?>