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
//variable para eliminar
if(isset($_POST['eliminar_compra'])) $eliminar_compra = $_POST['eliminar_compra']; elseif(isset($_GET['eliminar_compra'])) $eliminar_compra = $_GET['eliminar_compra']; else $eliminar_compra = null;

//variable de consulta
if(isset($_POST['busqueda'])) $busqueda = $_POST['busqueda']; elseif(isset($_GET['busqueda'])) $busqueda = $_GET['busqueda']; else $busqueda = null;

//variables de envio de inventario
if(isset($_POST['enviar'])) $enviar = $_POST['enviar']; elseif(isset($_GET['enviar'])) $enviar = $_GET['enviar']; else $enviar = null;
if(isset($_POST['compra_id'])) $compra_id = $_POST['compra_id']; elseif(isset($_GET['compra_id'])) $compra_id = $_GET['compra_id']; else $compra_id = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>


<?php
//envio los ingredientes al inventario
if ($enviar == 'si')
{
    $actualizar_compra = $conexion->query("UPDATE compra SET estado = 'enviado' WHERE compra_id = '$compra_id'");

    if ($actualizar_compra)
    {
        $actualizar_ingrediente = $conexion->query("UPDATE compra_ingrediente SET estado = 'enviado' WHERE compra_id = '$compra_id'");

        $mensaje = "Compra terminada y enviada";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
}
?>




<?php
//elimino la compra
if ($eliminar_compra == 'si')
{
    $borrar_compra = $conexion->query("UPDATE compra SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE compra_id = '$compra_id'");

    if ($borrar_compra)
    {
        $borrar_ingrediente = $conexion->query("UPDATE compra_ingrediente SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE compra_id = '$compra_id'");

        $mensaje = "Compra eliminada";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "No es posible eliminar la compra";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Iventario - ManGo!</title>
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>

    <script>
    $(document).ready(function() {
        $("#resultadoBusqueda").html('');
    });

    var delayTimer;
    function buscar() {
        clearTimeout(delayTimer);
        delayTimer = setTimeout(function() {
            
            var textoBusqueda = $("input#busqueda").val();
         
             if (textoBusqueda != "") {
                $$.post("zonas_entrega_buscar.php", {busqueda: textoBusqueda}, function(mensaje) {
                    $("#resultadoBusqueda").html(mensaje);
                 }); 
             } else { 
                $("#resultadoBusqueda").html('');
                };
        
        }, 500); // Will do the ajax stuff after 1000 ms, or 1 s
    }
    </script>
</head>
<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="index.php#compras"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Inventario</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto las compras enviadas
    $consulta = $conexion->query("SELECT * FROM compra WHERE estado = 'enviado' and destino = '$sesion_local_id' ORDER BY fecha_alta");

    if ($consulta->num_rows == 0)
    {
        ?>        

        

        <?php
    }
    else
    {
        ?>        
            
        <h2 class="rdm-lista--titulo-largo">Compras enviadas</h2>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc()) 
        {
            $compra_id = $fila['compra_id'];
            $usuario_alta = $fila['usuario_alta'];
            $estado = $fila['estado'];
            $destino = $fila['destino'];

            //consulto el usuario alta
            $consulta_usuario = $conexion->query("SELECT * FROM usuario WHERE usuario_id = '$usuario_alta'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $nombres = $fila['nombres'];
                $apellidos = $fila['apellidos'];
                $enviado_por = "$nombres $apellidos";

            }
            else
            {
                $enviado_por = "";
            }


            //consulto el destino
            $consulta2 = $conexion->query("SELECT * FROM local WHERE local_id = $destino");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $local = $filas2['local'];

            }
            else
            {
                $local = "";
            }

            //consulto la cantidad_enviada de ingredientes en la compra
            $consulta_ingredientes = $conexion->query("SELECT * FROM compra_ingrediente WHERE compra_id = '$compra_id'");
            $total_ingredientes = $consulta_ingredientes->num_rows;

            //consulto el costo
            $consulta_costo = $conexion->query("SELECT * FROM compra_ingrediente WHERE compra_id = '$compra_id' ORDER BY fecha_alta DESC");

            if ($consulta_costo->num_rows != 0)
            {
                $composicion_costo = 0;

                while ($fila = $consulta_costo->fetch_assoc())
                {
                    //datos de la composicion
                    $compra_ingrediente_id = $fila['compra_ingrediente_id'];
                    $cantidad_enviada = $fila['cantidad_enviada'];
                    $ingrediente_id = $fila['ingrediente_id'];

                    //consulto el ingrediente
                    $consulta2 = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = $ingrediente_id");

                    if ($filas2 = $consulta2->fetch_assoc())
                    {            
                        $unidad_compra_c = $filas2['unidad_compra'];
                        $costo_unidad_compra_c = $filas2['costo_unidad_compra'];            
                    }
                    else
                    {            
                        $unidad_compra_c = "unid";
                        $costo_unidad_compra_c = 0;
                    }

                    //costo del ingrediente
                    $ingrediente_costo = $costo_unidad_compra_c * $cantidad_enviada;

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

            //color de fondo segun la primer letra
            $avatar_id = $compra_id;
            $avatar_nombre = "$enviado_por";

            include ("sis/avatar_color.php");
            
            //consulto el avatar
            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';
            ?>

            <a href="inventario_recibir.php?compra_id=<?php echo($compra_id) ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucwords("$enviado_por"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ($total_ingredientes); ?> Ingredientes  •  Costo: $<?php echo number_format($costo_valor, 2, ",", "."); ?></h2>
                        </div>
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
    //consulto el inventario del local          
    $consulta = $conexion->query("SELECT * FROM inventario WHERE local_id = '$sesion_local_id'");

    if ($consulta->num_rows == 0)
    {
        ?>        

        <h2 class="rdm-lista--titulo-largo">Ingredientes</h2>

        <section class="rdm-lista">
            
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-info zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>
                        <h2 class="rdm-lista--texto-secundario">No hay ingredientes en tu inventario</h2>
                    </div>
                </div>
                
            </article>

        </section>

        <?php
    }
    else
    {
        ?>        
            
        <h2 class="rdm-lista--titulo-largo">Enviadas</h2>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc()) 
        {
            $compra_id = $fila['compra_id'];
            $estado = $fila['estado'];
            $destino = $fila['destino'];

            //consulto el destino
            $consulta2 = $conexion->query("SELECT * FROM local WHERE local_id = $destino");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $local = $filas2['local'];

            }
            else
            {
                $local = "";
            }

            //consulto la cantidad_enviada de ingredientes en la compra
            $consulta_ingredientes = $conexion->query("SELECT * FROM compra_ingrediente WHERE compra_id = '$compra_id'");
            $total_ingredientes = $consulta_ingredientes->num_rows;

            //consulto el costo
            $consulta_costo = $conexion->query("SELECT * FROM compra_ingrediente WHERE compra_id = '$compra_id' ORDER BY fecha_alta DESC");

            if ($consulta_costo->num_rows != 0)
            {
                $composicion_costo = 0;

                while ($fila = $consulta_costo->fetch_assoc())
                {
                    //datos de la composicion
                    $compra_ingrediente_id = $fila['compra_ingrediente_id'];
                    $cantidad_enviada = $fila['cantidad_enviada'];
                    $ingrediente_id = $fila['ingrediente_id'];

                    //consulto el ingrediente
                    $consulta2 = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = $ingrediente_id");

                    if ($filas2 = $consulta2->fetch_assoc())
                    {            
                        $unidad_compra_c = $filas2['unidad_compra'];
                        $costo_unidad_compra_c = $filas2['costo_unidad_compra'];            
                    }
                    else
                    {            
                        $unidad_compra_c = "unid";
                        $costo_unidad_compra_c = 0;
                    }

                    //costo del ingrediente
                    $ingrediente_costo = $costo_unidad_compra_c * $cantidad_enviada;

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

            //color de fondo segun la primer letra
            $avatar_id = $compra_id;
            $avatar_nombre = "$local";

            include ("sis/avatar_color.php");
            
            //consulto el avatar
            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';
            ?>

            
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst("$local"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ($total_ingredientes); ?> Ingredientes  •  Costo: $<?php echo number_format($costo_valor, 2, ",", "."); ?></h2>
                        </div>
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