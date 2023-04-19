<?php

    function obtenerFotosCientifica($mysqli , $id){

        $res = $mysqli->prepare("SELECT datos, descripcion 
            FROM imagenes 
            WHERE cientifico_id = ? 
            AND descripcion IS NOT NULL;
        ");

        $res->bind_param("i", $id);
        $res->execute();
        $resultado = $res->get_result();

        $fotos = array();
        
        if ($resultado->num_rows > 0){
            while ($row = $resultado->fetch_assoc()) {
                $auxiliar = array(
                    'descripcion' => $row['descripcion'],
                    'binario' => $row['datos']
                );

                array_push($fotos,$auxiliar);
            }

            for ( $i = 0; $i < count($fotos); $i++){
                $imagen_codificada = base64_encode($fotos[$i]['binario']);
                $url_imagen = 'data:image/jpeg;base64,' . $imagen_codificada;
                $fotos[$i]['binario'] = $url_imagen;
            }
        } 
        else {
            $fotos = array('descripcion' => "no encontrado", 'binario' => "no encontrado");
        }
        

        return $fotos;

    }

    function obtenerInformacion($mysqli, $id){
    
        $info = array();
        
        $res = $mysqli->prepare("SELECT nombre, lugar_nacimiento, lugar_muerte, 
                                fecha_nacimiento, fecha_muerte, biografia
                                FROM cientificos
                                WHERE id = ?");

        $res->bind_param("i", $id);
        $res->execute();
        $resultado = $res->get_result();

        if ($row = $resultado->fetch_assoc()) {

            $info = array(
                'nombre' => $row['nombre'],
                'lugar_nacimiento' =>  $row['lugar_nacimiento'],
                'lugar_muerte' =>  $row['lugar_muerte'],
                'fecha_nacimiento' =>  $row['fecha_nacimiento'],
                'fecha_muerte' => $row['fecha_muerte'],
                'biografia' => $row['biografia']
            );

            //poner la fecha en el formato elegido

            if ($id != 5) {
                $fechas = formatoFecha($info['fecha_nacimiento'],$info['fecha_muerte']);
                $info['fecha_nacimiento'] = $fechas[0];
                $info['fecha_muerte'] = $fechas[1];

            } else {
                //fecha antes de cristo
                $info['fecha_nacimiento'] = date(' Y \A\C', strtotime($info['fecha_nacimiento']));
                $info['fecha_muerte'] = date('F \d\e Y \A\C', strtotime($info['fecha_muerte']));
            }

            //interpreta los espacios como etiquetas <br>
            $info['biografia'] = nl2br($info['biografia']);

        } else {
            $info = array(
                'nombre' => "no encontrado",
                'lugar_nacimiento' => "no encontrado",
                'lugar_muerte' => "no encontrado",
                'fecha_nacimiento' => "no encontrado",
                'fecha_muerte' => "no encontrado",
                'biografia' => "no encontrado"
            );
        }

        return $info;
    }

    function obtenerEnlacesCientifica($mysqli, $id){

        $res = $mysqli->prepare("SELECT descripcion, url FROM enlaces WHERE id_cientifico = ?");
        $res->bind_param("i", $id);
        $res->execute();
        $resultado = $res->get_result();

        $enlaces = array();

        if ($resultado->num_rows > 0){
            while ($row = $resultado->fetch_assoc()) {
                $auxiliar = array(
                    'descripcion' => $row['descripcion'],
                    'url' => $row['url']
                );
                array_push($enlaces,$auxiliar);
            }
        }
        else  {
            $enlaces = array('descripcion' => 'No disponible', 'url' => 'no disponible');
        };
           
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

        $res = $mysqli->prepare("SELECT nombre , fecha, comentario 
                               FROM comentarios
                               WHERE id_cientifico = ?
                            ");
        
        $res->bind_param("i", $id);
        $res->execute();

        $resultado = $res->get_result();

        $comentarios = array();

        if ($resultado->num_rows > 0){
            
            while ($row = $resultado->fetch_assoc()) {
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

    function formatoFecha($fecha_nacimiento, $fecha_muerte){
        // Array con los nombres de los meses en español
        $meses_espanol = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $fechas = array();

        $fecha_nacimiento_timestamp = strtotime($fecha_nacimiento);
        $dia = date('d', $fecha_nacimiento_timestamp);
        $mes_numero = date('n', $fecha_nacimiento_timestamp);
        $mes_nombre = $meses_espanol[$mes_numero - 1];
        $ano = date('Y', $fecha_nacimiento_timestamp);

        array_push($fechas,"$dia de $mes_nombre de $ano");

        $fecha_muerte_timestamp = strtotime($fecha_muerte);
        $dia = date('d', $fecha_muerte_timestamp);
        $mes_numero = date('n', $fecha_muerte_timestamp);
        $mes_nombre = $meses_espanol[$mes_numero - 1];
        $ano = date('Y', $fecha_muerte_timestamp);
        
        array_push($fechas,"$dia de $mes_nombre de $ano");
        
        return $fechas;
    }
?> 