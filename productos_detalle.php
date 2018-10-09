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
//variable para eliminar el precio
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;
if(isset($_POST['producto_precio_id'])) $producto_precio_id = $_POST['producto_precio_id']; elseif(isset($_GET['producto_precio_id'])) $producto_precio_id = $_GET['producto_precio_id']; else $producto_precio_id = null;

//capturo las variables que pasan por URL o formulario
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;
if(isset($_POST['editar_permisos'])) $editar_permisos = $_POST['editar_permisos']; elseif(isset($_GET['editar_permisos'])) $editar_permisos = $_GET['editar_permisos']; else $editar_permisos = null;
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

//variables del formulario
if(isset($_POST['producto_id'])) $producto_id = $_POST['producto_id']; elseif(isset($_GET['producto_id'])) $producto_id = $_GET['producto_id']; else $producto_id = null;
if(isset($_POST['producto'])) $producto = $_POST['producto']; elseif(isset($_GET['producto'])) $producto = $_GET['producto']; else $producto = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['descripcion'])) $descripcion = $_POST['descripcion']; elseif(isset($_GET['descripcion'])) $descripcion = $_GET['descripcion']; else $descripcion = null;
if(isset($_POST['codigo_barras'])) $codigo_barras = $_POST['codigo_barras']; elseif(isset($_GET['codigo_barras'])) $codigo_barras = $_GET['codigo_barras']; else $codigo_barras = null;

//variables foraneas
if(isset($_POST['categoria_id'])) $categoria_id = $_POST['categoria_id']; elseif(isset($_GET['categoria_id'])) $categoria_id = $_GET['categoria_id']; else $categoria_id = 0;
if(isset($_POST['zona_entrega_id'])) $zona_entrega_id = $_POST['zona_entrega_id']; elseif(isset($_GET['zona_entrega_id'])) $zona_entrega_id = $_GET['zona_entrega_id']; else $zona_entrega_id = 0;

//variables del checkbox
if(isset($_POST['local_id'])) $local_id = $_POST['local_id']; elseif(isset($_GET['local_id'])) $local_id = $_GET['local_id']; else $local_id = 0;

//variables que van al precio
if(isset($_POST['precio'])) $precio = $_POST['precio']; elseif(isset($_GET['precio'])) $precio = $_GET['precio']; else $precio = null;
if(isset($_POST['impuesto_incluido'])) $impuesto_incluido = $_POST['impuesto_incluido']; elseif(isset($_GET['impuesto_incluido'])) $impuesto_incluido = $_GET['impuesto_incluido']; else $impuesto_incluido = "no";
if(isset($_POST['impuesto_id'])) $impuesto_id = $_POST['impuesto_id']; elseif(isset($_GET['impuesto_id'])) $impuesto_id = $_GET['impuesto_id']; else $impuesto_id = 0;

//variables de la imagen
if(isset($_POST['imagen'])) $imagen = $_POST['imagen']; elseif(isset($_GET['imagen'])) $imagen = $_GET['imagen']; else $imagen = null;
if(isset($_POST['imagen_nombre'])) $imagen_nombre = $_POST['imagen_nombre']; elseif(isset($_GET['imagen_nombre'])) $imagen_nombre = $_GET['imagen_nombre']; else $imagen_nombre = null;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información del producto
if ($editar == "si")
{
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
        $imagen_nombre = $ahora_img;
        $imagen_ref = "productos";
        $id = $producto_id;

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $imagen = $imagen;
        $imagen_nombre = $imagen_nombre;
    }

    $precio = str_replace('.','',$precio);
    
    $actualizar = $conexion->query("UPDATE producto SET fecha_mod = '$ahora', usuario_mod = '$sesion_id', producto = '$producto', tipo = '$tipo', descripcion = '$descripcion', codigo_barras = '$codigo_barras', imagen = '$imagen', imagen_nombre = '$imagen_nombre', categoria_id = '$categoria_id', zona_entrega_id = '$zona_entrega_id' WHERE producto_id = '$producto_id'");    

    if ($actualizar)
    {
        $mensaje = "Cambios guardados";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";

        $agregar_producto_local = "si";
    }     
}
?>

