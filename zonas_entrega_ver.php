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
if(isset($_POST['zona_entrega_id'])) $zona_entrega_id = $_POST['zona_entrega_id']; elseif(isset($_GET['zona_entrega_id'])) $zona_entrega_id = $_GET['zona_entrega_id']; else $zona_entrega_id = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//elimino la zona de entrega
if ($eliminar == 'si')
{
    $borrar = $conexion->query("UPDATE zona_entrega SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE zona_entrega_id = '$zona_entrega_id'");

    if ($borrar)
    {
        $mensaje = "Zona de entrega eliminada";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "No es posible eliminar la zona de entrega";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Zonas de entrega - ManGo!</title>
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
            $.post("zonas_entrega_buscar.php", {busqueda: textoBusqueda}, function(mensaje) {
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
            <a href="ajustes.php#zonas"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Zonas de entrega</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto las zonas de entregas              
    $consulta = $conexion->query("SELECT * FROM zona_entrega WHERE estado = 'activo' ORDER BY zona_entrega");

    if ($consulta->num_rows == 0)
    {
        ?>        

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">No se han agregado zonas de entrega</p>
            <p class="rdm-tipografia--cuerpo1--margen-ajustada">Las zonas de entrega son los lugares a donde llegan los pedidos de productos o servicios que se generan en una venta, por ejemplo: la comida se entrega en la cocina, las carnes en la parrilla, los licores en el bar, las camisas en la  bodega, etc.</p>
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
            $zona_entrega_id = $fila['zona_entrega_id'];
            $zona_entrega = $fila['zona_entrega'];

            //consulto la cantidad de productos
            $consulta_productos = $conexion->query("SELECT * FROM producto WHERE zona_entrega_id = '$zona_entrega_id'");
            $total_productos = $consulta_productos->num_rows;

            //color de fondo segun la primer letra
            $avatar_id = $zona_entrega_id;
            $avatar_nombre = "$zona_entrega";

            include ("sis/avatar_color.php");
            
            //consulto el avatar
            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';
            ?>

            <a href="zonas_entrega_detalle.php?zona_entrega_id=<?php echo "$zona_entrega_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst("$zona_entrega"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ($total_productos); ?> Productos</h2>
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
    
    <a href="zonas_entrega_agregar.php"><button class="rdm-boton--fab" ><i class="zmdi zmdi-plus zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>