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
//variables de edicion
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

//variables del formulario
if(isset($_POST['proveedor_id'])) $proveedor_id = $_POST['proveedor_id']; elseif(isset($_GET['proveedor_id'])) $proveedor_id = $_GET['proveedor_id']; else $proveedor_id = null;
if(isset($_POST['proveedor'])) $proveedor = $_POST['proveedor']; elseif(isset($_GET['proveedor'])) $proveedor = $_GET['proveedor']; else $proveedor = null;
if(isset($_POST['documento_tipo'])) $documento_tipo = $_POST['documento_tipo']; elseif(isset($_GET['documento_tipo'])) $documento_tipo = $_GET['documento_tipo']; else $documento_tipo = null;
if(isset($_POST['documento_numero'])) $documento_numero = $_POST['documento_numero']; elseif(isset($_GET['documento_numero'])) $documento_numero = $_GET['documento_numero']; else $documento_numero = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['correo'])) $correo = $_POST['correo']; elseif(isset($_GET['correo'])) $correo = $_GET['correo']; else $correo = null;
if(isset($_POST['contacto'])) $contacto = $_POST['contacto']; elseif(isset($_GET['contacto'])) $contacto = $_GET['contacto']; else $contacto = null;
if(isset($_POST['telefono'])) $telefono = $_POST['telefono']; elseif(isset($_GET['telefono'])) $telefono = $_GET['telefono']; else $telefono = null;
if(isset($_POST['direccion'])) $direccion = $_POST['direccion']; elseif(isset($_GET['direccion'])) $direccion = $_GET['direccion']; else $direccion = null;
if(isset($_POST['cuenta_bancaria'])) $cuenta_bancaria = $_POST['cuenta_bancaria']; elseif(isset($_GET['cuenta_bancaria'])) $cuenta_bancaria = $_GET['cuenta_bancaria']; else $cuenta_bancaria = null;

//variables de la imagen
if(isset($_POST['imagen'])) $imagen = $_POST['imagen']; elseif(isset($_GET['imagen'])) $imagen = $_GET['imagen']; else $imagen = null;
if(isset($_POST['imagen_nombre'])) $imagen_nombre = $_POST['imagen_nombre']; elseif(isset($_GET['imagen_nombre'])) $imagen_nombre = $_GET['imagen_nombre']; else $imagen_nombre = null;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información del proveedor
if ($editar == "si")
{
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
        $imagen_nombre = $ahora_img;
        $imagen_ref = "proveedores";
        $id = $proveedor_id;

        //si han cargado el archivo subimos la imagen        
        include('imagenes_subir.php');
    }
    else
    {
        $imagen = $imagen;
        $imagen_nombre = $imagen_nombre;
    }

    $actualizar = $conexion->query("UPDATE proveedor SET fecha_mod = '$ahora', usuario_mod = '$sesion_id', proveedor = '$proveedor', documento_tipo = '$documento_tipo', documento_numero = '$documento_numero', tipo = '$tipo', correo = '$correo', contacto = '$contacto', telefono = '$telefono', direccion = '$direccion', cuenta_bancaria = '$cuenta_bancaria', imagen = '$imagen', imagen_nombre = '$imagen_nombre' WHERE proveedor_id = '$proveedor_id'");

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
    <title>Proveedor - ManGo!</title>    
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
            <a href="proveedores_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Proveedor</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">
    
    <?php
    //consulto y muestro el proveedor
    $consulta = $conexion->query("SELECT * FROM proveedor WHERE proveedor_id = '$proveedor_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Este proveedor ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $proveedor_id = $fila['proveedor_id'];

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

            $proveedor = $fila['proveedor'];
            $documento_tipo = $fila['documento_tipo'];
            $documento_numero = $fila['documento_numero'];
            $tipo = $fila['tipo'];
            $correo = $fila['correo'];  
            $contacto = $fila['contacto'];  
            $telefono = $fila['telefono'];  
            $direccion = $fila['direccion'];  
            $cuenta_bancaria = $fila['cuenta_bancaria'];

            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];            

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
                $imagen = "img/avatares/proveedores-$proveedor_id-$imagen_nombre.jpg";
                $imagen = '<div class="rdm-tarjeta--media" style="background-image: url('.$imagen.');"></div>';
            }
            ?>

            <section class="rdm-tarjeta">

                <?php echo "$imagen"; ?>

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($proveedor) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo ucfirst($tipo) ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">

                    <?php if (!empty($documento_numero)) { ?>
                        <p><b>Documento</b> <br><?php echo ucfirst($documento_tipo) ?> <?php echo ucfirst($documento_numero) ?></p>
                    <?php } ?>

                    <?php if (!empty($tipo)) { ?>
                        <p><b>Tipo</b> <br><?php echo ucfirst($tipo) ?></p>
                    <?php } ?>

                    <?php if (!empty($contacto)) { ?>                        
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Contacto</b> <br><?php echo ucwords($contacto) ?></p>
                    <?php } ?>

                    <?php if (!empty($telefono)) { ?>
                        <p><b>Teléfono</b> <br><a href="https://api.whatsapp.com/send?phone=57<?php echo ucfirst($telefono) ?>" target="_blank"><?php echo ucfirst($telefono) ?></a></p>
                    <?php } ?>

                    <?php if (!empty($correo)) { ?>
                        <p><b>Correo electrónico</b> <br><a href="mailto:<?php echo ($correo) ?>"><?php echo ($correo) ?></a></p>
                    <?php } ?>

                    <?php if (!empty($direccion)) { ?>
                        <p><b>Dirección</b> <br><a href="https://www.google.com/maps/search/?api=1&query=<?php echo ucfirst($direccion) ?>" target="_blank"><?php echo ucfirst($direccion) ?></a></p>
                    <?php } ?>

                    <?php if (!empty($cuenta_bancaria)) { ?>
                        <p><b>Cuenta bancaria</b> <br><?php echo ucwords($cuenta_bancaria) ?></p>                        
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










    <?php
    //consulto los componentes relacionados a este proveedor
    $consulta = $conexion->query("SELECT * FROM componente WHERE estado = 'activo' and proveedor_id = '$proveedor_id' ORDER BY componente");

    if ($consulta->num_rows == 0)
    {
        ?>

        <h2 class="rdm-lista--titulo-largo">Componentes relacionados</h2>

        <section class="rdm-lista">
            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-info zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacío</h2>
                    </div>
                </div>
            </article>
        </section>

        <?php        
    }
    else
    {
        ?>

        <h2 class="rdm-lista--titulo-largo">Componentes relacionados</h2>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc())
        {
            $componente_id = $fila['componente_id'];
            $componente = $fila['componente'];
            $unidad_minima = $fila['unidad_minima'];
            $unidad_compra = $fila['unidad_compra'];
            $costo_unidad_minima = $fila['costo_unidad_minima'];
            $costo_unidad_compra = $fila['costo_unidad_compra'];

            $proveedor_id = $fila['proveedor_id'];

            //color de fondo segun la primer letra
            $avatar_id = $componente_id;
            $avatar_nombre = "$componente";

            include ("sis/avatar_color.php");
            
            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';            
            ?>                       

            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <?php echo "$imagen"; ?>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo"><?php echo ucfirst($componente); ?></h2>
                        <h2 class="rdm-lista--texto-secundario">$<?php echo number_format($costo_unidad_compra, 2, ",", "."); ?> x <?php echo ucfirst($unidad_compra); ?></h2>
                    </div>
                </div>
            </article>
            
            <?php
        }
    }
    ?>

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
    
    <a href="proveedores_editar.php?proveedor_id=<?php echo "$proveedor_id"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>