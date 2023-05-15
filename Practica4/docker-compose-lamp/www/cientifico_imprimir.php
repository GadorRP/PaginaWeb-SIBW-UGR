<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $id = $_GET['ev'];

    $todo = paginaCientifica($id);

    $icono = $todo[0];
    $fotos = $todo[1];
    $info = $todo[2];
    $enlacesCientifica = $todo[3];
    $enlacesAuxiliares = $todo[4];
    $botones = $todo[5];

    $numEnlaces = count($enlacesCientifica) - 1;
    $numFotos = count($fotos) - 1;

    //echo $twig->render('cientifico_imprimir.html',[ 'nombre' => $nombreCientifico ]);

    echo $twig->render('cientifico_imprimir.html',['fotos' => $fotos, 'numFotos' => $numFotos,'info' => $info, 'botones' => $botones,
    'enlacesCientifica' => $enlacesCientifica, 'numEnlaces' => $numEnlaces, 'enlaces' => $enlacesAuxiliares, 'icono' => $icono]);

?>