<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  // Lee los datos JSON enviados en la solicitud POST
$datos_json = file_get_contents('php://input');

// Decodifica los datos JSON en un array asociativo
$comentario = json_decode($datos_json, true);

// Accede a los elementos del array asociativo
$email = $comentario['email'];
$texto = $comentario['texto'];
$fecha = $comentario['fecha'];
$idEv = $comentario['idAct'];



//Conexión a la base de datos
$mysqli = conectarBD();

//Añadir comentario a la base de datos
insertarComentarios($email, $texto, $fecha,$idEv, $mysqli);
  

?>




