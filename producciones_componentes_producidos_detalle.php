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
if(isset($_POST['componente_producido_id'])) $componente_producido_id = $_POST['componente_producido_id']; elseif(isset($_GET['componente_producido_id'])) $componente_producido_id = $_GET['componente_producido_id']; else $componente_producido_id = null;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;

//datos de proporcion
if(isset($_POST['calcular_proporcion'])) $calcular_proporcion = $_POST['calcular_proporcion']; elseif(isset($_GET['calcular_proporcion'])) $calcular_proporcion = $_GET['calcular_proporcion']; else $calcular_proporcion = null;
if(isset($_POST['cantidad_actual'])) $cantidad_actual = $_POST['cantidad_actual']; elseif(isset($_GET['cantidad_actual'])) $cantidad_actual = $_GET['cantidad_actual']; else $cantidad_actual = null;
if(isset($_POST['cantidad_nueva'])) $cantidad_nueva = $_POST['cantidad_nueva']; elseif(isset($_GET['cantidad_nueva'])) $cantidad_nueva = $_GET['cantidad_nueva']; else $cantidad_nueva = null;
if(isset($_POST['proporcion'])) $proporcion = $_POST['proporcion']; elseif(isset($_GET['proporcion'])) $proporcion = $_GET['proporcion']; else $proporcion = 1;
?>

<?php 
if ($calcular_proporcion == "si")
{
    //proporcion
    $proporcion = $cantidad_nueva / $cantidad_actual;
} 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Componente producido - ManGo!</title>    
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
            <a href="producciones_componentes_producidos_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Componente producido</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro el componente
    $consulta = $conexion->query("SELECT * FROM componente WHERE componente_id = '$componente_producido_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Este componente ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $componente_producido_id = $fila['componente_id'];
            
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

            $componente = $fila['componente'];
            $tipo = $fila['tipo'];
            $unidad_minima = $fila['unidad_minima'];
            $unidad_compra = $fila['unidad_compra'];
            $costo_unidad_minima = $fila['costo_unidad_minima'];
            $costo_unidad_compra = $fila['costo_unidad_compra'];
            $preparacion = $fila['preparacion'];
            $cantidad_unidad_compra = $fila['cantidad_unidad_compra'];

            //calculo la cantidad segun la proporcion
            $cantidad_unidad_compra = $cantidad_unidad_compra * $proporcion;

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
            $consulta_costo = $conexion->query("SELECT * FROM componente_producido_composicion WHERE componente_producido_id = '$componente_producido_id' ORDER BY fecha_alta DESC");

            if ($consulta_costo->num_rows != 0)
            {
                $composicion_costo = 0;

                while ($fila = $consulta_costo->fetch_assoc())
                {
                    //datos de la composicion
                    $componente_producido_composicion_id = $fila['componente_producido_composicion_id'];
                    $cantidad = $fila['cantidad'];
                    $componente_id = $fila['componente_id'];

                    //consulto el componente
                    $consulta2 = $conexion->query("SELECT * FROM componente WHERE componente_id = $componente_id");

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

                    //costo del componente
                    $componente_costo = $costo_unidad_minima_c * $cantidad;

                    //costo de la composicion
                    $composicion_costo = $composicion_costo + $componente_costo;
                }

                //valor del costo
                $costo_valor = $composicion_costo * $proporcion;       
            }
            else                 
            {
                //valor del costo
                $costo_valor = 0;
            }
            ?>

            <section class="rdm-tarjeta">

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($componente) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo">$<?php echo number_format($costo_valor, 2, ",", "."); ?> x <?php echo ($cantidad_unidad_compra); ?> <?php echo ucfirst($unidad_compra); ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">

                    <?php if (!empty($preparacion)) { ?>
                        <p><b>Preparación</b> <br><?php echo ucfirst(nl2br($preparacion)); ?></p>
                    <?php } ?>
                    
                </div>

            </section>
            
            <?php
        }
    }
    ?>


    <h2 class="rdm-lista--titulo-largo">Cantidad a producir</h2>


    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

        <input type="hidden" name="componente_producido_id" value="<?php echo "$componente_producido_id"; ?>">
        <input type="hidden" name="componente_id" value="<?php echo "$componente_id"; ?>">
        <input type="hidden" name="busqueda" value="<?php echo "$busqueda"; ?>">

        <input type="hidden" name="cantidad_actual" value="<?php echo "$cantidad_unidad_compra"; ?>">
    
        <section class="rdm-formulario">

            <p class="rdm-formularios--label"><label for="cantidad_nueva">Composición para <?php echo ($cantidad_unidad_compra); ?> <?php echo ucfirst($unidad_compra); ?>*</label></p>
            <p><input type="text" id="cantidad_nueva" name="cantidad_nueva" value="<?php echo number_format($cantidad_unidad_compra, 1, '.', '.'); ?>" required /></p>
            <p class="rdm-formularios--ayuda">Cantidad en <?php echo ucfirst($unidad_compra); ?></p>
                        

            <p class="rdm-formularios--submit">
                <button class="rdm-boton--resaltado" type="submit" name="calcular_proporcion" value="si">Recalcular</button>
            </p>

        </section>

    </form>





















    <?php
    //consulto la composicion de este componente producido
    $consulta = $conexion->query("SELECT * FROM componente_producido_composicion WHERE componente_producido_id = '$componente_producido_id' and estado = 'activo' ORDER BY fecha_alta DESC");

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
                        <h2 class="rdm-lista--texto-secundario">La composición son los componentes o ingredientes de los cuales está hecho un componente_producido o servicio. Estos componentes o ingredientes se descontarán del inventario según la cantidad que se haya indicado</h2>
                    </div>
                </div>
            </article>

            <div class="rdm-tarjeta--separador"></div>

            <div class="rdm-tarjeta--acciones-izquierda">
                <a href="componentes_producidos_composicion.php?componente_producido_id=<?php echo "$componente_producido_id"; ?>"><button class="rdm-boton--plano-resaltado">Editar</button></a>
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
            $componente_producido_composicion_id = $fila['componente_producido_composicion_id'];            
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

            $cantidad = $cantidad * $proporcion;

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

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="componente_producido_id" value="<?php echo "$componente_producido_id"; ?>">
                            <input type="hidden" name="componente_id" value="<?php echo "$componente_id"; ?>">
                            <input type="hidden" name="busqueda" value="<?php echo "$busqueda"; ?>">

                            <input type="hidden" name="costo_valor" value="<?php echo "$costo_valor"; ?>">
                            <input type="hidden" name="cantidad_unidad_compra" value="<?php echo "$cantidad_unidad_compra"; ?>">

                            <input type="hidden" name="cantidad_actual" value="<?php echo "$cantidad"; ?>">

                            <h2 class="rdm-lista--texto-secundario">
                                <input class="rdm-formularios--input-cantidad" type="number" name="cantidad_nueva" placeholder="¿Cuánto?" step="any" value="<?php echo ($cantidad); ?>" required /> 
                                <button type="submit" class="rdm-boton--cantidad" name="calcular_proporcion" value="si"><i class="zmdi zmdi-check"></i></button>
                            </h2>
                        </form>
                    </div>
                </div>
                <div class="rdm-lista--derecha-sencillo">
                    
                </div>
            </article>
            
        <?php
        }
        ?>       

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
    
    

</footer>

</body>
</html>