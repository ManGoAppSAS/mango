<?php
//con esto se pueden enviar los headers en cualquier lugar del documento
ob_start();
?>

<?php
//variable de la sesion y la bases de datos
$sesion_y_bd = "mango_bd";

//nombre de la sesion
session_name($sesion_y_bd);

//inicio de sesion
include ("tiempo_sesion.php");
session_start();

//variables de conexión
$conexion_host = "localhost";
$conexion_user = "root";
$conexion_pass = "root";
$conexion_bd = $sesion_y_bd;

$conexion = new mysqli($conexion_host, $conexion_user, $conexion_pass, $conexion_bd);
?>