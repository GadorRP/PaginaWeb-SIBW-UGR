<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

   
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Conectar a la base de datos
  $conn = mysqli_connect('localhost', 'usuario', 'contraseña', 'basedatos');

  // Verificar las credenciales del usuario
  $email = $_POST['email'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM usuarios WHERE email='$email' AND password='$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
    // Crear la sesión
    $_SESSION['email'] = $email;

    // Redireccionar al usuario a la página que se desee
    header('Location: bienvenida.php');
    exit();
  } else {
    echo 'Credenciales incorrectas';
  }

  mysqli_close($conn);
}
?>

    if ($_GET['accion'] == 'obtenerArray') {
        $palabras = obtenerPalabras($mysqli);
        echo json_encode($palabras);
    }
    else{
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
    }

    function obtenerPalabras($mysqli){

        $res = $mysqli->query("SELECT palabra
                                FROM censuradas
                            ");

        $palabras = array();

        if ($res->num_rows > 0){
            while ($row = $res->fetch_assoc()) {
                $auxiliar = array( 'palabra' => $row['palabra']);

                array_push($palabras,$auxiliar);
            }
        }

        return $palabras;
    }

?>