<?php 
require_once "/usr/local/lib/php/vendor/autoload.php";
include("bd.php");

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

//Conexión a la base de datos
$mysqli = conectarBD();
$iconos = getIconos($mysqli);

$users = getUsers($mysqli);





$variablesParaTwig = ['users' => $users, 'iconos' => $iconos];

echo $twig->render('listaUsuarios.html', $variablesParaTwig);

?>