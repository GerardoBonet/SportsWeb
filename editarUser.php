<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  //Comprobacion de parametros
  if (isset($_GET['id'])) {
    $idEv = $_GET['id'];
    // Comprobar si el valor es un número entero
    if (!filter_var($idEv, FILTER_VALIDATE_INT)) {
      $idEv = -1;
    }
} else {
    $idEv = -1;
}

  //Conexión a la base de datos
  $mysqli = conectarBD();

  
  
  $user = getUserID($idEv,$mysqli);
  
  
  


  $variablesParaTwig = ['user' => $user, 'id' => $idEv];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['idUser'];  
    $tipoUser = $_POST['tipoUser'];
    

    actualizarUser($idUser,$tipoUser,$mysqli);
    header("Location: /listaUsuarios.php");

  }
  

 


  
  echo $twig->render('editarUser.html', $variablesParaTwig);

  

?>




