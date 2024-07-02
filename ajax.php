<?php
require_once "/usr/local/lib/php/vendor/autoload.php";
include 'bd.php';

//Conexión a la base de datos
$mysqli = conectarBD();

session_start();
$tipoUser = 0;
if (isset($_SESSION['nickUsuario'])) {
    $user = getUser($_SESSION['nickUsuario'], $mysqli);
    $tipoUser = $user['tipoUser'];
}


header('Content-Type: application/json');

$actividad = $_GET['actividad'];

$actividades = buscarActividades($actividad, $mysqli, $tipoUser);


echo(json_encode($actividades));

  
?>