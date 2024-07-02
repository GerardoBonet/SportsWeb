<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  
  //Comprobacion de parametros
  if (isset($_GET['id'])) {
    $idAct = $_GET['id'];
    
    // Comprobar si el valor es un número entero
    if (!filter_var($idAct, FILTER_VALIDATE_INT)) {
      $idAct = -1;
    }
} else {
    $idAct = -1;
}



  //Conexión a la base de datos
  $mysqli = conectarBD();

  eliminarActividad($idAct, $mysqli);
  

  header("Location: index.php");


?>