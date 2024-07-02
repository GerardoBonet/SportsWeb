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

  //Obtener datos de la actividad
  $palabrasProhibidas = getPalabrasProhibidas($mysqli);
  
  $actividad = getActividad($idEv,$mysqli);
  $comentarios = getComentarios($idEv, $mysqli);
  $actividad['comentarios'] = $comentarios; 
  
  $imagenes = getImagenes($idEv, $mysqli);
  $pies = getPieImagenes($idEv, $mysqli);
  $iconos = getIconos($mysqli);

  $variablesParaTwig = ['actividad' => $actividad, 'id' => $idEv, 'imagenes' => $imagenes, 'pies' => $pies , 'iconos' => $iconos];
  $nombreUser = "";
  $correo = "";

  session_start();
  if (isset($_SESSION['nickUsuario'])) {
    $user= getUser($_SESSION['nickUsuario'], $mysqli);
    $variablesParaTwig['user'] = $user;
    $nombreUser = $user['nombreUser'];
    $correo = $user['correoUser'];
  }


  
  echo $twig->render('actividad.html', $variablesParaTwig);

  echo '<script>';
  echo 'const palabrasProhibidas = ' . json_encode($palabrasProhibidas) . ';';
  echo 'const idEv = ' . $idEv . ';';
  echo 'const nick = "' . $nombreUser . '";';
  echo 'const correo = "' . $correo . '";';
  echo '</script>';

?>




