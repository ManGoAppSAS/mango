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
if(isset($_POST['descuento'])) $descuento = $_POST['descuento']; elseif(isset($_GET['descuento'])) $descuento = $_GET['descuento']; else $descuento = null;
if(isset($_POST['porcentaje'])) $porcentaje = $_POST['porcentaje']; elseif(isset($_GET['porcentaje'])) $porcentaje = $_GET['porcentaje']; else $porcentaje = null;
if(isset($_POST['aplica'])) $aplica = $_POST['aplica']; elseif(isset($_GET['aplica'])) $aplica = $_GET['aplica']; else $aplica = null;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//agregar el descuento
if ($agregar == 'si')
{
    $consulta = $conexion->query("SELECT * FROM descuento WHERE descuento = '$descuento' and porcentaje = '$porcentaje' and aplica = '$aplica'");

    if ($consulta->num_rows == 0)
    {
        $insercion = $conexion->query("INSERT INTO descuento values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$descuento', '$porcentaje', '$aplica')");        

        $mensaje = "Descuento <b>" . ($descuento) . "</b> agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "El descuento <b>" . ($descuento) . "</b> ya existe, no es posible agregarlo de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Descuentos - ManGo!</title>    
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
            <a href="descuentos_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Descuentos</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Agregar</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    
        <section class="rdm-formulario">
        
            <p class="rdm-formularios--label"><label for="descuento">Nombre*</label></p>
            <p><input type="text" id="descuento" name="descuento" value="<?php echo "$descuento"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del descuento</p>

            <p class="rdm-formularios--label"><label for="porcentaje">Porcentaje*</label></p>
            <p><input type="number" min="0" max="100" id="porcentaje" name="porcentaje" value="<?php echo "$porcentaje"; ?>" step="any" required /></p>
            <p class="rdm-formularios--ayuda">Valor del porcentaje sin símbolos o guiones</p>

            <p class="rdm-formularios--label"><label for="aplica">Aplica en*</label></p>
            <p><select id="aplica" name="aplica" required>
                <option value="<?php echo "$aplica"; ?>"><?php echo ucfirst($aplica) ?></option>
                <option value="productos">Productos</option>
                <option value="ventas">Ventas</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Elige una opción</p>
            
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