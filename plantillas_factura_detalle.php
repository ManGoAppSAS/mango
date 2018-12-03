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
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

//variables del formulario
if(isset($_POST['plantilla_factura_id'])) $plantilla_factura_id = $_POST['plantilla_factura_id']; elseif(isset($_GET['plantilla_factura_id'])) $plantilla_factura_id = $_GET['plantilla_factura_id']; else $plantilla_factura_id = null;
if(isset($_POST['titulo'])) $titulo = $_POST['titulo']; elseif(isset($_GET['titulo'])) $titulo = $_GET['titulo']; else $titulo = null;
if(isset($_POST['prefijo'])) $prefijo = $_POST['prefijo']; elseif(isset($_GET['prefijo'])) $prefijo = $_GET['prefijo']; else $prefijo = null;
if(isset($_POST['numero_inicio'])) $numero_inicio = $_POST['numero_inicio']; elseif(isset($_GET['numero_inicio'])) $numero_inicio = $_GET['numero_inicio']; else $numero_inicio = 1;
if(isset($_POST['numero_fin'])) $numero_fin = $_POST['numero_fin']; elseif(isset($_GET['numero_fin'])) $numero_fin = $_GET['numero_fin']; else $numero_fin = null;
if(isset($_POST['sufijo'])) $sufijo = $_POST['sufijo']; elseif(isset($_GET['sufijo'])) $sufijo = $_GET['sufijo']; else $sufijo = null;
if(isset($_POST['encabezado'])) $encabezado = $_POST['encabezado']; elseif(isset($_GET['encabezado'])) $encabezado = $_GET['encabezado']; else $encabezado = null;
if(isset($_POST['mostrar_atendido'])) $mostrar_atendido = $_POST['mostrar_atendido']; elseif(isset($_GET['mostrar_atendido'])) $mostrar_atendido = $_GET['mostrar_atendido']; else $mostrar_atendido = "no";
if(isset($_POST['mostrar_impuesto'])) $mostrar_impuesto = $_POST['mostrar_impuesto']; elseif(isset($_GET['mostrar_impuesto'])) $mostrar_impuesto = $_GET['mostrar_impuesto']; else $mostrar_impuesto = "no";
if(isset($_POST['pie'])) $pie = $_POST['pie']; elseif(isset($_GET['pie'])) $pie = $_GET['pie']; else $pie = null;
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
//actualizo la información de la plantilla de facturación
if ($editar == "si")
{
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
        $imagen_nombre = $ahora_img;
        $imagen_ref = "plantillas_factura";
        $id = $plantilla_factura_id;

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $imagen = $imagen;
        $imagen_nombre = $imagen_nombre;
    }
    
    $actualizar = $conexion->query("UPDATE plantilla_factura SET fecha_mod = '$ahora', usuario_mod = '$sesion_id', titulo = '$titulo', prefijo = '$prefijo', numero_inicio = '$numero_inicio', numero_fin = '$numero_fin', sufijo = '$sufijo', encabezado = '$encabezado', mostrar_atendido = '$mostrar_atendido', mostrar_impuesto = '$mostrar_impuesto', pie = '$pie', imagen = '$imagen', imagen_nombre = '$imagen_nombre', local_id = '$local_id' WHERE plantilla_factura_id = '$plantilla_factura_id'");

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
    <title>Plantilla de factura - ManGo!</title>    
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
            <a href="plantillas_factura_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Plantilla de factura</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro la plantila de factura
    $consulta = $conexion->query("SELECT * FROM plantilla_factura WHERE plantilla_factura_id = '$plantilla_factura_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Esta plantilla de factura ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $plantilla_factura_id = $fila['plantilla_factura_id'];
            
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

            $titulo = $fila['titulo'];
            $prefijo = $fila['prefijo'];
            $numero_inicio = $fila['numero_inicio'];
            $numero_fin = $fila['numero_fin'];
            $numero_longitud = strlen($numero_fin);
            $numero_relleno = str_pad($numero_inicio, $numero_longitud, "0", STR_PAD_LEFT);
            $sufijo = $fila['sufijo'];
            $encabezado = $fila['encabezado'];
            $mostrar_atendido = $fila['mostrar_atendido'];
            $mostrar_impuesto = $fila['mostrar_impuesto'];
            $pie = $fila['pie'];

            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];

            $local_id = $fila['local_id'];

            //consulto el local
            $consulta_local = $conexion->query("SELECT * FROM local WHERE local_id = '$local_id'");           

            if ($fila = $consulta_local->fetch_assoc()) 
            {
                $nit = $fila['nit'];
                $regimen = $fila['regimen'];
                $local = $fila['local'];
                $direccion = $fila['direccion'];
                $telefono = $fila['telefono'];
            }
            else
            {
                $nit = "";
                $regimen = "";
                $local = "";
                $direccion = "";
                $telefono = "";

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

            //logo de la plantilla
            $logo = "img/avatares/plantillas_factura-$plantilla_factura_id-$imagen_nombre.jpg";
            ?>

            <section class="rdm-tarjeta">

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($titulo) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo ucfirst($local) ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">

                    <?php if (!empty($nit)) { ?>
                        <p><b>NIT</b> <br><?php echo ucfirst($nit) ?></p>
                    <?php } ?>

                    <?php if (!empty($regimen)) { ?>
                        <p><b>Texto de régimen</b> <br><?php echo ucfirst($regimen) ?></p>
                        <div class="rdm-tarjeta--separador"></div>
                    <?php } ?>

                    <?php if ($imagen == "si") { ?>
                        <p><b>Logo</b> <br><?php echo ("Si"); ?></p>
                    <?php } ?>

                    <?php if (!empty($local)) { ?>
                        <p><b>Local</b> <br><?php echo ucfirst($local) ?></p>
                        <div class="rdm-tarjeta--separador"></div>
                    <?php } ?>

                    <?php if (!empty($prefijo)) { ?>
                        <p><b>Prefijo de facturación (ABC...)</b> <br><?php echo ucfirst($prefijo) ?></p>
                    <?php } ?>

                    <?php if (!empty($numero_inicio)) { ?>
                        <p><b>Número inicio</b> <br><?php echo ($numero_relleno); ?></p>
                    <?php } ?>

                    <?php if (!empty($numero_fin)) { ?>
                        <p><b>Número fin</b> <br><?php echo ($numero_fin); ?></p>
                    <?php } ?>

                    <?php if (!empty($sufijo)) { ?>
                        <p><b>Sufijo de facturación (...ABC)</b> <br><?php echo ucfirst($sufijo) ?></p>
                    <?php } ?>

                    <?php if (!empty($encabezado)) { ?>
                        <p><b>Encabezado</b> <br><?php echo ucfirst(nl2br($encabezado)); ?></p>                        
                    <?php } ?>

                    <?php if (!empty($mostrar_atendido)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Atendido por</b> <br><?php echo ucfirst($mostrar_atendido) ?></p>
                    <?php } ?>

                    <?php if (!empty($mostrar_impuesto)) { ?>
                        <p><b>Impuestos en cada producto/servicio</b> <br><?php echo ucfirst($mostrar_impuesto) ?></p>                        
                    <?php } ?>

                    <?php if (!empty($pie)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Pié de página</b> <br><?php echo ucfirst(nl2br($pie)); ?></p>                        
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

    <h2 class="rdm-lista--titulo-largo">Vista previa</h2>

    <section class="rdm-lista-sencillo">

        <a class="ancla" name="ticket"></a>
                
        <a href="plantillas_factura_detalle_ticket.php?plantilla_factura_id=<?php echo "$plantilla_factura_id"; ?>">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-receipt zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Ticket</h2>
                    </div>
                </div>
                
            </article>

        </a>        

        <a class="ancla" name="factura"></a>
        
        <a href="plantillas_factura_detalle_factura.php?plantilla_factura_id=<?php echo "$plantilla_factura_id"; ?>">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-file-text zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Factura</h2>
                    </div>
                </div>
                
            </article>

        </a>

    </section>

</main>

<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>

<footer>
    
    <a href="plantillas_factura_editar.php?plantilla_factura_id=<?php echo "$plantilla_factura_id"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>