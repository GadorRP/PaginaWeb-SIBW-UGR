<?php
    

    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd_usuarios.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();

        $correoActual = $_SESSION['correo'] ;
        $passwordActual = $_POST['lineaPasswordActual'];

        $correoNuevo = $_POST['lineaCorreo'];
        $nombreNuevo = $_POST['lineaNombre'];
        $nickNuevo = $_POST['lineaNick'];
        $passwordNuevo = $_POST['lineaPasswordNueva'];
      
        if (checkLogin($correoActual, $passwordActual)) {
        
          $usuario = cambiarDatos($correoNuevo, $nombreNuevo, $nickNuevo, $passwordNuevo, $correoActual);

          $_SESSION['nick'] = $usuario['nick'];  // guardo en la sesión el nick del usuario que se ha logueado
          $_SESSION['correo'] = $usuario['correo'];

        }
        
        header("Location: cambiarDatos.php");

    }

    session_start();

    $todo = paginaRegistro();

    $datosUsuario = obtenerUsuario($_SESSION['correo']);
    $nickUser = $_SESSION['nick'];

    $icono = $todo[0];
    $enlaces = $todo[1];

    if ($datosUsuario['permisos'] == 0){
        $datosUsuario['permisos'] = "registrado";
    }
    else if ($datosUsuario['permisos'] == 1){
        $datosUsuario['permisos'] = "moderador";
    }
    else if ($datosUsuario['permisos'] == 2){
        $datosUsuario['permisos'] = "gestor";
    }
    else if ($datosUsuario['permisos'] == 3){
        $datosUsuario['permisos'] = "superUsuario";
    }

    echo $twig->render('cambiarDatos.html',['icono' => $icono, 'enlaces' => $enlaces,
    'nick' => $nickUser, 'usuario' => $datosUsuario ]);

?>