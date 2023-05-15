<?php
    session_start();

    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $todo = paginaPrincipal();

    $icono = $todo[0];
    $fotos = $todo[1];
    $nombres = $todo[2];
    $enlaces = $todo[3];

    $tam = count($nombres);

    $nickUser = "Invalido";

    if (isset($_SESSION['nick'])){
        $nickUser = $_SESSION['nick'];
    }
   
    echo $twig->render('portada.html',['nombres' => $nombres, 'fotos' => $fotos, 
     'icono' => $icono,'tam' => $tam, 'enlaces' => $enlaces, 'nick' => $nickUser]);

?>