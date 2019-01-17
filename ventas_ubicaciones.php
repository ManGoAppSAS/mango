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
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;

//variable de consulta
if(isset($_POST['busqueda'])) $busqueda = $_POST['busqueda']; elseif(isset($_GET['busqueda'])) $busqueda = $_GET['busqueda']; else $busqueda = null;

//capturo las variables que pasan por URL o formulario
if(isset($_POST['ubicacion_id'])) $ubicacion_id = $_POST['ubicacion_id']; elseif(isset($_GET['ubicacion_id'])) $ubicacion_id = $_GET['ubicacion_id']; else $ubicacion_id = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//elimino la ubicacion
if ($eliminar == 'si')
{
    $borrar = $conexion->query("UPDATE ubicacion SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE ubicacion_id = '$ubicacion_id'");

    if ($borrar)
    {
        $mensaje = "Ubicacíón eliminada";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "No es posible eliminar la ubicación";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ventas - ManGo!</title>
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
                $.post("ubicaciones_buscar.php", {busqueda: textoBusqueda}, function(mensaje) {
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
            <a href="ventas_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Ubicaciones</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto las ubicaciones              
    $consulta = $conexion->query("SELECT ubicacion_id, ubicacion, ubicada, tipo, local_id FROM ubicacion WHERE estado = 'activo' ORDER BY ubicacion");

    if ($consulta->num_rows == 0)
    {
        ?>        

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">No se han agregado ubicaciones</p>
            <p class="rdm-tipografia--cuerpo1--margen-ajustada">Las ubicaciones son los distintos lugares desde donde puedes atender a tus clientes en un punto de venta. Todas las ventas siempre comienzan desde una ubicación, por ejemplo: mesas, barras, habitaciones, cajas registradoras, etc.</p>
        </div>

        <?php
    }
    else
    {
        ?>        
            
        <input type="search" name="busqueda" id="busqueda" value="<?php echo "$busqueda"; ?>" placeholder="Buscar" maxlength="30" autofocus autocomplete="off" onKeyUp="buscar();" onFocus="buscar();" />

        <div id="resultadoBusqueda"></div>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc()) 
        {
            $ubicacion_id = $fila['ubicacion_id'];
            $ubicacion = $fila['ubicacion'];
            $ubicada = $fila['ubicada'];
            $tipo = $fila['tipo'];
            $local_id = $fila['local_id'];

            //consulto el local
            $consulta2 = $conexion->query("SELECT * FROM local WHERE local_id = $local_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $local = ucfirst($filas2['local']);
                $local = "$tipo en $local";
            }
            else
            {
                $local = "$tipo";
            }

            //color de fondo segun la primer letra
            $avatar_id = $ubicacion_id;
            $avatar_nombre = "$ubicacion";

            include ("sis/avatar_color.php");

            //muestro el icono según el tipo de ubicación
            if ($tipo == "barra")
            {
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-cocktail zmdi-hc-2x"></i></div>';
            }
            else
            {
                if ($tipo == "caja")
                {
                    $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-laptop zmdi-hc-2x"></i></div>';
                }
                else
                {
                    if ($tipo == "habitacion")
                    {
                        $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-hotel zmdi-hc-2x"></i></div>';
                    }
                    else
                    {
                        if ($tipo == "mesa")
                        {
                            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-cutlery zmdi-hc-2x"></i></div>';
                        }
                        else
                        {
                            if ($tipo == "persona")
                            {
                                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-face zmdi-hc-2x"></i></div>';

                            }
                            else
                            {
                                if ($tipo == "domicilio")
                                {
                                    $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-bike zmdi-hc-2x"></i></div>';
                                }
                                else
                                {
                                    $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><i class="zmdi zmdi-seat zmdi-hc-2x"></i></div>';
                                }
                            }
                        }
                    }
                }
            }
            ?>

            <a href="ubicaciones_detalle.php?ubicacion_id=<?php echo "$ubicacion_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst("$ubicacion"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst("$local"); ?></h2>
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

</main>

<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>
    
<footer>
    
    <a href="ubicaciones_agregar.php"><button class="rdm-boton--fab" ><i class="zmdi zmdi-plus zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>