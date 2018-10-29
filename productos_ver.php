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
if(isset($_POST['producto_id'])) $producto_id = $_POST['producto_id']; elseif(isset($_GET['producto_id'])) $producto_id = $_GET['producto_id']; else $producto_id = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//elimino el producto
if ($eliminar == 'si')
{
    //borro los datos del producto
    $borrar_producto = $conexion->query("UPDATE producto SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE producto_id = '$producto_id'");

    //borro los locales en lo que se vende el producto
    $borrar_producto_local = $conexion->query("UPDATE producto_local SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE producto_id = '$producto_id'");

    //borro los precios del producto
    $borrar_producto_precio = $conexion->query("UPDATE producto_precio SET fecha_baja = '$ahora', usuario_baja = '$sesion_id', estado = 'eliminado' WHERE producto_id = '$producto_id'");

    if ($borrar_producto)
    {
        $mensaje = "Producto eliminado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "No es posible eliminar el producto";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Productos - ManGo!</title>
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
                $.post("productos_buscar.php", {busqueda: textoBusqueda}, function(mensaje) {
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
            <a href="ajustes.php#productos"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Productos</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto los productos
    $consulta = $conexion->query("SELECT * FROM producto WHERE estado = 'activo' ORDER BY producto");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">No se han agregado productos</p>
            <p class="rdm-tipografia--cuerpo1--margen-ajustada">Los productos son todos los artículos o servicios que vendes en tu negocio, estos estarán agrupados en las categorías que hayas creado, por ejemplo: bebida pequeña, hamburguesa mediana, postre de fresa, etc.</p>
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
            $producto_id = $fila['producto_id'];
            $producto = $fila['producto'];
            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];
            $categoria_id = $fila['categoria_id'];

            //color de fondo segun la primer letra
            $avatar_id = $producto_id;
            $avatar_nombre = "$producto";

            include ("sis/avatar_color.php");
            
            //consulto el avatar
            if ($imagen == "no")
            {
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';
            }
            else
            {
                $imagen = "img/avatares/productos-$producto_id-$imagen_nombre-m.jpg";
                $imagen = '<div class="rdm-lista--avatar" style="background-image: url('.$imagen.');"></div>';
            }

            //consulto la categoria
            $consulta2 = $conexion->query("SELECT * FROM categoria WHERE categoria_id = $categoria_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $categoria = $filas2['categoria'];
            }
            else
            {
                $categoria = "No se ha asignado una categoria";
            }
            ?>

            <a href="productos_detalle.php?producto_id=<?php echo "$producto_id"; ?>">
                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst($producto); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst($categoria); ?></h2>
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
    
    <a href="productos_agregar.php"><button class="rdm-boton--fab" ><i class="zmdi zmdi-plus zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>