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
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;

//variables del formulario
if(isset($_POST['producto_precio_id'])) $producto_precio_id = $_POST['producto_precio_id']; elseif(isset($_GET['producto_precio_id'])) $producto_precio_id = $_GET['producto_precio_id']; else $producto_precio_id = null;

//variables del formulario
if(isset($_POST['nombre'])) $nombre = $_POST['nombre']; elseif(isset($_GET['nombre'])) $nombre = $_GET['nombre']; else $nombre = null;
if(isset($_POST['precio'])) $precio = $_POST['precio']; elseif(isset($_GET['precio'])) $precio = $_GET['precio']; else $precio = null;
if(isset($_POST['impuesto_incluido'])) $impuesto_incluido = $_POST['impuesto_incluido']; elseif(isset($_GET['impuesto_incluido'])) $impuesto_incluido = $_GET['impuesto_incluido']; else $impuesto_incluido = "no";
if(isset($_POST['precio_principal'])) $precio_principal = $_POST['precio_principal']; elseif(isset($_GET['precio_principal'])) $precio_principal = $_GET['precio_principal']; else $precio_principal = "no";

//variables foraneas
if(isset($_POST['producto_id'])) $producto_id = $_POST['producto_id']; elseif(isset($_GET['producto_id'])) $producto_id = $_GET['producto_id']; else $producto_id = 0;
if(isset($_POST['impuesto_id'])) $impuesto_id = $_POST['impuesto_id']; elseif(isset($_GET['impuesto_id'])) $impuesto_id = $_GET['impuesto_id']; else $impuesto_id = 0;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php 
//actualizo el precio
if ($editar == "si")
{
    $precio = str_replace('.','',$precio);

    $actualizar_precio = $conexion->query("UPDATE producto_precio SET fecha_mod = '$ahora', usuario_mod = '$sesion_id', nombre = '$nombre', precio = '$precio', impuesto_incluido = '$impuesto_incluido', impuesto_id = '$impuesto_id' WHERE producto_precio_id = '$producto_precio_id'");



    if ($precio_principal == "si")
    {
        $actualizar_precio = $conexion->query("UPDATE producto_precio SET tipo = 'secundario' WHERE producto_id = '$producto_id'");
        $actualizar_precio = $conexion->query("UPDATE producto_precio SET tipo = 'principal' WHERE producto_precio_id = '$producto_precio_id'");
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Precio - ManGo!</title>    
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
            <a href="productos_detalle.php?producto_id=<?php echo "$producto_id"; ?>#precios"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Precio</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro el producto
    $consulta = $conexion->query("SELECT * FROM producto WHERE producto_id = '$producto_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Este producto ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $producto_id = $fila['producto_id'];

            $producto = $fila['producto'];

            $categoria_id = $fila['categoria_id'];

            //consulto la categoria
            $consulta_categoria = $conexion->query("SELECT * FROM categoria WHERE categoria_id = '$categoria_id'");           

            if ($fila = $consulta_categoria->fetch_assoc()) 
            {
                $categoria = $fila['categoria'];
            }
            else
            {
                $categoria = "No se ha asignado una categoria";
            }

            //consulto el precio
            $consulta_precio_pal = $conexion->query("SELECT * FROM producto_precio WHERE producto_id = '$producto_id' and producto_precio_id = '$producto_precio_id'");           

            if ($fila = $consulta_precio_pal->fetch_assoc()) 
            {
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

                $nombre = $fila['nombre'];
                $precio = $fila['precio'];
                $tipo = $fila['tipo'];
                $impuesto_incluido = $fila['impuesto_incluido'];
                $impuesto_id = $fila['impuesto_id'];

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

                //consulto el impuesto
                $consulta_impuesto = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id = '$impuesto_id'");           

                if ($fila_impuesto = $consulta_impuesto->fetch_assoc()) 
                {
                    $impuesto = $fila_impuesto['impuesto'];
                    $impuesto_porcentaje = $fila_impuesto['porcentaje'];
                }
            }
            else
            {
                $precio = 0;
                $impuesto_incluido = "";
                $impuesto_id = "";
                $impuesto = "";
                $impuesto_porcentaje = 0;
            }

            //calculo el valor del precio bruto y el precio neto
            if ($impuesto_incluido == "si")
            {
                $base_valor = $precio / ($impuesto_porcentaje / 100 + 1);
                $impuesto_valor = $precio - $base_valor;
                $precio_neto = $base_valor + $impuesto_valor;
            }
            else
            {
                $base_valor = $precio;
                $impuesto_valor = ($precio * $impuesto_porcentaje) / 100;
                $precio_neto = $base_valor + $impuesto_valor;
            }
            ?>

            <section class="rdm-tarjeta">

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($nombre) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo ucfirst($tipo) ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">

                    <?php if (!empty($precio_neto)) { ?>
                        <p><b>Precio</b> <br>$<?php echo number_format($precio_neto, 2, ",", "."); ?></p>
                    <?php } ?>

                    <?php if (!empty($base_valor)) { ?>
                        <p><b>Base</b> <br>$<?php echo number_format($base_valor, 2, ",", "."); ?></p>
                    <?php } ?>

                    <?php if (!empty($impuesto)) { ?>
                        <p><b><?php echo ucfirst($impuesto) ?> <?php echo ($impuesto_porcentaje); ?>%</b> <br>$<?php echo number_format($impuesto_valor, 2, ",", "."); ?></p>
                    <?php } ?>

                    <?php if (!empty($impuesto_incluido)) { ?>
                        <p><b>Impuesto incluido</b> <br><?php echo ucfirst($impuesto_incluido); ?></p>
                        <div class="rdm-tarjeta--separador"></div>
                    <?php } ?>

                    <?php if (!empty($producto)) { ?>
                        <p><b>Producto</b> <br><?php echo ucfirst($producto); ?></p>
                    <?php } ?>

                    <?php if (!empty($categoria)) { ?>
                        <p><b>Categoría</b> <br><?php echo ucfirst($categoria); ?></p>
                        <div class="rdm-tarjeta--separador"></div>
                    <?php } ?>


                    

                    

                    <?php if (!empty($usuario_alta)) { ?>
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
    
    <a href="productos_precios_editar.php?producto_id=<?php echo "$producto_id"; ?>&producto_precio_id=<?php echo "$producto_precio_id"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>