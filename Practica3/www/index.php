<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $todo = paginaPrincipal();
    $fotos = $todo[0];
    $nombres = $todo[1];
    $enlaces = $todo[2];

    $tam = count($nombres);
   
    echo $twig->render('portada.html',['nombres' => $nombres, 'fotos' => $fotos, 'tam' => $tam, 'enlaces' => $enlaces]);

?>