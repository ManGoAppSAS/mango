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
//variables de subida
if(isset($_POST['agregar'])) $agregar = $_POST['agregar']; elseif(isset($_GET['agregar'])) $agregar = $_GET['agregar']; else $agregar = null;

//variables del formulario
if(isset($_POST['nombre'])) $nombre = $_POST['nombre']; elseif(isset($_GET['nombre'])) $nombre = $_GET['nombre']; else $nombre = null;
if(isset($_POST['precio'])) $precio = $_POST['precio']; elseif(isset($_GET['precio'])) $precio = $_GET['precio']; else $precio = null;
if(isset($_POST['impuesto_incluido'])) $impuesto_incluido = $_POST['impuesto_incluido']; elseif(isset($_GET['impuesto_incluido'])) $impuesto_incluido = $_GET['impuesto_incluido']; else $impuesto_incluido = "no";
if(isset($_POST['precio_principal'])) $precio_principal = $_POST['precio_principal']; elseif(isset($_GET['precio_principal'])) $precio_principal = $_GET['precio_principal']; else $precio_principal = "no";

//variables foraneas
if(isset($_POST['producto_id'])) $producto_id = $_POST['producto_id']; elseif(isset($_GET['producto_id'])) $producto_id = $_GET['producto_id']; else $producto_id = 0;
if(isset($_POST['impuesto_id'])) $impuesto_id = $_POST['impuesto_id']; elseif(isset($_GET['impuesto_id'])) $impuesto_id = $_GET['impuesto_id']; else $impuesto_id = 0;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php 
//consulto el impuesto enviado desde el select del formulario
$consulta_impuesto_g = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id = '$impuesto_id'");

if ($fila = $consulta_impuesto_g->fetch_assoc()) 
{    
    $impuesto_g = ucfirst($fila['impuesto']);
    $porcentaje_g = ($fila['porcentaje']);
    $impuesto_g = "<option value='$impuesto_id'>$impuesto_g $porcentaje_g%</option>";
}
else
{
    $impuesto_g = "<option value=''></option>";
    $porcentaje_g = null;
}
?>

<?php
//agregar el precio al producto
if ($agregar == 'si')
{
    $precio = str_replace('.','',$precio);

    $consulta = $conexion->query("SELECT * FROM producto_precio WHERE precio = '$precio' and producto_id = '$producto_id'");

    if ($consulta->num_rows == 0)
    {
        $insercion = $conexion->query("INSERT INTO producto_precio values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$nombre', 'secundario', '$precio', '$impuesto_incluido', '$producto_id', '$impuesto_id')");

        $mensaje = "Precio <b>" . ($nombre) . "</b> agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";

        $id = $conexion->insert_id;
        $producto_precio_id = $id;

        if ($precio_principal == "si")
        {            
            //actualizo el precio principal
            $actualizar_precio_secundario = $conexion->query("UPDATE producto_precio SET tipo = 'secundario' WHERE producto_id = '$producto_id'");
            $actualizar_precio_principal = $conexion->query("UPDATE producto_precio SET tipo = 'principal' WHERE producto_precio_id = '$producto_precio_id'");
        }
        

    }
    else
    {
        $mensaje = "El precio <b>" . ($nombre) . "</b> ya existe, no es posible agregarlo de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Precios - ManGo!</title>    
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>

    <script type="text/javascript">
        $(document).ready(function () {
                 
        }); 

        jQuery(function($) {
            $('#precio').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'}); 
            
        });
    </script>

</head>
<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="productos_detalle.php?producto_id=<?php echo "$producto_id"; ?>#precios"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Precios</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Agregar</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    
        <section class="rdm-formulario">
        
            <input type="hidden" name="producto_id" value="<?php echo "$producto_id"; ?>" />

            <p class="rdm-formularios--label"><label for="nombre">Nombre*</label></p>
            <p><input type="text" id="nombre" name="nombre" value="<?php echo "$nombre"; ?>" required autofocus/></p>
            <p class="rdm-formularios--ayuda">Ej: Distribuidor, franquiciado, por mayor, etc.</p>

            <p class="rdm-formularios--label"><label for="precio">Precio*</label></p>
            <p><input type="tel" id="precio" name="precio" id="precio" value="<?php echo "$precio"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Precio del producto o servicio</p>

            <?php
            //consulto y muestro los impuestos
            $consulta = $conexion->query("SELECT * FROM impuesto WHERE estado = 'activo' ORDER BY impuesto");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="impuesto_id" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $impuesto_id = $fila['impuesto_id'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($impuesto_id) ?>" name="impuesto_id" value="<?php echo ($impuesto_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="impuesto_id">Impuesto*</label></p>
                    <p><select id="impuesto_id" name="impuesto_id" required >

                    <?php
                    //si hay mas de un registro los muestro todos menos el impuesto acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id != $impuesto_id and estado = 'activo' ORDER BY impuesto");

                    ?>
                        
                    <?php echo "$impuesto_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $impuesto_id = $fila['impuesto_id'];
                        $impuesto = $fila['impuesto'];
                        $porcentaje = $fila['porcentaje'];
                        ?>

                        <option value="<?php echo "$impuesto_id"; ?>"><?php echo ucfirst($impuesto) ?> <?php echo ($porcentaje); ?>%</option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">Elige el impuesto que aplica</p>
                    
                    <?php
                }
            }
            ?>

            <?php
            //impuesto incluido checked
            if ($impuesto_incluido == "si")
            {
                $impuesto_incluido_checked = "checked";
            }
            else
            {
                $impuesto_incluido_checked = "";
            }
            ?>
            
            <p class="rdm-formularios--label"><label for="impuesto_incluido">Impuesto incluido*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="impuesto_incluido" name="impuesto_incluido" class="rdm-formularios--switch" value="si" <?php echo "$impuesto_incluido_checked"; ?>>
                <label for="impuesto_incluido" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">¿El impuesto está incluido en el precio?</p>





            <?php
            //establecer como principal checked
            if ($precio_principal == "si")
            {
                $precio_principal_checked = "checked";
            }
            else
            {
                $precio_principal_checked = "";
            }
            ?>
            
            <p class="rdm-formularios--label"><label for="precio_principal">Precio principal*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="precio_principal" name="precio_principal" class="rdm-formularios--switch" value="si" <?php echo "$precio_principal_checked"; ?>>
                <label for="precio_principal" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">¿Establecer como precio principal?</p>


            
            <button type="submit" class="rdm-boton--fab" name="agregar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>        
            
        </section>

    </form>
    
</main>

<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>

<footer></footer>

</body> 
</html>