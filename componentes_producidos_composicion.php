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
if(isset($_POST['agregar'])) $agregar = $_POST['agregar']; elseif(isset($_GET['agregar'])) $agregar = $_GET['agregar']; else $agregar = null;

//variable para eliminar
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;
if(isset($_POST['componente_producido_composicion_id'])) $componente_producido_composicion_id = $_POST['componente_producido_composicion_id']; elseif(isset($_GET['componente_producido_composicion_id'])) $componente_producido_composicion_id = $_GET['componente_producido_composicion_id']; else $componente_producido_composicion_id = null;

//variable de consulta
if(isset($_POST['busqueda'])) $busqueda = $_POST['busqueda']; elseif(isset($_GET['busqueda'])) $busqueda = $_GET['busqueda']; else $busqueda = null;

//capturo las variables que pasan por URL o formulario
if(isset($_POST['componente_producido_id'])) $componente_producido_id = $_POST['componente_producido_id']; elseif(isset($_GET['componente_producido_id'])) $componente_producido_id = $_GET['componente_producido_id']; else $componente_producido_id = null;
if(isset($_POST['componente_id'])) $componente_id = $_POST['componente_id']; elseif(isset($_GET['componente_id'])) $componente_id = $_GET['componente_id']; else $componente_id = null;
if(isset($_POST['cantidad'])) $cantidad = $_POST['cantidad']; elseif(isset($_GET['cantidad'])) $cantidad = $_GET['cantidad']; else $cantidad = null;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>


<?php
//consulto el componente
$consulta_componente = $conexion->query("SELECT * FROM componente WHERE componente_id = '$componente_id'");

if ($fila_componente = $consulta_componente->fetch_assoc())
{
    $componente_id = $fila_componente['componente_id'];
    $componente = $fila_componente['componente'];
}
?>

<?php
//elimino el componente de la composición
if ($eliminar == "si")
{
    $borrar = $conexion->query("DELETE FROM componente_producido_composicion WHERE componente_producido_composicion_id = '$componente_producido_composicion_id'");

    if ($borrar)
    {
        $mensaje = "Componente retirado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
}
?>

<?php
//agrego el componente a la composición
if ($agregar == 'si')
{   
    if ($cantidad == 0)
    {
        $cantidad = 1;
    }

    $consulta = $conexion->query("SELECT * FROM componente_producido_composicion WHERE componente_producido_id = '$componente_producido_id' and componente_id = '$componente_id'");

    if ($consulta->num_rows == 0)
    {
        $insercion = $conexion->query("INSERT INTO componente_producido_composicion values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$cantidad', '$componente_producido_id', '$componente_id')");
        
        $mensaje = "Componente <b>".($componente)."</b> agregado a la composición</b>";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "El componente <b>".($componente)."</b> ya fue agregado</b>";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Composición - ManGo!</title>    
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
            $.post("componentes_producidos_composicion_buscar.php?componente_producido_id=<?php echo "$componente_producido_id"; ?>", {busqueda: textoBusqueda}, function(mensaje) {
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
            <a href="componentes_producidos_detalle.php?componente_producido_id=<?php echo "$componente_producido_id"; ?>#composicion"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Composición</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <input type="search" name="busqueda" id="busqueda" value="<?php echo "$busqueda"; ?>" placeholder="Buscar componente" maxlength="30" autofocus autocomplete="off" onKeyUp="buscar();" onFocus="buscar(); this.select();" />

    <div id="resultadoBusqueda"></div>

    <section class="rdm-lista">    

    <?php
    //consulto y muestros la composición de este componente producido
    $consulta = $conexion->query("SELECT * FROM componente_producido_composicion WHERE componente_producido_id = '$componente_producido_id' ORDER BY fecha_alta DESC");

    if ($consulta->num_rows == 0)
    {
        
    }
    else                 
    {
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

            //calculo el costo del componente
            $componente_costo = $costo_unidad_minima * $cantidad;
            ?>

            <div class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <?php echo "$imagen"; ?>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo"><?php echo ($cantidad); ?> <?php echo ucfirst($unidad_minima); ?> de <?php echo ucfirst($componente); ?></h2>
                        <h2 class="rdm-lista--texto-secundario">$<?php echo number_format($componente_costo, 2, ",", "."); ?></h2>
                    </div>
                </div>
                <div class="rdm-lista--derecha-sencillo">
                    <a href="componentes_producidos_composicion.php?eliminar=si&componente_producido_composicion_id=<?php echo ($componente_producido_composicion_id); ?>&componente_producido_id=<?php echo ($componente_producido_id); ?>&busqueda=<?php echo ($busqueda); ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-close zmdi-hc-2x"></i></div></a>
                </div>
            </div>
           
            <?php
        }        
    }
    ?>

    </section>













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

            $componente = $fila['componente'];
            $tipo = $fila['tipo'];
            $unidad_minima = $fila['unidad_minima'];
            $unidad_compra = $fila['unidad_compra'];
            $costo_unidad_minima = $fila['costo_unidad_minima'];
            $costo_unidad_compra = $fila['costo_unidad_compra'];
            $preparacion = $fila['preparacion'];
            $cantidad_unidad_compra = $fila['cantidad_unidad_compra'];

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
                $costo_valor = $composicion_costo;       
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
                        <div class="rdm-tarjeta--separador"></div>
                    <?php } ?>

                    <?php if (!empty($tipo)) { ?>
                        <p><b>Tipo</b> <br><?php echo ucfirst($tipo) ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_minima)) { ?>
                        <p><b>Unidad mínima</b> <br>$<?php echo number_format($costo_unidad_minima, 2, ",", "."); ?> x <?php echo ucfirst($unidad_minima); ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_compra)) { ?>
                        <p><b>Unidad de producción</b> <br>$<?php echo number_format($costo_unidad_compra, 2, ",", "."); ?> x <?php echo ucfirst($unidad_compra); ?></p>
                    <?php } ?>

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
    
    

</footer>

</body>
</html>