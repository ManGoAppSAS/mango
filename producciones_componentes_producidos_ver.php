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

if(isset($_POST['componente_producido_id'])) $componente_producido_id = $_POST['componente_producido_id']; elseif(isset($_GET['componente_producido_id'])) $componente_producido_id = $_GET['componente_producido_id']; else $componente_producido_id = null;
if(isset($_POST['componente'])) $componente = $_POST['componente']; elseif(isset($_GET['componente'])) $componente = $_GET['componente']; else $componente = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//elimino el componente
if ($eliminar == 'si')
{
    $borrar = $conexion->query("UPDATE componente SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE componente_producido_id = '$componente_producido_id'");

    if ($borrar)
    {
        $mensaje = "Componente producido eliminado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "No es posible eliminar el componente producido";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Componentes producidos - ManGo!</title>
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
                $.post("producciones_componentes_producidos_buscar.php", {busqueda: textoBusqueda}, function(mensaje) {
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
            <a href="index.php#producciones"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Componentes producidos</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto los componentes
    $consulta = $conexion->query("SELECT * FROM componente WHERE tipo = 'producido' and estado = 'activo' ORDER BY componente");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">No se han agregado componentes producidos</p>
            <p class="rdm-tipografia--cuerpo1--margen-ajustada">Los componentes producidos son todos los elementos de los que están hechos los productos o servicios que vendes y que tu mismo produces a partir de otros componentes, por ejemplo: salsas, mezclas, masas, coberturas, etc.</p>
        </div>

        <?php
    }
    else
    {   ?>

        <input type="search" name="busqueda" id="busqueda" value="<?php echo "$busqueda"; ?>" placeholder="Buscar" maxlength="30" autofocus autocomplete="off" onKeyUp="buscar();" onFocus="buscar();" />

        <div id="resultadoBusqueda"></div>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc())
        {
            $componente_producido_id = $fila['componente_id'];
            $componente = $fila['componente'];
            $unidad_minima = $fila['unidad_minima'];
            $unidad_compra = $fila['unidad_compra'];
            $costo_unidad_minima = $fila['costo_unidad_minima'];
            $costo_unidad_compra = $fila['costo_unidad_compra'];
            $cantidad_unidad_compra = $fila['cantidad_unidad_compra'];

            $productor_id = $fila['productor_id'];

            //color de fondo segun la primer letra
            $avatar_id = $componente_producido_id;
            $avatar_nombre = "$componente";

            include ("sis/avatar_color.php");
            
            //consulto el avatar
            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';

            //consulto el productor
            $consulta2 = $conexion->query("SELECT * FROM productor WHERE productor_id = $productor_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $productor = $filas2['productor'];
            }
            else
            {
                $productor = "";
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
                $costo_valor = $composicion_costo;       
            }
            else                 
            {
                //valor del costo
                $costo_valor = 0;
            }
            ?>

            <a href="producciones_componentes_producidos_detalle.php?componente_producido_id=<?php echo "$componente_producido_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst($componente); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst($productor); ?></h2>
                            <h2 class="rdm-lista--texto-secundario">$<?php echo number_format($costo_valor, 2, ",", "."); ?> x <?php echo ($cantidad_unidad_compra); ?> <?php echo ucfirst($unidad_compra); ?></h2>
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
    
    

</footer>

</body>
</html>