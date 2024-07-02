<?php 
require_once "/usr/local/lib/php/vendor/autoload.php";
include("bd.php");

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

//Conexión a la base de datos
$mysqli = conectarBD();
$iconos = getIconos($mysqli);

$actividades = getActividades($mysqli);


$variablesParaTwig = ['actividades' => $actividades, 'iconos' => $iconos];

echo $twig->render('listaActividades.html', $variablesParaTwig);

?>