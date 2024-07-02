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

  
  
  $actividad = getActividad($idEv,$mysqli);
  
  


  $variablesParaTwig = ['datosActividad' => $actividad, 'id' => $idEv];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAct = $_POST['idAct'];  
    $nombre = $_POST['nombre'];
    $lugarAct = $_POST['lugarAct'];
    $costeAct = $_POST['costeAct'];
    $fechaAct = $_POST['fechaAct'];
    $descripcionAct = $_POST['descripcionAct'];
    $publicada = isset($_POST['publicada']) ? 1 : 0;

    actualiazrActividad($idAct,$nombre, $lugarAct, $costeAct, $fechaAct, $descripcionAct, $publicada, $mysqli);
    
    header("Location: /index.php");

  }
  

 


  
  echo $twig->render('editarActividad.html', $variablesParaTwig);

  

?>




