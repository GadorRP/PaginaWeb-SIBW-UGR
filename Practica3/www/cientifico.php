<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $id = $_GET['ev'];
    $nombreCientifico = $id;
    $fechaevento = "fecha_defecto";

    $todo = paginaCientifica($id);
    $fotos = $todo[0];
    $info = $todo[1];
    $enlacesCientifica = $todo[3];
    $enlacesAuxiliares = $todo[4];

    echo $twig->render('cientifico.html',[ 'nombre' => $nombreCientifico ]);

?>