<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $nombreCientifico = "NombreHola";

    echo $twig->render('cientifico_imprimir.html',[ 'nombre' => $nombreCientifico ]);

?>