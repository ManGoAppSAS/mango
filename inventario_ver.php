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
//variable de consulta
if(isset($_POST['busqueda'])) $busqueda = $_POST['busqueda']; elseif(isset($_GET['busqueda'])) $busqueda = $_GET['busqueda']; else $busqueda = null;

//variables de mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inventario - ManGo!</title>
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
            $.post("inventario_buscar.php", {busqueda: textoBusqueda}, function(mensaje) {
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
            <a href="index.php#inventario"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Inventario</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto el componente en el inventario
    $consulta = $conexion->query("SELECT * FROM inventario WHERE local_id = '$sesion_local_id' ORDER BY (cantidad_actual - cantidad_minima)");

    if ($consulta->num_rows == 0)
    {
        ?>

        <h2 class="rdm-lista--titulo-largo">Inventario</h2>

        <section class="rdm-lista">
            
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-info zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>
                        <h2 class="rdm-lista--texto-secundario">Acá podrás ver la cantidad de componentes recibidos que hayan sido comprados o producidos</h2>
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
    {   
        ?>   

        <input type="search" name="busqueda" id="busqueda" value="<?php echo "$busqueda"; ?>" placeholder="Buscar" maxlength="30" autofocus autocomplete="off" onKeyUp="buscar();" onFocus="buscar();" />

        <div id="resultadoBusqueda"></div>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc()) 
        {
            $inventario_id = $fila['inventario_id'];
            $componente = $fila['componente'];
            $unidad = $fila['unidad'];
            $cantidad_actual = $fila['cantidad_actual'];
            $cantidad_minima = $fila['cantidad_minima'];
            $cantidad_maxima = $fila['cantidad_maxima'];


            //si la cantidad es cero o negativa
            if ($cantidad_actual <= 0)
            {
                $cantidad_actual = 0;
            }

            //si el minimo es igual a cero se pone el 10% de la cantidad_actual actual como minimo
            if ($cantidad_minima == 0)
            {
                $cantidad_minima = $cantidad_actual * 0.10;
            }

            //si el maximo es igual a cero se pone la cantidad_actual + 1
            if ($cantidad_maxima == 0)
            {
                $cantidad_maxima = $cantidad_actual + 1;
            }

            $porcentaje_inventario = ($cantidad_actual / $cantidad_maxima) * 100;

            if ($cantidad_actual <= $cantidad_minima)
            {
                $porcentaje_color_fondo = "#FFCDD2";
                $porcentaje_color_relleno = "#F44336";
            }
            else
            {
                $porcentaje_color_fondo = "#B2DFDB";
                $porcentaje_color_relleno = "#009688";
            }

            ?>

            <a href="inventario_novedades.php?inventario_id=<?php echo "$inventario_id"; ?>">

                <article class="rdm-lista--item-porcentaje">
                    <div>
                        <div class="rdm-lista--izquierda-porcentaje">
                            <h2 class="rdm-lista--titulo-porcentaje"><?php echo ucfirst("$componente"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo number_format($cantidad_actual, 0, ",", "."); ?> <?php echo ucfirst("$unidad"); ?></h2>
                        </div>
                        <div class="rdm-lista--derecha-porcentaje">
                            <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo number_format($porcentaje_inventario, 1, ".", "."); ?>%</h2>
                        </div>
                    </div>
                    
                    <div class="rdm-lista--linea-pocentaje-fondo" style="background-color: <?php echo "$porcentaje_color_fondo"; ?>">
                        <div class="rdm-lista--linea-pocentaje-relleno" style="width: <?php echo "$porcentaje_inventario"; ?>%; background-color: <?php echo "$porcentaje_color_relleno"; ?>;"></div>
                    </div>
                </article>

            </a>

            <a href="inventario_novedades.php?inventario_id=<?php echo "$inventario_id"; ?>">

                <article class="rdm-lista--item-porcentaje">
                    <div>
                        <div class="rdm-lista--izquierda-porcentaje">
                            <h2 class="rdm-lista--titulo-porcentaje"><?php echo ucfirst("$componente"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo number_format($cantidad_actual, 0, ",", "."); ?> <?php echo ucfirst("$unidad"); ?></h2>
                        </div>
                        <div class="rdm-lista--derecha-porcentaje">
                            <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo number_format($porcentaje_inventario, 1, ".", "."); ?>%</h2>
                        </div>
                    </div>
                    
                    <div class="rdm-lista--linea-pocentaje-fondo" style="background-color: <?php echo "$porcentaje_color_fondo"; ?>">
                        <div class="rdm-lista--linea-pocentaje-relleno" style="width: <?php echo "$porcentaje_inventario"; ?>%; background-color: <?php echo "$porcentaje_color_relleno"; ?>;"></div>
                    </div>
                </article>

            </a>

            <a href="inventario_novedades.php?inventario_id=<?php echo "$inventario_id"; ?>">

                <article class="rdm-lista--item-porcentaje">
                    <div>
                        <div class="rdm-lista--izquierda-porcentaje">
                            <h2 class="rdm-lista--titulo-porcentaje"><?php echo ucfirst("$componente"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo number_format($cantidad_actual, 0, ",", "."); ?> <?php echo ucfirst("$unidad"); ?></h2>
                        </div>
                        <div class="rdm-lista--derecha-porcentaje">
                            <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo number_format($porcentaje_inventario, 1, ".", "."); ?>%</h2>
                        </div>
                    </div>
                    
                    <div class="rdm-lista--linea-pocentaje-fondo" style="background-color: <?php echo "$porcentaje_color_fondo"; ?>">
                        <div class="rdm-lista--linea-pocentaje-relleno" style="width: <?php echo "$porcentaje_inventario"; ?>%; background-color: <?php echo "$porcentaje_color_relleno"; ?>;"></div>
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

    <a href="despachos_detalle.php?agregar_despacho=si&destino=<?php echo "$sesion_local_id"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-plus zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>