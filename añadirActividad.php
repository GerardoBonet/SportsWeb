<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  

  //Conexión a la base de datos
  $mysqli = conectarBD();


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $lugarAct = $_POST['lugarAct'];
    $costeAct = $_POST['costeAct'];
    $fechaAct = $_POST['fechaAct'];
    $descripcionAct = $_POST['descripcionAct'];
    $publicada = isset($_POST['publicada']) ? 1 : 0;
    $imagen = $_POST['imagen'];
    $pieImagen = $_POST['pieFoto'];

    añadirActividad($nombre, $lugarAct, $costeAct, $fechaAct, $descripcionAct, $publicada, $mysqli);
    añadirImagen($nombre, $imagen, $pieImagen ,$mysqli);
    header("Location: /index.php");

  }
  

  echo $twig->render('añadirActividad.html', []);

  

?>






