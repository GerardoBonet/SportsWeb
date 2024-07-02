<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  
  //Comprobacion de parametros
  if (isset($_GET['idCom'])) {
    $idCom = $_GET['idCom'];
    
    // Comprobar si el valor es un número entero
    if (!filter_var($idCom, FILTER_VALIDATE_INT)) {
      $idCom = -1;
    }
} else {
    $idCom = -1;
}

if (isset($_GET['idAct'])) {
    $idAct = $_GET['idAct'];
    
}


  //Conexión a la base de datos
  $mysqli = conectarBD();

  //obtener comentario a editar 

  eliminarComentario($idCom,$mysqli);

  header("Location: actividad.php?id=".$idAct);


?>