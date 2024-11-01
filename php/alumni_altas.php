<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$paterno = $_POST['paterno'];
$materno = $_POST['materno'];
$matricula = $_POST['matricula'];
$grupo = $_POST['grado'];

if($grupo == "no"){
    $mensaje = urlencode("No hay grupos disponibles, crea un grupo");
    header("Location: ../admin/alumnos.php?mensaje=$mensaje&modal=true");
    exit;
}

if(empty($nombre)){
    $mensaje = urlencode("El nombre no puede estar vacio");
    header("Location: ../admin/alumnos.php?mensaje=$mensaje&modal=true");
    exit;
}else if(is_numeric($nombre)){
    $mensaje = urlencode("Revise el nombre del alumno");
    header("Location: ../admin/alumnos.php?mensaje=$mensaje&modal=true");
    exit;
}

if(empty($paterno)){
    $mensaje = urlencode("El apellido paterno no puede estar vacío");
    header("Location: ../admin/alumnos.php?mensaje=$mensaje&modal=true");
    exit;
}else if(is_numeric($paterno)){
    $mensaje = urlencode("Revise el apellido paterno del alumno");
    header("Location: ../admin/alumnos.php?mensaje=$mensaje&modal=true");
    exit;
}

if(empty($materno)){
    $mensaje = urlencode("El apellido materno no puede estar vacío");
    header("Location: ../admin/alumnos.php?mensaje=$mensaje&modal=true");
    exit;
}else if(is_numeric($materno)){
    $mensaje = urlencode("Revise el apellido materno del alumno");
    header("Location: ../admin/alumnos.php?mensaje=$mensaje&modal=true");
    exit;
}

$pattern = "/^([A-Z]{3})([0-9]{6})$/";
if(preg_match($pattern,$matricula)){
    $matricula = hash("sha512",$matricula);
    $sql = "INSERT INTO usuario (nombre, paterno, materno) VALUES ('$nombre','$paterno','$materno')";
    $resultado = mysqli_query($conexion, $sql);
    $id = mysqli_insert_id($conexion);
    $permiso = 3;
    if($resultado){
        $sql = "INSERT INTO cuenta (matricula, usuario_id, permiso_id) VALUES ('$matricula', $id, $permiso)";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $cuenta_id = mysqli_insert_id($conexion);
            $sql = "UPDATE grupo SET cuenta_id=$cuenta_id WHERE id_grupo = $grupo";
            $resultado = mysqli_query($conexion,$sql);
            if($resultado){
                $mensaje = urlencode("¡Se ha registrado un nuevo alumno!");
                header("Location: ../admin/alumnos.php?mensaje=$mensaje&modal=true");
                exit;
            }else{
                $mensaje = urlencode("Ha habido un error al registrar el grupo");
                header("Location: ../admin/alumnos.php?mensaje=$mensaje&modal=true");
                exit;
            }
        }
    }
}else{
    $mensaje=$mensaje = urlencode("Error de registro, la matricula debe contener 3 mayúsculas y 6 números");
    header("Location: ../admin/alumnos.php?mensaje=$mensaje&modal=true");
    exit;
}


?>