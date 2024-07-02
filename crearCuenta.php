<?php 
require_once "/usr/local/lib/php/vendor/autoload.php";
include("bd.php");

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

//Conexión a la base de datos
$mysqli = conectarBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nick = $_POST['nick'];
    $pass = $_POST['contraseña'];
    $email = $_POST['email'];
    logearse($nick, $pass, $email, $mysqli);

  }
  
  echo $twig->render('crearCuenta.html', []);



?>