<?php

    function obtenerFotosCientifica($mysqli , $id){

        $res = $mysqli->query("SELECT datos , descripcion 
                               FROM imagenes 
                               WHERE cientifico_id = $id
                               AND descripcion IS NOT NULL;
                            ");
        
        $fotos = array();

        if ($res->num_rows > 0){
            
            while ($row = $res->fetch_assoc()) {
                $auxiliar = array(
                    'descripcion' => $row['descripcion'],
                    'binario' => $row['datos']
                );
                array_push($fotos,$auxiliar);
            }
        }

        for ( $i = 0; $i < count($fotos); $i++){
            $imagen_codificada = base64_encode($fotos[$i]['binario']);
            $url_imagen = 'data:image/jpeg;base64,' . $imagen_codificada;
            $fotos[$i]['binario'] = $url_imagen;
        }

        return $fotos;
    }

    function obtenerInformacion($mysqli, $id){
    
        $info = array();

        $res = $mysqli->query("SELECT *
                               FROM cientificos 
                               WHERE id = $id;
                            ");
        
        if ($res->num_rows > 0){
            $row = $res->fetch_assoc();
            
            $info = array('nombre' => $row['nombre'],'lugar_nacimiento' => $row['lugar_nacimiento'],
                              'lugar_muerte' => $row['lugar_muerte'], 'fecha_nacimiento' => $row['fecha_nacimiento'],
                              'fecha_muerte' => $row['fecha_muerte'], 'biografia' => $row['biografia']);
        }
        
        setlocale(LC_TIME, 'es_ES.utf8');

        if ($id != 5){

            $info['fecha_nacimiento'] = date('d \d\e F \d\e Y', strtotime($info['fecha_nacimiento']));
            //$info['fecha_muerte'] = date('d/m/Y', strtotime($info['fecha_muerte']));

            $info['fecha_muerte'] = date('d \d\e F \d\e Y', strtotime($info['fecha_muerte']));
        }else{

            $info['fecha_nacimiento'] = date(' Y \A\C', strtotime($info['fecha_nacimiento']));
            $info['fecha_muerte'] = date('F \d\e Y \A\C', strtotime($info['fecha_muerte']));
        }

        $info['biografia'] = nl2br($info['biografia']);

        return $info;
    }

    function obtenerEnlacesCientifica($mysqli, $id){

        $res = $mysqli->query("SELECT descripcion, url FROM enlaces WHERE id_cientifico = $id ; ");
        
        $enlaces = array();

        if ($res->num_rows > 0){
            while ($row = $res->fetch_assoc()) {
                $auxiliar = array(
                    'descripcion' => $row['descripcion'],
                    'url' => $row['url']
                );
                array_push($enlaces,$auxiliar);
            }
        }
        else{
            $enlaces = array('descripcion' => 'No disponible');
        }

        return $enlaces;
    }

    function obtenerBotones($mysqli , $id){

        $res = $mysqli->query("SELECT datos , descripcion 
                               FROM imagenes 
                               WHERE tipo = 'png';
                            ");
        
        $fotos = array();

        if ($res->num_rows > 0){
            while ($row = $res->fetch_assoc()) {
                $auxiliar = array(
                    'descripcion' => $row['descripcion'],
                    'binario' => $row['datos']
                );
                array_push($fotos,$auxiliar);
            }
        }

        for ( $i = 0; $i < count($fotos); $i++){
            $imagen_codificada = base64_encode($fotos[$i]['binario']);
            $url_imagen = 'data:image/png;base64,' . $imagen_codificada;
            $fotos[$i]['binario'] = $url_imagen;
        }

        //para el enlace de impresion
        $fotos[4]['descripcion'] = $fotos[4]['descripcion']. "?ev=" . $id;

        return $fotos;
    }

    function obtenerComentarios($mysqli, $id){

        $res = $mysqli->query("SELECT nombre , fecha, comentario 
                               FROM comentarios
                               WHERE id_cientifico = $id
                            ");
        
        $comentarios = array();

        if ($res->num_rows > 0){
            
            while ($row = $res->fetch_assoc()) {
                $auxiliar = array(
                    'nombre' => $row['nombre'],
                    'fecha' => $row['fecha'],
                    'comentario' => $row['comentario']
                );
                array_push($comentarios,$auxiliar);
            }
        }

        return $comentarios;
    }
?> 