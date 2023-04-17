<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");


    $mysqli = conectar();

    $nombre = $_POST["lineanombre"];
    $correo = $_POST["lineacorreo"];
    $comentario = $_POST["comentario"];
    $fecha = $_POST["fechaYHora"];
    $idCientifico = $_POST["idCientifico"];

    // Preparar la consulta SQL
    $sql = "INSERT INTO comentarios (nombre, correo, comentario, fecha, id_cientifico) 
            VALUES ('$nombre', '$correo', '$comentario', '$fecha', '$idCientifico')";

    // Ejecutar la consulta SQL
    mysqli_query($mysqli, $sql);

    // Crear un array asociativo con la respuesta
    $respuesta = array(
        'nombre' => $nombre,
        'fecha' => $fecha,
        'comentario' => $comentario
    );

    // Convertir el array a formato JSON
    $respuesta_json = json_encode($respuesta);

    // Establecer el tipo de contenido de la respuesta como JSON
    header('Content-Type: application/json');

    // Enviar la respuesta JSON
    echo $respuesta_json;

    mysqli_close($mysqli);

?>