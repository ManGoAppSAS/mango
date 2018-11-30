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



<main class="rdm--contenedor">

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




            






            //consulto el productor
            $consulta2 = $conexion->query("SELECT * FROM productor WHERE productor_id = $productor_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $productor = $filas2['productor'];
                $telefono = $filas2['telefono'];
                $correo = $filas2['correo'];
            }
            else
            {
                $productor = "";
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

            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($ingrediente) ?></h1> 
                <h2 class="rdm-tarjeta--subtitulo-largo">Preparación para <?php echo ucfirst($cantidad_unidad_compra); ?> <?php echo ucfirst($unidad_compra); ?></h2>
            </div>            
            
            <?php
        }
    }
    ?>






    <div style="display: flex; align-items: flex-start;">

    <?php
    //consulto la composicion de este ingrediente producido
    $consulta = $conexion->query("SELECT * FROM ingrediente_producido_composicion WHERE ingrediente_producido_id = '$ingrediente_producido_id' and estado = 'activo' ORDER BY fecha_alta DESC");

    if ($consulta->num_rows == 0)
    {
        ?>        

        
        <?php
    }
    else
    {   ?>

        <div style="display: inline-block; width: 49%;">

        <h2 class="rdm-lista--titulo-largo">Composición</h2>

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
                    
            <p class="rdm-lista--titulo"><b><?php echo ($cantidad); ?> <?php echo ucfirst($unidad_minima); ?></b> de <?php echo ucfirst($ingrediente); ?></p>                
            
        <?php
        }
        ?>

        </div>

    <?php
    }
    ?>

















    <?php
    //consulto la composicion de este ingrediente producido
    $consulta = $conexion->query("SELECT * FROM ingrediente_producido_preparacion WHERE ingrediente_producido_id = '$ingrediente_producido_id' and estado = 'activo' ORDER BY fecha_alta ASC");

    if ($consulta->num_rows == 0)
    {

        ?>        

        
        <?php
    }
    else
    {   ?>

        <div style="display: inline-block; width: 49%;">

        <h2 class="rdm-lista--titulo-largo">Preparación</h2>        

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
                
            <p class="rdm-lista--titulo"><b><?php echo ($paso); ?>.</b> <?php echo ucfirst($preparacion); ?></p>            
            
        <?php
        }
        ?>        

        </div>

    <?php
    }
    ?>   


    </div> 

    <br>

    <div class="rdm-tarjeta--separador"></div>

    <div class="rdm-tarjeta--primario-largo">
        <h1 class="rdm-tarjeta--titulo-largo">Notas del Cheff</h1>
    </div>
    
</main>

<footer>   
    

</footer>

</body>
</html>