<?php 
//actualizo el precio
if ($editar == "si")
{
    //consulto si ya existe un precio principal
    $consulta = $conexion->query("SELECT * FROM producto_precio WHERE producto_id = '$producto_id' and tipo = 'principal' and estado = 'activo'");

    if ($consulta->num_rows == 0)
    {
        //ingreso el precio principal
        $insercion_precio = $conexion->query("INSERT INTO producto_precio values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', 'precio normal', 'principal', '$precio', '$impuesto_incluido', '$producto_id', '$impuesto_id')");
    }
    else
    {
        //si ya existe actualizo el precio principal
        $actualizar_precio = $conexion->query("UPDATE producto_precio SET fecha_mod = '$ahora', usuario_mod = '$sesion_id', precio = '$precio', impuesto_incluido = '$impuesto_incluido', impuesto_id = '$impuesto_id' WHERE producto_id = '$producto_id' and tipo = 'principal'");        
    }
}
?>

<?php
//actualizo el producto a los locales en que se vende
error_reporting(0);
if ($agregar_producto_local == 'si')
{    
    $borrar = $conexion->query("DELETE FROM producto_local WHERE producto_id = '$producto_id'");

    foreach ($local_id as $local_id)
    {        
        $consulta = $conexion->query("SELECT * FROM producto_local WHERE local_id = '$local_id' and producto_id = '$producto_id'");

        if ($consulta->num_rows == 0)
        {
            $insercion = $conexion->query("INSERT INTO producto_local VALUES ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$producto_id', '$local_id')");
        }
    }
}
?>

