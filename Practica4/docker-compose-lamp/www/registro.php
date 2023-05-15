<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd_usuarios.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $correo = $_POST['lineaCorreo'];
        $nombre = $_POST['lineaNombre'];
        $nick = $_POST['lineaNick'];
        $password = $_POST['lineaPassword'];

        $passwordHash = password_hash($password,PASSWORD_DEFAULT);

        if (registrarUsuario($correo,$nombre,$nick,$passwordHash)){
            session_start();

            $_SESSION['nick'] = $nick;
            $_SESSION['correo'] = $correo;
            $_SESSION['permisos'] = 0;

            header('Location: index.php');
        }
        else {
            header('Location: inicioSesion.php');
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

    echo $twig->render('registro.html',['icono' => $icono, 'enlaces' => $enlaces, 'nick' => $nickUser ]);
?>