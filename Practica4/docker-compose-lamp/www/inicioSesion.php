<?php
    

    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd_usuarios.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $correo = $_POST['lineaCorreo'];
        $pass = $_POST['lineaPassword'];
      
        if (checkLogin($correo, $pass)) {
          session_start();
          
          $usuario = obtenerNickPermisos($correo);

          $_SESSION['nick'] = $usuario['nick'];  // guardo en la sesión el nick del usuario que se ha logueado
          $_SESSION['correo'] = $correo;
          $_SESSION['permisos'] = $usuario['permisos'];
          

          header("Location: index.php");
        }
        else {
          header("Location: registro.php");
        }
        
    }

    session_start();

    $todo = paginaRegistro();

    $nickUser = "Invalido";

    if (isset($_SESSION['nick'])){
        $nickUser = $_SESSION['nick'];
    }

    $icono = $todo[0];
    $enlaces = $todo[1];

    echo $twig->render('inicioSesion.html',['icono' => $icono, 'enlaces' => $enlaces, 'nick' => $nickUser ]);
?>