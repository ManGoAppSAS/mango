<?php
//nombre de la sesion, inicio de la sesión y conexion con la base de datos
include ("sis/nombre_sesion.php");

//verifico si la sesión está creada y si no lo está lo envio al logueo
if (!isset($_SESSION['correo']))
{
    header("location:logueo.php");
}
?>

<?php
//variables de la conexion, sesion y subida
include ("sis/variables_sesion.php");
include('sis/subir.php');

$carpeta_destino = (isset($_GET['dir']) ? $_GET['dir'] : 'img/avatares');
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $carpeta_destino);
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;
if(isset($_POST['editar_permisos'])) $editar_permisos = $_POST['editar_permisos']; elseif(isset($_GET['editar_permisos'])) $editar_permisos = $_GET['editar_permisos']; else $editar_permisos = null;
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

//variables del formulario
if(isset($_POST['usuario_id'])) $usuario_id = $_POST['usuario_id']; elseif(isset($_GET['usuario_id'])) $usuario_id = $_GET['usuario_id']; else $usuario_id = null;
if(isset($_POST['nombres'])) $nombres = $_POST['nombres']; elseif(isset($_GET['nombres'])) $nombres = $_GET['nombres']; else $nombres = null;
if(isset($_POST['apellidos'])) $apellidos = $_POST['apellidos']; elseif(isset($_GET['apellidos'])) $apellidos = $_GET['apellidos']; else $apellidos = null;
if(isset($_POST['documento_tipo'])) $documento_tipo = $_POST['documento_tipo']; elseif(isset($_GET['documento_tipo'])) $documento_tipo = $_GET['documento_tipo']; else $documento_tipo = null;
if(isset($_POST['documento_numero'])) $documento_numero = $_POST['documento_numero']; elseif(isset($_GET['documento_numero'])) $documento_numero = $_GET['documento_numero']; else $documento_numero = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['correo'])) $correo = $_POST['correo']; elseif(isset($_GET['correo'])) $correo = $_GET['correo']; else $correo = null;
if(isset($_POST['contrasena'])) $contrasena = $_POST['contrasena']; elseif(isset($_GET['contrasena'])) $contrasena = $_GET['contrasena']; else $contrasena = null;
if(isset($_POST['telefono'])) $telefono = $_POST['telefono']; elseif(isset($_GET['telefono'])) $telefono = $_GET['telefono']; else $telefono = null;
if(isset($_POST['direccion'])) $direccion = $_POST['direccion']; elseif(isset($_GET['direccion'])) $direccion = $_GET['direccion']; else $direccion = null;
if(isset($_POST['fecha_nacimiento'])) $fecha_nacimiento = $_POST['fecha_nacimiento']; elseif(isset($_GET['fecha_nacimiento'])) $fecha_nacimiento = $_GET['fecha_nacimiento']; else $fecha_nacimiento = null;
if(isset($_POST['porcentaje_comision'])) $porcentaje_comision = $_POST['porcentaje_comision']; elseif(isset($_GET['porcentaje_comision'])) $porcentaje_comision = $_GET['porcentaje_comision']; else $porcentaje_comision = 0;
if(isset($_POST['local_id'])) $local_id = $_POST['local_id']; elseif(isset($_GET['local_id'])) $local_id = $_GET['local_id']; else $local_id = 0;

