<?php 
require_once "/usr/local/lib/php/vendor/autoload.php";
include("bd.php");

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

//Conexión a la base de datos
$mysqli = conectarBD();

$comentarios = getTodosComentarios($mysqli);


$variablesParaTwig = ['comentarios' => $comentarios];

echo $twig->render('listaComentarios.html', $variablesParaTwig);

?>