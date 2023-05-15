<?php
    include("bd.php");

    function registrarUsuario($correo, $nombre, $nick, $password_hash){
        $mysqli = conectar();

        $res = $mysqli->prepare("INSERT INTO usuarios (correo_electronico, nombre_completo, nick, contrasena, permisos) VALUES (?, ?, ?, ?, 0)");

        $res->bind_param("ssss", $correo, $nombre, $nick, $password_hash);
        $res->execute();

        mysqli_close($mysqli);

        if ($res->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function checkLogin($correo, $pass) {
        $mysqli = conectar();

        $res = $mysqli->prepare("SELECT contrasena FROM usuarios WHERE correo_electronico =?;");

        $res->bind_param("s", $correo);
        $res->execute();
        $resultado = $res->get_result();

        if ($resultado->num_rows == 1){
            $row = $resultado->fetch_assoc();
            $contrasenaBD = $row['contrasena'];
            
            if (password_verify($pass, $contrasenaBD )) {
              return true;
            }

        }else if ($res === false) {
            echo "Error en la consulta: ";
        } 
        

        mysqli_close($mysqli);
        
        return false;
    }

    function obtenerNickPermisos($correo){
        $mysqli = conectar();

        $usuario = array();

        $res = $mysqli->prepare("SELECT nick, permisos FROM usuarios WHERE correo_electronico = ?;");

        $res->bind_param("s", $correo);
        $res->execute();
        $resultado = $res->get_result();

        if ($resultado->num_rows == 1){
            $row = $resultado->fetch_assoc();

            $usuario = array(
                'nick' => $row['nick'],
                'permisos' => $row['permisos']
            );

        }else {
            $usuario = array('nick' => "Invalido", 'permisos' => "-1");
        }

        
        mysqli_close($mysqli);

        return $usuario;
    }

    function obtenerUsuario($correo){
        $mysqli = conectar();

        $usuario = array();

        $res = $mysqli->prepare("SELECT * FROM usuarios WHERE correo_electronico = ?;");

        $res->bind_param("s", $correo);
        $res->execute();
        $resultado = $res->get_result();

        if ($resultado->num_rows == 1){
            $row = $resultado->fetch_assoc();

            $usuario = array(
                'nick' => $row['nick'],
                'nombre' => $row['nombre_completo'],
                'correo' => $row['correo_electronico'],
                'hash' => $row['contrasena'],
                'permisos' => $row['permisos']
            );

        }else {
            $usuario = array('nick' => "Invalido", 'permisos' => "-1");
        }

        mysqli_close($mysqli);

        return $usuario;
    }

    function cambiarDatos($correoNuevo, $nombreNuevo, $nickNuevo, $passwordNuevo, $correoActual){

        $usuario = obtenerUsuario($correoActual);

        if (!empty($correoNuevo)) {
            $usuario['correo'] = $correoNuevo;
        }

        if (!empty($nombreNuevo)) {
            $usuario['nombre'] = $nombreNuevo;
        }

        if (!empty($nickNuevo)) {
            $usuario['nick'] = $nickNuevo;
        }

        if (!empty($passwordNuevo)) {
            $passwordHashNuevo = password_hash($passwordNuevo,PASSWORD_DEFAULT);
            $usuario['hash'] = $passwordHashNuevo;
        }

        $mysqli = conectar();

        $res = $mysqli->prepare("UPDATE usuarios SET correo_electronico=?, nombre_completo=?, contrasena=?, nick=? WHERE correo_electronico=?;");
        $res->bind_param("sssss", $usuario['correo'], $usuario['nombre'], $usuario['hash'], $usuario['nick'], $correoActual);
        $res->execute();

        mysqli_close($mysqli);

        return $usuario;
    }

    
?>