//variables de la imagen
if(isset($_POST['imagen'])) $imagen = $_POST['imagen']; elseif(isset($_GET['imagen'])) $imagen = $_GET['imagen']; else $imagen = null;
if(isset($_POST['imagen_nombre'])) $imagen_nombre = $_POST['imagen_nombre']; elseif(isset($_GET['imagen_nombre'])) $imagen_nombre = $_GET['imagen_nombre']; else $imagen_nombre = null;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información del usuario
if ($editar == "si")
{
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
        $imagen_nombre = $ahora_img;
        $imagen_ref = "usuarios";
        $id = $usuario_id;

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $imagen = $imagen;
        $imagen_nombre = $imagen_nombre;
    }
    
    $actualizar = $conexion->query("UPDATE usuario SET fecha_mod = '$ahora', usuario_mod = '$sesion_id', nombres = '$nombres', apellidos = '$apellidos', documento_tipo = '$documento_tipo', documento_numero = '$documento_numero', tipo = '$tipo', correo = '$correo', contrasena = '$contrasena', telefono = '$telefono', direccion = '$direccion', fecha_nacimiento = '$fecha_nacimiento', porcentaje_comision = '$porcentaje_comision', imagen = '$imagen', imagen_nombre = '$imagen_nombre', local_id = '$local_id' WHERE usuario_id = '$usuario_id'");

    if ($actualizar)
    {
        $mensaje = "Cambios guardados";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }     
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Usuario - ManGo!</title>    
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>
</head>
<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="usuarios_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Usuario</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro el usuario
    $consulta = $conexion->query("SELECT * FROM usuario WHERE usuario_id = '$usuario_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Este usuario ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $usuario_id = $fila['usuario_id'];
            
            $fecha_alta = date('d/m/Y', strtotime($fila['fecha_alta']));
            $hora_alta = date('h:i a', strtotime($fila['fecha_alta']));

            $fecha_mod = date('d/m/Y', strtotime($fila['fecha_mod']));
            $hora_mod = date('h:i a', strtotime($fila['fecha_mod']));

            $fecha_baja = date('d/m/Y', strtotime($fila['fecha_baja']));
            $hora_baja = date('h:i a', strtotime($fila['fecha_baja']));

            $usuario_alta = $fila['usuario_alta'];
            $usuario_mod = $fila['usuario_mod'];
            $usuario_baja = $fila['usuario_baja'];

            $estado = $fila['estado'];

            $nombres = $fila['nombres'];
            $apellidos = $fila['apellidos'];
            $documento_tipo = $fila['documento_tipo'];
            $documento_numero = $fila['documento_numero'];
            $tipo = $fila['tipo'];
            $correo = $fila['correo'];
            $contrasena = $fila['contrasena'];

            $telefono = $fila['telefono'];
            $direccion = $fila['direccion'];
            $fecha_nacimiento = date('d/m/Y', strtotime($fila['fecha_nacimiento']));
            $porcentaje_comision = $fila['porcentaje_comision'];

            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];

            $local_id = $fila['local_id'];

            //consulto el local
            $consulta_local = $conexion->query("SELECT * FROM local WHERE local_id = '$local_id'");           

            if ($fila = $consulta_local->fetch_assoc()) 
            {
                $local = $fila['local'];
            }
            else
            {
                $local = "";
            }

            //consulto el usuario alta
            $consulta_usuario = $conexion->query("SELECT * FROM usuario WHERE usuario_id = '$usuario_alta'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $usuario_alta = $fila['correo'];
            }
            else
            {
                $usuario_alta = "";
            }

            //consulto el usuario mod
            $consulta_usuario = $conexion->query("SELECT * FROM usuario WHERE usuario_id = '$usuario_mod'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $usuario_mod = $fila['correo'];
            }
            else
            {
                $usuario_mod = "";
            }            

            //consulto el usuario baja
            $consulta_usuario = $conexion->query("SELECT * FROM usuario WHERE usuario_id = '$usuario_baja'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $usuario_baja = $fila['correo'];
            }
            else
            {
                $usuario_baja = "";
            }  

            //consulto la imagen
            if ($imagen == "no")
            {
                $imagen = "";
            }
            else
            {
                $imagen = "img/avatares/usuarios-$usuario_id-$imagen_nombre.jpg";
                $imagen = '<div class="rdm-tarjeta--media" style="background-image: url('.$imagen.');"></div>';
            }
            ?>

            <section class="rdm-tarjeta">

                <?php echo "$imagen"; ?>

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucwords("$nombres"); ?> <?php echo ucwords("$apellidos"); ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo ucfirst($tipo) ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">

                    <?php if (!empty($local)) { ?>
                        <p><b>Local</b> <br><?php echo ucfirst($local) ?></p>
                    <?php } ?>

                    <?php if (!empty($tipo)) { ?>
                        <p><b>Tipo</b> <br><?php echo ucfirst($tipo) ?></p>                        
                    <?php } ?>

                    <?php if (!empty($correo)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Correo electrónico</b> <br><a href="mailto:<?php echo ($correo) ?>"><?php echo ($correo) ?></a></p>
                    <?php } ?>

                    <?php if (!empty($contrasena)) { ?>
                        <p><b>Contraseña</b> <br><?php echo ($contrasena); ?></p>                        
                    <?php } ?>

                    <?php if (!empty($telefono)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Teléfono</b> <br><a href="https://api.whatsapp.com/send?phone=57<?php echo ucfirst($telefono) ?>" target="_blank"><?php echo ucfirst($telefono) ?></a></p>
                    <?php } ?>

                    <?php if (!empty($direccion)) { ?>
                        <p><b>Dirección</b> <br><a href="https://www.google.com/maps/search/?api=1&query=<?php echo ucfirst($direccion) ?>" target="_blank"><?php echo ucfirst($direccion) ?></a></p>
                    <?php } ?>

                    <?php if (!empty($fecha_nacimiento)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Cumpleaños</b> <br><?php echo ucfirst("$fecha_nacimiento"); ?></p>                        
                    <?php } ?>

                    <?php if (!empty($porcentaje_comision)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Porcentaje de comision</b> <br><?php echo ucfirst("$porcentaje_comision"); ?>%</p>                        
                    <?php } ?>

                    <?php if (!empty($usuario_alta)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Creado</b> <br><?php echo ucfirst("$fecha_alta"); ?> - <?php echo ucfirst("$hora_alta"); ?><br><?php echo ("$usuario_alta"); ?></p>
                    <?php } ?>

                    <?php if (!empty($usuario_mod)) { ?>
                        <p><b>Modificado</b> <br><?php echo ucfirst("$fecha_mod"); ?> - <?php echo ucfirst("$hora_mod"); ?><br><?php echo ("$usuario_mod"); ?></p>
                    <?php } ?>

                    <?php if (!empty($usuario_baja)) { ?>
                        <p><b>Eliminado</b> <br><?php echo ucfirst("$fecha_baja"); ?> - <?php echo ucfirst("$hora_baja"); ?><br><?php echo ("$usuario_baja"); ?></p>
                    <?php } ?>
                    
                    <p><b>Estado</b> <br><?php echo ucfirst($estado) ?></p>

                </div>

            </section>
            
            <?php
        }
    }
    ?>

</main>

<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>

<footer>
    
    <a href="usuarios_editar.php?usuario_id=<?php echo "$usuario_id"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>