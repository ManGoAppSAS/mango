<?php
//nombre de la sesion, inicio de la sesión y conexion con la base de datos
include ("sis/nombre_sesion.php");
?>

<?php
//verifico si la sesión está creada y si no lo está lo envio al logueo
if (!isset($_SESSION['correo'])) {

	header("location:logueo.php");

} else {

	//si hay una sesion creada la destruyo y lo envio al logueo
	session_unset();
	session_destroy();
	header("location:logueo.php?caso=3");
	
}
?>