<?php
    session_start();
    include '../php/conexion.php';
    include 'crypto.php';
    $matricula=$_POST["matricula"];
    $matricula = encrypt($matricula);
    $consult="SELECT * FROM cuenta WHERE matricula='$matricula'";
    $validate_login = mysqli_query($conexion,$consult);
    if(mysqli_num_rows($validate_login)){
        $row = mysqli_fetch_assoc($validate_login);
        $permiso = $row['permiso_id'];
        $user_id = $row['usuario_id'];
        $consult="SELECT * FROM usuario WHERE id_usuario='$user_id'";
        $validate_user = mysqli_query($conexion,$consult);
        if(mysqli_num_rows($validate_user)){
            $row = mysqli_fetch_assoc($validate_user);
            $nombre = $row['nombre'];
            $paterno = $row['paterno'];
            $user = $nombre." ".$paterno;
            $_SESSION["usuario"] = $user;
            $_SESSION["permiso"] = $permiso;
            $_SESSION["id"] = $user_id;
            if($permiso=="1"){
                echo"
                    <script>
                        window.location='../paneldecontrol.php';
                    </script>
                ";
            }else if($permiso=="2"){
                echo"
                    <script>
                        window.location='../maestros/panel_profesor.php';
                    </script>
                ";
            }
        }
    }else{
        $mensaje=$mensaje = urlencode("Error al iniciar sesión, verifica el ID ingresado");
        header("Location: ../iniciar_sesion.php?mensaje=$mensaje&modal=true");
        exit;
    }
?>