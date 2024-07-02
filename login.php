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
  
    if (checkLogin($nick, $pass, $mysqli)) {
      session_start();
      
      $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
    }
    
    header("Location: sesionUsuario.php");
    
    exit();
  }
  
  echo $twig->render('login.html', []);



?>