<?php
//elimino el precio
if ($eliminar == 'si')
{
    //borro los datos del precio
    $borrar_precio = $conexion->query("UPDATE producto_precio SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE producto_precio_id = '$producto_precio_id'");
    
    if ($borrar_precio)
    {
        $mensaje = "Precio eliminado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "No es posible eliminar el precio";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Producto - ManGo!</title>    
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
            <a href="productos_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Producto</h2>
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

            $producto = $fila['producto'];
            $tipo = $fila['tipo'];
            $descripcion = $fila['descripcion'];
            $codigo_barras = $fila['codigo_barras'];            

            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];

            $categoria_id = $fila['categoria_id'];
            $zona_entrega_id = $fila['zona_entrega_id'];

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

            //consulto la zona de entrega
            $consulta_zona_entrega = $conexion->query("SELECT * FROM zona_entrega WHERE zona_entrega_id = '$zona_entrega_id'");           

            if ($fila = $consulta_zona_entrega->fetch_assoc()) 
            {
                $zona_entrega = $fila['zona_entrega'];
            }
            else
            {
                $zona_entrega = "No se ha asignado una zona de entrega";
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
                $imagen = "img/avatares/productos-$producto_id-$imagen_nombre.jpg";
                $imagen = '<div class="rdm-tarjeta--media" style="background-image: url('.$imagen.');"></div>';
            }

            //consulto el precio principal
            $consulta_precio_pal = $conexion->query("SELECT * FROM producto_precio WHERE producto_id = '$producto_id' and tipo = 'principal' and estado = 'activo'");           

            if ($fila = $consulta_precio_pal->fetch_assoc()) 
            {
                //precio
                $precio = $fila['precio'];
                $impuesto_incluido = $fila['impuesto_incluido'];
                $impuesto_id = $fila['impuesto_id'];

                //consulto el impuesto
                $consulta_impuesto = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id = '$impuesto_id'");           

                if ($fila_impuesto = $consulta_impuesto->fetch_assoc()) 
                {
                    $impuesto = $fila_impuesto['impuesto'];
                    $impuesto_porcentaje = $fila_impuesto['porcentaje'];
                }
                else
                {
                    $impuesto = "sin impuesto";
                    $impuesto_porcentaje = 0;
                }
            }
            else
            {
                //precio
                $precio = 0;
                $impuesto_incluido = "no";

                $impuesto = "sin impuesto";
                $impuesto_porcentaje = 0;
            }





            //calculo el valor de la base y el impuesto en el precio
            if ($impuesto_incluido == "si")
            {
                //valor de la base
                $base_valor = $precio / ($impuesto_porcentaje / 100 + 1);

                //valor del impuesto
                $impuesto_valor = $precio - $base_valor;

                //precio
                $precio = $base_valor + $impuesto_valor;
            }
            else
            {
                //valor de la base
                $base_valor = $precio;

                //valor del impuesto
                $impuesto_valor = ($precio * $impuesto_porcentaje) / 100;

                //precio
                $precio = $base_valor + $impuesto_valor;
            }





            //consulto el costo
            $consulta_costo = $conexion->query("SELECT * FROM producto_composicion WHERE producto_id = '$producto_id' ORDER BY fecha_alta DESC");

            if ($consulta_costo->num_rows != 0)
            {
                $composicion_costo = 0;
                
                while ($fila = $consulta_costo->fetch_assoc())
                {
                    //datos de la composicion
                    $producto_composicion_id = $fila['producto_composicion_id'];
                    $cantidad = $fila['cantidad'];
                    $componente_id = $fila['componente_id'];

                    //consulto el componente
                    $consulta2 = $conexion->query("SELECT * FROM componente WHERE componente_id = $componente_id");

                    if ($filas2 = $consulta2->fetch_assoc())
                    {            
                        $unidad_minima = $filas2['unidad_minima'];
                        $costo_unidad_minima = $filas2['costo_unidad_minima'];            
                    }
                    else
                    {            
                        $unidad_minima = "unid";
                        $costo_unidad_minima = 0;
                    }

                    //costo del componente
                    $componente_costo = $costo_unidad_minima * $cantidad;

                    //costo de la composicion
                    $composicion_costo = $composicion_costo + $componente_costo;
                }

                //valor del costo
                $costo_valor = $composicion_costo;

                //porcentaje del costo
                $costo_porcentaje = $costo_valor / $base_valor * 100;
            }
            else                 
            {
                //valor del costo
                $costo_valor = 0;

                //porcentaje del costo
                $costo_porcentaje = 0;
            }






            //utilidad
            $utilidad_valor = $base_valor - $costo_valor;
            $utilidad_porcentaje = $utilidad_valor / $base_valor * 100;    
            ?>

            <section class="rdm-tarjeta">

                <?php echo "$imagen"; ?>

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($producto) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo ucfirst($categoria) ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">

                    
                    <p><b>Precio</b> <br>$<?php echo number_format($precio, 2, ",", "."); ?></p>
                    
                    <p><b>Base</b> <br>$<?php echo number_format($base_valor, 2, ",", "."); ?></p>
                    
                    <p><b><?php echo ucfirst($impuesto) ?> <?php echo ($impuesto_porcentaje); ?>%</b> <br>$<?php echo number_format($impuesto_valor, 2, ",", "."); ?></p>

                    <?php if (!empty($impuesto_incluido)) { ?>
                        <p><b>Impuesto incluido</b> <br><?php echo ucfirst($impuesto_incluido); ?></p>
                    <?php } ?>

                    <?php if (!empty($tipo)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Tipo de inventario</b> <br><?php echo ucfirst($tipo) ?></p>
                    <?php } ?>

                    <?php if (!empty($precio)) { ?>
                        <p><b>Costo</b> <br><span class="rdm-lista--texto-negativo">$<?php echo number_format($costo_valor, 2, ",", "."); ?> (<?php echo number_format($costo_porcentaje, 2, ",", "."); ?>%)</span></p>
                    <?php } ?>

                    <?php if (!empty($precio)) { ?>
                        <p><b>Utilidad</b> <br><span class="rdm-lista--texto-positivo">$<?php echo number_format($utilidad_valor, 2, ",", "."); ?> (<?php echo number_format($utilidad_porcentaje, 2, ",", "."); ?>%)</span></p>
                    <?php } ?>

                    <?php
                    //consulto y muestro la union entre productos y locales
                    $consulta_union_producto_local = $conexion->query("SELECT * FROM producto_local WHERE producto_id = '$producto_id' ORDER BY producto_local_id");                

                    if ($consulta_union_producto_local->num_rows == 0)
                    {
                        
                    }
                    else
                    {
                        ?>
                        
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Local en que se vende</b> <br>

                        <?php
                        while ($fila = $consulta_union_producto_local->fetch_assoc()) 
                        {                            
                            $local_id = $fila['local_id'];

                            //consulto el local
                            $consulta_local = $conexion->query("SELECT * FROM local WHERE local_id = '$local_id'");           

                            if ($fila = $consulta_local->fetch_assoc()) 
                            {
                                $local = $fila['local'];
                                $local = "$local <br>";
                            }
                            else
                            {
                                $local = "";
                            }

                            ?>

                            <?php echo ucfirst($local) ?>

                            <?php
                        }

                        ?>

                        </p>

                        <?php
                    }                    
                    ?>

                    <?php if (!empty($zona_entrega)) { ?>
                        <p><b>Zona de entregas</b> <br><?php echo ucfirst($zona_entrega); ?></p>
                    <?php } ?>

                    <?php if (!empty($descripcion)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Descripción</b> <br><?php echo ucfirst($descripcion); ?></p>
                    <?php } ?>

                    <?php if (!empty($codigo_barras)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Código de barras</b> <br><?php echo ucfirst($codigo_barras); ?></p>
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
    //consulto los precios de este producto
    $consulta = $conexion->query("SELECT * FROM producto_precio WHERE producto_id = '$producto_id' and estado = 'activo' ORDER BY tipo, nombre");

    if ($consulta->num_rows == 0)
    {
        ?>

        <h2 class="rdm-lista--titulo-largo">Lista de precios</h2>

        <section class="rdm-lista">
            
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-info zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>
                        <h2 class="rdm-lista--texto-secundario">Agregar diferentes precios para el mismo producto o servicio. Ej: Precio al por mayor, precio distribuidor, precio franquiciado, etc.</h2>
                    </div>
                </div>
                
            </article>

            <div class="rdm-tarjeta--separador"></div>

            <div class="rdm-tarjeta--acciones-izquierda">
                <a href="productos_precios_agregar.php?producto_id=<?php echo "$producto_id"; ?>"><button class="rdm-boton--plano-resaltado">Agregar</button></a>
            </div>

        </section>

        
        <?php
    }
    else
    {   ?>

        <a id="precios">

        <h2 class="rdm-lista--titulo-largo">Lista de precios</h2>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc())
        {
            $producto_precio_id = $fila['producto_precio_id'];
            $nombre = $fila['nombre'];
            $tipo = $fila['tipo'];
            $precio = $fila['precio'];
            $impuesto_incluido = $fila['impuesto_incluido'];
            $impuesto_id = $fila['impuesto_id'];

            //consulto el impuesto
            $consulta_impuesto = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id = '$impuesto_id'");           

            if ($fila_impuesto = $consulta_impuesto->fetch_assoc()) 
            {
                $impuesto = $fila_impuesto['impuesto'];
                $impuesto_porcentaje = $fila_impuesto['porcentaje'];
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

            //color de fondo segun la primer letra
            $primera_letra = "$nombre";
            include ("sis/avatar_color.php");

            //consulto el avatar
            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: '.$avatar_color_fondo.'">'.strtoupper(substr($nombre, 0, 1)).'</div>';  

            //consulto la categoria
            $consulta2 = $conexion->query("SELECT * FROM categoria WHERE categoria_id = $categoria_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $categoria = $filas2['categoria'];
            }
            else
            {
                $categoria = "No se ha asignado una categoria";
            }
            ?>

            <a href="productos_precios_detalle.php?producto_id=<?php echo "$producto_id"; ?>&producto_precio_id=<?php echo "$producto_precio_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst($nombre); ?></h2>
                            <h2 class="rdm-lista--texto-secundario">$<?php echo number_format($precio_neto, 2, ",", "."); ?></h2>
                        </div>
                    </div>
                </article>
            </a>
            
        <?php
        }
        ?>

        <div class="rdm-tarjeta--separador"></div>

        <div class="rdm-tarjeta--acciones-izquierda">
            <a href="productos_precios_agregar.php?producto_id=<?php echo "$producto_id"; ?>"><button class="rdm-boton--plano-resaltado">Agregar</button></a>
        </div>

        </section>

    <?php
    }
    ?>





































    <?php
    //consulto la composicion de este producto
    $consulta = $conexion->query("SELECT * FROM producto_composicion WHERE producto_id = '$producto_id' and estado = 'activo' ORDER BY fecha_alta DESC");

    if ($consulta->num_rows == 0)
    {
        ?>

        <h2 class="rdm-lista--titulo-largo">Composición</h2>

        <section class="rdm-lista">
            
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-info zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>
                        <h2 class="rdm-lista--texto-secundario">La composición son los componentes o ingredientes de los cuales está hecho un producto o servicio. Estos componentes o ingredientes se descontarán del inventario según la cantidad que se haya indicado</h2>
                    </div>
                </div>
            </article>

            <div class="rdm-tarjeta--separador"></div>

            <div class="rdm-tarjeta--acciones-izquierda">
                <a href="productos_composicion.php?producto_id=<?php echo "$producto_id"; ?>"><button class="rdm-boton--plano-resaltado">Editar</button></a>
            </div>

        </section>

        
        <?php
    }
    else
    {   ?>

        <a id="composicion">

        <h2 class="rdm-lista--titulo-largo">Composición</h2>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc())
        {
            //datos de la composicion
            $producto_composicion_id = $fila['producto_composicion_id'];            
            $cantidad = $fila['cantidad'];
            $componente_id = $fila['componente_id'];

            //consulto el componente
            $consulta2 = $conexion->query("SELECT * FROM componente WHERE componente_id = $componente_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $componente = $filas2['componente'];
                $unidad_minima = $filas2['unidad_minima'];
                $costo_unidad_minima = $filas2['costo_unidad_minima'];

                //color de fondo segun la primer letra
                $primera_letra = "$componente";
                include ("sis/avatar_color.php");            

                //consulto el avatar
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: '.$avatar_color_fondo.'">'.strtoupper(substr($componente, 0, 1)).'</div>';
            }
            else
            {
                $componente = "No se ha asignado un componente";
                $unidad_minima = "";
                $costo_unidad_minima = 0;
            }

            //calculo el costo del producto
            $producto_costo = $costo_unidad_minima * $cantidad;
            ?>

            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <?php echo "$imagen"; ?>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo"><?php echo ($cantidad); ?> <?php echo ucfirst($unidad_minima); ?> de <?php echo ucfirst($componente); ?></h2>
                        <h2 class="rdm-lista--texto-secundario">$<?php echo number_format($producto_costo, 2, ",", "."); ?></h2>
                    </div>
                </div>
                <div class="rdm-lista--derecha-sencillo">
                    
                </div>
            </article>
            
        <?php
        }
        ?>

        <div class="rdm-tarjeta--separador"></div>

        <div class="rdm-tarjeta--acciones-izquierda">
            <a href="productos_composicion.php?producto_id=<?php echo "$producto_id"; ?>"><button class="rdm-boton--plano-resaltado">Editar</button></a>
        </div>

        </section>

    <?php
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
    
    <a href="productos_editar.php?producto_id=<?php echo "$producto_id"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>