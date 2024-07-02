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



  //Conexión a la base de datos
  $mysqli = conectarBD();

  //obtener comentario a editar 

  $comentario = obtenerComentario($idCom,$mysqli);


 
  $variablesParaTwig = ['comentario' => $comentario];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comID = $_POST['idCom'];  
    $tex = $_POST['textoCom'];
    $tex .= " (Comentario editado por un moderador)";
    
    actualiazrComentario($comID, $tex, $mysqli);
      
  }
  

 

  
  echo $twig->render('editarComentario.html', $variablesParaTwig);



?>