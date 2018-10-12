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
//variables de la sesion
include ("sis/variables_sesion.php");
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;
if(isset($_POST['actualizar'])) $actualizar = $_POST['actualizar']; elseif(isset($_GET['actualizar'])) $actualizar = $_GET['actualizar']; else $actualizar = null;
if(isset($_POST['consultaBusqueda'])) $consultaBusqueda = $_POST['consultaBusqueda']; elseif(isset($_GET['consultaBusqueda'])) $consultaBusqueda = $_GET['consultaBusqueda']; else $consultaBusqueda = null;

if(isset($_POST['id'])) $id = $_POST['id']; elseif(isset($_GET['id'])) $id = $_GET['id']; else $id = null;
if(isset($_POST['despacho_id'])) $despacho_id = $_POST['despacho_id']; elseif(isset($_GET['despacho_id'])) $despacho_id = $_GET['despacho_id']; else $despacho_id = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//elimino el despacho
if ($eliminar == 'si')
{
    //actualizo el estado a eliminado
    $eliminar_despacho = $conexion->query("UPDATE despachos SET estado = 'eliminado' WHERE id = '$despacho_id'");

    $eliminar_componentes = $conexion->query("UPDATE despachos_componentes SET estado = 'eliminado' WHERE despacho_id = '$despacho_id'");

    if ($eliminar_componentes)
    {
        $mensaje = "Despacho <b>No ".ucfirst($despacho_id)."</b> eliminado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
}
?>

<?php
//envio el despacho
if ($actualizar == "si")
{
    $enviar_despacho = $conexion->query("UPDATE despachos SET fecha_envio = '$ahora', estado = 'enviado' WHERE id = '$despacho_id'");

    $enviar_componentes = $conexion->query("UPDATE despachos_componentes SET estado = 'enviado' WHERE despacho_id = '$despacho_id'");

    if ($enviar_componentes)
    {
        $mensaje = "Compra <b>No ".ucfirst($despacho_id)."</b> enviada";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>ManGo!</title>    
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>

    <script>
    $(document).ready(function() {
        $("#resultadoBusqueda").html('');
    });

    function buscar() {
        var textoBusqueda = $("input#busqueda").val();
     
         if (textoBusqueda != "") {
            $.post("despachos_buscar.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
                $("#resultadoBusqueda").html(mensaje);
             }); 
         } else { 
            $("#resultadoBusqueda").html('');
            };
    };
    </script>
</head>

<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="index.php#despachos"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Compras</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro los despachos hechos
    $consulta = $conexion->query("SELECT * FROM despachos");

    if ($consulta->num_rows == 0)
    {
        ?>

        <section class="rdm-lista">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-truck zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">No hay compras</h2>
                    </div>
                </div>
            </article>

        </section>

        <?php
    }
    ?>

    <?php
    //consulto y muestro los despachos hechos
    $consulta = $conexion->query("SELECT * FROM despachos WHERE estado = 'creado' ORDER BY fecha DESC");

    if ($consulta->num_rows == 0)
    {
        
    }
    else
    {
        ?>
        
        <h2 class="rdm-lista--titulo-largo">Creados</h2>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc())
        {
            $despacho_id = $fila['id'];
            $origen = $fila['origen'];
            $destino = $fila['destino'];
            $estado = $fila['estado'];
            $usuario_recibe = $fila['usuario_recibe'];

            //calculo el tiempo transcurrido
            $fecha = date('Y-m-d H:i:s', strtotime($fila['fecha']));
            include ("sis/tiempo_transcurrido.php");

            //consulto el destino
            $consulta_destino = $conexion->query("SELECT * FROM locales WHERE id = $destino");

            if ($filas_destino = $consulta_destino->fetch_assoc())
            {
                $local_destino = ucfirst($filas_destino['local']);
            }
            else
            {
                $local_destino = "No se ha asignado un local";
            }

            //cantidad de componentes en este despachos
            $costo_despacho = 0;

            $consulta_cantidad = $conexion->query("SELECT * FROM despachos_componentes WHERE despacho_id = '$despacho_id'");

            if ($consulta_cantidad->num_rows == 0)
            {
                $cantidad_componentes = $consulta_cantidad->num_rows;
                $cantidad_componentes = "$cantidad_componentes componentes";
            }
            else
            {
                $cantidad_componentes = $consulta_cantidad->num_rows;
                $cantidad_componentes = "$cantidad_componentes componentes";                

                while ($fila_cantidad = $consulta_cantidad->fetch_assoc())
                {
                    $componente_id = $fila_cantidad['componente_id'];
                    $cantidad = $fila_cantidad['cantidad'];

                    //consulto el componente
                    $consulta2 = $conexion->query("SELECT * FROM componentes WHERE id = $componente_id");

                    if ($filas2 = $consulta2->fetch_assoc())
                    {
                        $unidad = $filas2['unidad'];
                        $componente = $filas2['componente'];
                        $costo_unidad = $filas2['costo_unidad'];
                    }
                    else
                    {
                        $componente = "No se ha asignado un componente";
                        $costo_unidad = "0";
                    }

                    $subtotal_costo_unidad = $costo_unidad * $cantidad;

                    $costo_despacho = $costo_despacho + $subtotal_costo_unidad;
                }


            }
            ?>

            <a href="despachos_detalle.php?despacho_id=<?php echo "$despacho_id"; ?>&destino=<?php echo "$destino"; ?>">

                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <div class="rdm-lista--icono"><span class="rdm-lista--texto-negativo"><i class="zmdi zmdi-truck zmdi-hc-2x"></i></span></div>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst("$local_destino"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst("$cantidad_componentes"); ?></h2>
                            <h2 class="rdm-lista--texto-valor">No <?php echo "$despacho_id"; ?> - $ <?php echo number_format($costo_despacho, 2, ",", "."); ?></h2>
                        </div>
                    </div>
                    <div class="rdm-lista--derecha">
                        <span class="rdm-lista--texto-tiempo"><?php echo "$tiempo_transcurrido"; ?></span>
                    </div>
                </article>

            </a>
            
            <?php
        }

        ?>

        </section>

        <?php
    }
    ?>

    

    <?php
    //consulto y muestro los despachos hechos
    $consulta = $conexion->query("SELECT * FROM despachos WHERE estado = 'enviado' ORDER BY fecha DESC");

    if ($consulta->num_rows == 0)
    {
        
    }
    else
    {
        ?>        
        
        <h2 class="rdm-lista--titulo-largo">Enviados</h2>
        
        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc())
        {
            $despacho_id = $fila['id'];
            $origen = $fila['origen'];
            $destino = $fila['destino'];
            $estado = $fila['estado'];
            $usuario_recibe = $fila['usuario_recibe'];

            //calculo el tiempo transcurrido
            $fecha = date('Y-m-d H:i:s', strtotime($fila['fecha_envio']));
            include ("sis/tiempo_transcurrido.php");

            //consulto el destino
            $consulta_destino = $conexion->query("SELECT * FROM locales WHERE id = $destino");

            if ($filas_destino = $consulta_destino->fetch_assoc())
            {
                $local_destino = ucfirst($filas_destino['local']);
            }
            else
            {
                $local_destino = "No se ha asignado un local";
            }

            //cantidad de componentes en este despachos                     
            $consulta_cantidad = $conexion->query("SELECT * FROM despachos_componentes WHERE despacho_id = '$despacho_id'");

            if ($consulta_cantidad->num_rows == 0)
            {
                $cantidad_componentes = $consulta_cantidad->num_rows;
                $cantidad_componentes = "$cantidad_componentes componentes";
            }
            else
            {
                $cantidad_componentes = $consulta_cantidad->num_rows;
                $cantidad_componentes = "$cantidad_componentes componentes";

                $costo_despacho = 0;

                while ($fila_cantidad = $consulta_cantidad->fetch_assoc())
                {
                    $componente_id = $fila_cantidad['componente_id'];
                    $cantidad = $fila_cantidad['cantidad'];

                    //consulto el componente
                    $consulta2 = $conexion->query("SELECT * FROM componentes WHERE id = $componente_id");

                    if ($filas2 = $consulta2->fetch_assoc())
                    {
                        $unidad = $filas2['unidad'];
                        $componente = $filas2['componente'];
                        $costo_unidad = $filas2['costo_unidad'];
                    }
                    else
                    {
                        $componente = "No se ha asignado un componente";
                    }

                    $subtotal_costo_unidad = $costo_unidad * $cantidad;

                    $costo_despacho = $costo_despacho + $subtotal_costo_unidad;
                }


            }
            ?>

            <a href="despachos_detalle.php?despacho_id=<?php echo "$despacho_id"; ?>&destino=<?php echo "$destino"; ?>">

                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <div class="rdm-lista--icono"><span class="rdm-lista--texto-positivo"><i class="zmdi zmdi-truck zmdi-hc-2x"></i></span></div>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst("$local_destino"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst("$cantidad_componentes"); ?></h2>
                            <h2 class="rdm-lista--texto-valor">No <?php echo "$despacho_id"; ?> - $ <?php echo number_format($costo_despacho, 2, ",", "."); ?></h2>
                        </div>
                    </div>
                    <div class="rdm-lista--derecha">
                        <span class="rdm-lista--texto-tiempo"><?php echo "$tiempo_transcurrido"; ?></span>
                    </div>
                </article>

            </a>
            
            <?php
        }

        ?>

        </section>

        <?php
    }
    ?>


    <?php
    //consulto y muestro los despachos hechos
    $consulta = $conexion->query("SELECT * FROM despachos WHERE estado = 'recibido' ORDER BY fecha DESC LIMIT 10");

    if ($consulta->num_rows == 0)
    {
        
    }
    else
    {
        ?>        
        
        <h2 class="rdm-lista--titulo-largo">Recibidos</h2>
        
        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc())
        {
            $despacho_id = $fila['id'];
            $origen = $fila['origen'];
            $destino = $fila['destino'];
            $estado = $fila['estado'];
            $usuario_recibe = $fila['usuario_recibe'];            

            //calculo el tiempo transcurrido
            $fecha = date('Y-m-d H:i:s', strtotime($fila['fecha_recibe']));
            include ("sis/tiempo_transcurrido.php");

            //consulto el destino
            $consulta_destino = $conexion->query("SELECT * FROM locales WHERE id = $destino");

            if ($filas_destino = $consulta_destino->fetch_assoc())
            {
                $local_destino = ucfirst($filas_destino['local']);
            }
            else
            {
                $local_destino = "No se ha asignado un local";
            }

            //consulto el usuario que recibe el despacho
            $consulta_usuario = $conexion->query("SELECT * FROM usuarios WHERE id = '$usuario_recibe'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $nombres = ucwords($fila['nombres']);
                $apellidos = ucwords($fila['apellidos']);

                //tomo la primer palabra de las cadenas
                $nombres = strtok($nombres, " ");
                $apellidos = strtok($apellidos, " ");

                $usuario_recibe = "Recibido por $nombres $apellidos";
            }

            //cantidad de componentes en este despachos                     
            $consulta_cantidad = $conexion->query("SELECT * FROM despachos_componentes WHERE despacho_id = '$despacho_id'");

            if ($consulta_cantidad->num_rows == 0)
            {
                $cantidad_componentes = $consulta_cantidad->num_rows;
                $cantidad_componentes = "$cantidad_componentes componentes";
            }
            else
            {
                $cantidad_componentes = $consulta_cantidad->num_rows;
                $cantidad_componentes = "$cantidad_componentes componentes";

                $costo_despacho = 0;

                while ($fila_cantidad = $consulta_cantidad->fetch_assoc())
                {
                    $componente_id = $fila_cantidad['componente_id'];
                    $cantidad = $fila_cantidad['cantidad'];

                    //consulto el componente
                    $consulta2 = $conexion->query("SELECT * FROM componentes WHERE id = $componente_id");

                    if ($filas2 = $consulta2->fetch_assoc())
                    {
                        $unidad = $filas2['unidad'];
                        $componente = $filas2['componente'];
                        $costo_unidad = $filas2['costo_unidad'];
                    }
                    else
                    {
                        $componente = "No se ha asignado un componente";
                        $costo_unidad = "0";
                    }

                    $subtotal_costo_unidad = $costo_unidad * $cantidad;

                    $costo_despacho = $costo_despacho + $subtotal_costo_unidad;
                }


            }
            ?>            

            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-truck zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo"><?php echo ucfirst("$local_destino"); ?></h2>
                        <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst("$usuario_recibe"); ?></h2>
                        <h2 class="rdm-lista--texto-valor">No <?php echo "$despacho_id"; ?> - $ <?php echo number_format($costo_despacho, 2, ",", "."); ?></h2>
                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <span class="rdm-lista--texto-tiempo"><?php echo "$tiempo_transcurrido"; ?></span>
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
    
    <a href="despachos_agregar.php"><button class="rdm-boton--fab" ><i class="zmdi zmdi-plus zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>