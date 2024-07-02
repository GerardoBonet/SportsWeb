<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  //Conexión a la base de datos
    $mysqli = conectarBD();
  
  $variablesParaTwig = [];

  //Tipos de usuario=> 0:Usuario registrado 1:Usuario moderador 2:Usuario gestor 3:Superusuario
  
  session_start();
  
  if (isset($_SESSION['nickUsuario'])) {
    $variablesParaTwig['user'] = getUser($_SESSION['nickUsuario'], $mysqli);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['idUser'];  
    $nombreUser = $_POST['nombreUser'];
    $correoUser = $_POST['correoUser'];
    

    editarUser($idUser,$nombreUser,$correoUser,$mysqli);
    header("Location: /index.php");

  }
  
  echo $twig->render('editarDatos.html', $variablesParaTwig);
?>