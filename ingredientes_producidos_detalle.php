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
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;

//variables del formulario
if(isset($_POST['ingrediente_producido_id'])) $ingrediente_producido_id = $_POST['ingrediente_producido_id']; elseif(isset($_GET['ingrediente_producido_id'])) $ingrediente_producido_id = $_GET['ingrediente_producido_id']; else $ingrediente_producido_id = null;
if(isset($_POST['ingrediente'])) $ingrediente = $_POST['ingrediente']; elseif(isset($_GET['ingrediente'])) $ingrediente = $_GET['ingrediente']; else $ingrediente = null;
if(isset($_POST['unidad_minima'])) $unidad_minima = $_POST['unidad_minima']; elseif(isset($_GET['unidad_minima'])) $unidad_minima = $_GET['unidad_minima']; else $unidad_minima = null;
if(isset($_POST['unidad_compra'])) $unidad_compra = $_POST['unidad_compra']; elseif(isset($_GET['unidad_compra'])) $unidad_compra = $_GET['unidad_compra']; else $unidad_compra = null;
if(isset($_POST['costo_unidad_minima'])) $costo_unidad_minima = $_POST['costo_unidad_minima']; elseif(isset($_GET['costo_unidad_minima'])) $costo_unidad_minima = $_GET['costo_unidad_minima']; else $costo_unidad_minima = 0;
if(isset($_POST['costo_unidad_compra'])) $costo_unidad_compra = $_POST['costo_unidad_compra']; elseif(isset($_GET['costo_unidad_compra'])) $costo_unidad_compra = $_GET['costo_unidad_compra']; else $costo_unidad_compra = 0;
if(isset($_POST['cantidad_unidad_compra'])) $cantidad_unidad_compra = $_POST['cantidad_unidad_compra']; elseif(isset($_GET['cantidad_unidad_compra'])) $cantidad_unidad_compra = $_GET['cantidad_unidad_compra']; else $cantidad_unidad_compra = null;
if(isset($_POST['productor_id'])) $productor_id = $_POST['productor_id']; elseif(isset($_GET['productor_id'])) $productor_id = $_GET['productor_id']; else $productor_id = 0;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información del ingrediente producido
if ($editar == "si")
{
    //calculo la unidad minima con base a la unidad de compra
    if (($unidad_compra == "kg") or ($unidad_compra == "arroba 12.5 kg") or ($unidad_compra == "bulto 25 kg") or ($unidad_compra == "bulto 50 kg"))
    {
        $unidad_minima = "g";
    }
    else
    {
    if (($unidad_compra == "l") or ($unidad_compra == "botella 375 ml") or ($unidad_compra == "botella 750 ml") or ($unidad_compra == "botella 1500 ml") or ($unidad_compra == "garrafa 2000 ml") or ($unidad_compra == "galon 3.7 l") or ($unidad_compra == "botella 5 l") or ($unidad_compra == "botellon 18 l") or ($unidad_compra == "botellon 20 l") or ($unidad_compra == "botella 3 l"))
        {
            $unidad_minima = "ml";
        }
        else
        {
            if ($unidad_compra == "m")
            {
                $unidad_minima = "mm";
            }
            else
            {
                if (($unidad_compra == "par") or ($unidad_compra == "trio") or ($unidad_compra == "decena") or ($unidad_compra == "docena") or ($unidad_compra == "quincena") or ($unidad_compra == "treintena") or ($unidad_compra == "centena"))
                {
                    $unidad_minima = "unid";
                }
                else
                {
                    $unidad_minima = $unidad_compra;
                }
            }
        }
    }

    //si la unidad es kilos, litros o metros se divide por mil para obtener la unidad minima
    if (($unidad_compra == "kg") or ($unidad_compra == "l") or ($unidad_compra == "m"))
    {
        $costo_unidad_minima = $costo_unidad_compra / 1000;
    }
    else
    {
        if ($unidad_compra == "botella 375 ml")
        {
            $costo_unidad_minima = $costo_unidad_compra / 375;
        }
        else
        {
            if ($unidad_compra == "botella 750 ml")
            {
                $costo_unidad_minima = $costo_unidad_compra / 750;
            }
            else
            {
                if ($unidad_compra == "botella 1500 ml")
                {
                    $costo_unidad_minima = $costo_unidad_compra / 1500;
                }
                else
                {
                    if ($unidad_compra == "garrafa 2000 ml")
                    {
                        $costo_unidad_minima = $costo_unidad_compra / 2000;
                    }
                    else
                    {
                        if ($unidad_compra == "arroba 12.5 kg")
                        {
                            $costo_unidad_minima = $costo_unidad_compra / 12500;
                        }
                        else
                        {
                            if ($unidad_compra == "bulto 25 kg")
                            {
                                $costo_unidad_minima = $costo_unidad_compra / 25000;
                            }
                            else
                            {
                                if ($unidad_compra == "bulto 50 kg")
                                {
                                    $costo_unidad_minima = $costo_unidad_compra / 50000;
                                }
                                else
                                {
                                    if ($unidad_compra == "galon 3.7 l")
                                    {
                                        $costo_unidad_minima = $costo_unidad_compra / 3785;
                                    }
                                    else
                                    {
                                        if ($unidad_compra == "botella 5 l")
                                        {
                                            $costo_unidad_minima = $costo_unidad_compra / 5000;
                                        }
                                        else
                                        {
                                            if ($unidad_compra == "botellon 18 l")
                                            {
                                                $costo_unidad_minima = $costo_unidad_compra / 18000;
                                            }
                                            else
                                            {
                                                if ($unidad_compra == "botellon 20 l")
                                                {
                                                    $costo_unidad_minima = $costo_unidad_compra / 20000;
                                                }
                                                else
                                                {
                                                    if ($unidad_compra == "botella 3 l")
                                                    {
                                                        $costo_unidad_minima = $costo_unidad_compra / 3000;
                                                    }
                                                    else
                                                    {
                                                        if ($unidad_compra == "par")
                                                        {
                                                            $costo_unidad_minima = $costo_unidad_compra / 2;
                                                        }
                                                        else
                                                        {
                                                            if ($unidad_compra == "trio")
                                                            {
                                                                $costo_unidad_minima = $costo_unidad_compra / 3;
                                                            }
                                                            else
                                                            {
                                                                if ($unidad_compra == "decena")
                                                                {
                                                                    $costo_unidad_minima = $costo_unidad_compra / 10;
                                                                }
                                                                else
                                                                {
                                                                    if ($unidad_compra == "docena")
                                                                    {
                                                                        $costo_unidad_minima = $costo_unidad_compra / 12;
                                                                    }
                                                                    else
                                                                    {
                                                                        if ($unidad_compra == "quincena")
                                                                        {
                                                                            $costo_unidad_minima = $costo_unidad_compra / 15;
                                                                        }
                                                                        else
                                                                        {
                                                                            if ($unidad_compra == "treintena")
                                                                            {
                                                                                $costo_unidad_minima = $costo_unidad_compra / 30;
                                                                            }
                                                                            else
                                                                            {
                                                                                if ($unidad_compra == "centena")
                                                                                {
                                                                                    $costo_unidad_minima = $costo_unidad_compra / 100;
                                                                                }
                                                                                else
                                                                                {
                                                                                    $costo_unidad_minima = $costo_unidad_compra;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
        
    $actualizar = $conexion->query("UPDATE ingrediente SET fecha_mod = '$ahora', usuario_mod = '$sesion_id', ingrediente = '$ingrediente', unidad_minima = '$unidad_minima', unidad_compra = '$unidad_compra', costo_unidad_minima = '$costo_unidad_minima', costo_unidad_compra = '$costo_unidad_compra', cantidad_unidad_compra = '$cantidad_unidad_compra', productor_id = '$productor_id' WHERE ingrediente_id = '$ingrediente_producido_id'");

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
    <title>Ingrediente producido - ManGo!</title>    
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
            <a href="ingredientes_producidos_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Ingrediente producido</h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <a href="ingredientes_producidos_impresion.php?ingrediente_producido_id=<?php echo "$ingrediente_producido_id"; ?>" target="_blank"><div class="rdm-lista--icono"><i class="zmdi zmdi-print zmdi-hc-2x"></i></div></a>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro el ingrediente
    $consulta = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = '$ingrediente_producido_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Este ingrediente ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $ingrediente_producido_id = $fila['ingrediente_id'];
            
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

            $ingrediente = $fila['ingrediente'];
            $tipo = $fila['tipo'];
            $unidad_minima = $fila['unidad_minima'];
            $unidad_compra = $fila['unidad_compra'];
            $costo_unidad_minima = $fila['costo_unidad_minima'];
            $costo_unidad_compra = $fila['costo_unidad_compra'];
            $cantidad_unidad_compra = $fila['cantidad_unidad_compra'];

            $productor_id = $fila['productor_id'];




            






            

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

            //consulto el costo
            $consulta_costo = $conexion->query("SELECT * FROM ingrediente_producido_composicion WHERE ingrediente_producido_id = '$ingrediente_producido_id' ORDER BY fecha_alta DESC");

            if ($consulta_costo->num_rows != 0)
            {
                $composicion_costo = 0;

                while ($fila = $consulta_costo->fetch_assoc())
                {
                    //datos de la composicion
                    $ingrediente_producido_composicion_id = $fila['ingrediente_producido_composicion_id'];
                    $cantidad = $fila['cantidad'];
                    $ingrediente_id = $fila['ingrediente_id'];

                    //consulto el ingrediente
                    $consulta2 = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = $ingrediente_id");

                    if ($filas2 = $consulta2->fetch_assoc())
                    {            
                        $unidad_minima_c = $filas2['unidad_minima'];
                        $costo_unidad_minima_c = $filas2['costo_unidad_minima'];
                    }
                    else
                    {            
                        $unidad_minima_c = "unid";
                        $costo_unidad_minima_c = 0;
                    }

                    //costo del ingrediente
                    $ingrediente_costo = $costo_unidad_minima_c * $cantidad;

                    //costo de la composicion
                    $composicion_costo = $composicion_costo + $ingrediente_costo;
                }

                //valor del costo
                $costo_valor = $composicion_costo;       
            }
            else                 
            {
                //valor del costo
                $costo_valor = 0;
            }

            //calculo el costo de la unidad minima si la unidad es kilos, litros o metros se divide por mil para obtener la unidad minima
            if (($unidad_compra == "kg") or ($unidad_compra == "l") or ($unidad_compra == "m"))
            {
                $costo_unidad_minima = $costo_valor / 1000;
            }
            else
            {
                $costo_unidad_minima = $costo_valor;
            }
            ?>

            <section class="rdm-tarjeta">

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($ingrediente) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo">$<?php echo number_format($costo_valor, 2, ",", "."); ?> x <?php echo ucfirst($unidad_compra); ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">                    

                    <?php if (!empty($tipo)) { ?>
                        <p><b>Tipo</b> <br><?php echo ucfirst($tipo) ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_compra)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Cantidad mínima de produccion</b> <br><?php echo ucfirst($cantidad_unidad_compra); ?> <?php echo ucfirst($unidad_compra); ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_compra)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Unidad de producción</b> <br><?php echo ucfirst($unidad_compra); ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_compra)) { ?>                        
                        <p><b>Costo de unidad de producción</b> <br>$<?php echo number_format($costo_valor, 2, ",", "."); ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_minima)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Unidad mínima</b> <br><?php echo ucfirst($unidad_minima); ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_compra)) { ?>
                        <p><b>Costo de unidad mínima</b> <br>$<?php echo number_format($costo_unidad_minima, 2, ",", "."); ?></p>
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
    //consulto la composicion de este ingrediente producido
    $consulta = $conexion->query("SELECT * FROM ingrediente_producido_composicion WHERE ingrediente_producido_id = '$ingrediente_producido_id' and estado = 'activo' ORDER BY fecha_alta DESC");

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
                        <h2 class="rdm-lista--texto-secundario">No se han agregado ingredientes</h2>
                    </div>
                </div>
            </article>

            <div class="rdm-tarjeta--separador"></div>

            <div class="rdm-tarjeta--acciones-izquierda">
                <a href="ingredientes_producidos_composicion.php?ingrediente_producido_id=<?php echo "$ingrediente_producido_id"; ?>"><button class="rdm-boton--plano-resaltado">Agregar</button></a>
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
            $ingrediente_producido_composicion_id = $fila['ingrediente_producido_composicion_id'];            
            $cantidad = $fila['cantidad'];
            $ingrediente_id = $fila['ingrediente_id'];           

            //consulto el ingrediente
            $consulta2 = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = $ingrediente_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $ingrediente = $filas2['ingrediente'];
                $unidad_minima = $filas2['unidad_minima'];
                $costo_unidad_minima = $filas2['costo_unidad_minima'];

                //color de fondo segun la primer letra
                $avatar_id = $ingrediente_id;
                $avatar_nombre = "$ingrediente";

                include ("sis/avatar_color.php");
                
                //consulto el avatar
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';
            }
            else
            {
                $ingrediente = "No se ha asignado un ingrediente";
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
                        <h2 class="rdm-lista--titulo"><?php echo ($cantidad); ?> <?php echo ucfirst($unidad_minima); ?> de <?php echo ucfirst($ingrediente); ?></h2>
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
            <a href="ingredientes_producidos_composicion.php?ingrediente_producido_id=<?php echo "$ingrediente_producido_id"; ?>"><button class="rdm-boton--plano-resaltado">Editar</button></a>
        </div>

        </section>

    <?php
    }
    ?>

















    <?php
    //consulto la composicion de este ingrediente producido
    $consulta = $conexion->query("SELECT * FROM ingrediente_producido_preparacion WHERE ingrediente_producido_id = '$ingrediente_producido_id' and estado = 'activo' ORDER BY fecha_alta ASC");

    if ($consulta->num_rows == 0)
    {
        $paso = 0;

        ?>

        <h2 class="rdm-lista--titulo-largo">Preparación</h2>

        <section class="rdm-lista">
            
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-info zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>
                        <h2 class="rdm-lista--texto-secundario">No se han agregado pasos de preparación</h2>
                    </div>
                </div>
            </article>

            <div class="rdm-tarjeta--separador"></div>


            <div class="rdm-tarjeta--acciones-izquierda">
                <a href="ingredientes_producidos_preparacion_agregar.php?ingrediente_producido_id=<?php echo "$ingrediente_producido_id"; ?>"><button class="rdm-boton--plano-resaltado">Agregar</button></a>
            </div>

            

        </section>

        
        <?php
    }
    else
    {   ?>

        <a id="preparacion">

        <h2 class="rdm-lista--titulo-largo">Preparación</h2>

        <section class="rdm-lista"> 

        <?php

        while ($fila = $consulta->fetch_assoc())
        {
            //datos de la composicion
            $ingrediente_producido_preparacion_id = $fila['ingrediente_producido_preparacion_id'];
            $paso = $fila['paso'];
            $preparacion = $fila['preparacion'];
            $ingrediente_producido_id = $fila['ingrediente_producido_id'];

            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];            

            //color de fondo segun la primer letra
            $avatar_id = $ingrediente_producido_preparacion_id;
            $avatar_nombre = "$paso";

            include ("sis/avatar_color.php");

            //consulto la imagen de la preparacion
            if ($imagen == "no")
            {
                $imagen_preparacion = "";
            }
            else
            {
                $imagen_preparacion = "img/avatares/preparacion-$ingrediente_producido_preparacion_id-$imagen_nombre.jpg";
                $imagen_preparacion = '<div class="rdm-tarjeta--media-cuadrado" style="background-image: url('.$imagen_preparacion.');"></div>';
            }
            
            ?>


                <div class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <div class="rdm-lista--avatar-color" style="background-color: hsl(<?php echo $sca ?>, 50%, 80%); color: hsl(<?php echo $sca ?>, 80%, 30%);"><span class="rdm-lista--avatar-texto"><?php echo "$paso"; ?></span></div>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo">Paso <?php echo ($paso); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst($preparacion); ?></h2>

                        </div>
                    </div>

                    <div class="rdm-lista--derecha">
                        
                    </div>
                </div>           

            
            
        <?php
        }
        ?>

        <div class="rdm-tarjeta--separador"></div>

        <div class="rdm-tarjeta--acciones-izquierda">
            <a href="ingredientes_producidos_preparacion_agregar.php?ingrediente_producido_id=<?php echo "$ingrediente_producido_id"; ?>"><button class="rdm-boton--plano-resaltado">Editar</button></a>
        </div>

        </section>

    <?php
    }
    ?>





















    <?php
    //consulto la composicion de este ingrediente producido
    $consulta = $conexion->query("SELECT * FROM ingrediente_producido_preparacion WHERE ingrediente_producido_id = '$ingrediente_producido_id' and estado = 'activo' ORDER BY fecha_alta ASC");

    if ($consulta->num_rows == 0)
    {
        $paso = 0;

        ?>

        <h2 class="rdm-lista--titulo-largo">Preparación</h2>

        <section class="rdm-lista">
            
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-info zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>
                        <h2 class="rdm-lista--texto-secundario">No se han agregado pasos de preparación</h2>
                    </div>
                </div>
            </article>

            <div class="rdm-tarjeta--separador"></div>


            <div class="rdm-tarjeta--acciones-izquierda">
                <a href="ingredientes_producidos_preparacion_agregar.php?ingrediente_producido_id=<?php echo "$ingrediente_producido_id"; ?>"><button class="rdm-boton--plano-resaltado">Agregar</button></a>
            </div>

            

        </section>

        
        <?php
    }
    else
    {   ?>

        <a id="preparacion">

        <h2 class="rdm-lista--titulo-largo">Preparación</h2>

        <section class="rdm-lista"> 

        <?php

        while ($fila = $consulta->fetch_assoc())
        {
            //datos de la composicion
            $ingrediente_producido_preparacion_id = $fila['ingrediente_producido_preparacion_id'];
            $paso = $fila['paso'];
            $preparacion = $fila['preparacion'];
            $ingrediente_producido_id = $fila['ingrediente_producido_id'];

            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];            

            //color de fondo segun la primer letra
            $avatar_id = $ingrediente_producido_preparacion_id;
            $avatar_nombre = "$paso";

            include ("sis/avatar_color.php");

            //consulto la imagen de la preparacion
            if ($imagen == "no")
            {
                $imagen_preparacion = "";
            }
            else
            {
                $imagen_preparacion = "img/avatares/preparacion-$ingrediente_producido_preparacion_id-$imagen_nombre.jpg";
                $imagen_preparacion = '<div class="rdm-tarjeta--media-cuadrado" style="background-image: url('.$imagen_preparacion.');"></div>';
            }
            
            ?>


                <div class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <div class="rdm-lista--avatar-color" style="background-color: hsl(<?php echo $sca ?>, 50%, 80%); color: hsl(<?php echo $sca ?>, 80%, 30%);"><span class="rdm-lista--avatar-texto"><?php echo "$paso"; ?></span></div>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo">Paso <?php echo ($paso); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst($preparacion); ?></h2>

                        </div>
                    </div>

                    <div class="rdm-lista--derecha">
                        
                    </div>
                </div>   
                <?php echo "$imagen_preparacion"; ?>         

            
            
        <?php
        }
        ?>

        <div class="rdm-tarjeta--separador"></div>

        <div class="rdm-tarjeta--acciones-izquierda">
            <a href="ingredientes_producidos_preparacion_agregar.php?ingrediente_producido_id=<?php echo "$ingrediente_producido_id"; ?>"><button class="rdm-boton--plano-resaltado">Editar</button></a>
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
    
    <a href="ingredientes_producidos_editar.php?ingrediente_producido_id=<?php echo "$ingrediente_producido_id"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>