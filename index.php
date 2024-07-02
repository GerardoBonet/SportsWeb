<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include 'bd.php';

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  //Conexión a la base de datos
  $mysqli = conectarBD();
  
  session_start();

  /*
  Nota: Para los usuarios he usado en la base de tados un identificador tipoUser que va del 1 al 4
  1 -> Regsitrado
  2 -> Moderador
  3 -> Gestor
  4 -> Superusuario
  */

  //Obtener datos de la portada
  $imagenesPortada = getImagenesPortada($mysqli);
  $iconos = getIconos($mysqli);
  $actividades = getActividades($mysqli);

  
  

  $variablesParaTwig = ['imagenes' => $imagenesPortada,'iconos' => $iconos, 'actividades' => $actividades];

  if (isset($_SESSION['nickUsuario'])) {
    $variablesParaTwig['user'] = getUser($_SESSION['nickUsuario'], $mysqli);
    
  }
  


  echo $twig->render('portada.html', $variablesParaTwig);
?>
