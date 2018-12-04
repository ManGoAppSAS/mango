<?php
//nombre de la sesion, inicio de la sesión y conexion con la base de datos
include ("sis/nombre_sesion.php");
?>

<?php
//variables del formulario de logueo
if (isset($_POST['contrasena'])) $contrasena = $_POST['contrasena']; elseif (isset($_GET['contrasena'])) $contrasena = $_GET['contrasena']; else $contrasena = null;
if (isset($_POST['correo'])) $correo = $_POST['correo']; elseif (isset($_GET['correo'])) $correo = $_GET['correo']; else $correo = null;
?>

<?php
//zona horaria
date_default_timezone_set('America/Bogota');
$ahora = date("Y-m-d H:i:s");
$hoy = date("Y-m-d");
?>

<?php
//sino existe por lo menos un usuario creado creo el de soporte tecnico
$consulta_usuario = $conexion->query("SELECT * FROM usuario");

if ($consulta_usuario->num_rows == 0)
{    
    $insercion_usuario = $conexion->query("INSERT INTO usuario values ('', '$ahora', '', '', '1', '', '', 'activo', 'soporte', 'técnico', 'CC', '123', 'soporte técnico', 'demo@demo.com', 'demo', '', '', '$hoy', 'no', '', '1')");
}

//sino existe por lo menos un local creado creo el de prueba
$consulta_local = $conexion->query("SELECT * FROM local");

if ($consulta_local->num_rows == 0)
{
    $insercion_local = $conexion->query("INSERT INTO local values ('', '$ahora', '', '', '1', '', '', 'activo', 'local de prueba', 'punto de venta', '', '', '09:00:00', '17:00:00', '0', 'no', '')");
}

//sino existe por lo menos un impuesto creo el de cero sin impuesto
$consulta_impuesto = $conexion->query("SELECT * FROM impuesto");

if ($consulta_impuesto->num_rows == 0)
{
    $insercion_impuesto = $conexion->query("INSERT INTO impuesto values ('', '$ahora', '', '', '1', '', '', 'activo', 'sin impuesto', '0')");
    $insercion_impuesto = $conexion->query("INSERT INTO impuesto values ('', '$ahora', '', '', '1', '', '', 'activo', 'Ipoonsumo', '5')");
    $insercion_impuesto = $conexion->query("INSERT INTO impuesto values ('', '$ahora', '', '', '1', '', '', 'activo', 'IVA', '19')");
}


//sino existe por lo menos un metodo de pago creo el de efectivo
$consulta_metodo_pago = $conexion->query("SELECT * FROM metodo_pago");

if ($consulta_metodo_pago->num_rows == 0)
{
    $insercion_metodo_pago = $conexion->query("INSERT INTO metodo_pago values ('', '$ahora', '', '', '1', '', '', 'activo', 'efectivo', 'efectivo', '0')");
}
?>

<?php
//consulto si el correo se encuentra en la tabla usuario
$consulta = $conexion->query("SELECT * FROM usuario WHERE correo = '$correo'");

if ($fila = $consulta->fetch_assoc())
{	
	$contrasena_almacenada = $fila['contrasena'];

	//si la contraseña enviada es igual a la guardada en la base de datos
	if ($contrasena_almacenada == $contrasena)
	{
		$_SESSION['id'] = $fila['usuario_id'];
		$_SESSION['correo'] = $fila['correo'];		
		
		header("location:index.php");
	} 
	else
	{	
		header("location:logueo.php?caso=2&correo=$correo");
	}
} 
else 
{
	header("location:logueo.php?caso=1&correo=$correo");
}
?>