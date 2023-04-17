<?php
    include("bd_cientifico.php");

    function conectar(){
        $mysqli = new mysqli("database" , "cientifico" , "paginaWeb" , "SIBW" );

        if ($mysqli->connect_errno) {
            echo("Fallo al conectar: ". $mysqli->connect_error);
        }

        return $mysqli;
    }

    function obtenerIcono($mysqli){

        $res = $mysqli->query("SELECT datos 
                                FROM imagenes 
                                WHERE descripcion = 'icono' ");

        $foto = array();
        
        if ($res->num_rows > 0){
            $row = $res->fetch_assoc();
            
            $foto = array('foto' => $row['datos']);
        }

        $imagen_codificada = base64_encode($foto['foto']);
        $url_imagen = 'data:image/png;base64,' . $imagen_codificada;
        $foto['foto'] = $url_imagen;
        
        return $foto;
    }

    function obtenerFotos($mysqli){

        $res = $mysqli->query("SELECT i.datos 
                                FROM imagenes i
                                INNER JOIN cientificos c ON i.cientifico_id = c.id
                                WHERE i.id IN (
                                    SELECT MIN(id)
                                    FROM imagenes
                                    GROUP BY cientifico_id
                                )");

        $binario = array();
        
        if ($res->num_rows > 0){
            
            while ($row = $res->fetch_assoc()) {
                $binario[] = $row['datos'];
            }
        }

        $fotos = array();

        for ( $i = 0; $i < count($binario); $i++){
            $imagen_codificada = base64_encode($binario[$i]);
            $url_imagen = 'data:image/jpeg;base64,' . $imagen_codificada;
            array_push($fotos,$url_imagen);
        }
        return $fotos;

    }

    function obtenerNombres($mysqli){

        $res = $mysqli->query("SELECT nombre FROM cientificos;");

        $nombres = array();

        if ($res->num_rows > 0){

            while ($row = $res->fetch_assoc()) {
                $nombres[] = $row['nombre'];
            }

        }else {
            $nombres = array('nombre' => 'No disponible');
        }

        return $nombres;
    }

    function obtenerEnlaces($mysqli){

        $res = $mysqli->query("SELECT descripcion, url FROM enlaces WHERE id_cientifico IS NULL; ");

        $enlaces = array();

        if ($res->num_rows > 0){
            
            while ($row = $res->fetch_assoc()) {
                $enlace = array(
                    'descripcion' => $row['descripcion'],
                    'url' => $row['url']
                );
                array_push($enlaces,$enlace);
        };

        return $enlaces;
    }
}

    function paginaPrincipal() {

        $mysqli = conectar();
        $final = array();

        //ICONO 
        $icono = obtenerIcono($mysqli);
        array_push($final,$icono);

        //FOTOS
        $fotos = obtenerFotos($mysqli);
        array_push($final,$fotos);

        //NOMBRES
        $nombres = obtenerNombres($mysqli);
        array_push($final,$nombres);

        //ENLACES
        $enlaces = obtenerEnlaces($mysqli);
        array_push($final,$enlaces);
       

        return $final;
    }

    

    function paginaCientifica($id) {

        $mysqli = conectar();
        $final = array();

        //ICONO 
        $icono = obtenerIcono($mysqli);
        array_push($final,$icono);

        //FOTOS CIENTIFICA
        $fotos = obtenerFotosCientifica($mysqli, $id);
        array_push($final,$fotos);

        //INFORMACION
        $info = obtenerInformacion($mysqli, $id);
        array_push($final,$info);

        //ENLACES CIENTIFICA
        $enlacesCientifica = obtenerEnlacesCientifica($mysqli, $id);
        array_push($final,$enlacesCientifica);

        //ENLACES AUXILIARES
        $enlacesAuxiliares = obtenerEnlaces($mysqli);
        array_push($final,$enlacesAuxiliares);
       
        //BOTONES
        $botones = obtenerBotones($mysqli, $id);
        array_push($final,$botones);

        //COMENTARIOS
        $comentarios = obtenerComentarios($mysqli, $id);
        array_push($final,$comentarios);
       

        return $final;
    }

?>