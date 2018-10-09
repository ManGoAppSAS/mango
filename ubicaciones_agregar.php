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
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

//variables del formulario
if(isset($_POST['ubicacion'])) $ubicacion = $_POST['ubicacion']; elseif(isset($_GET['ubicacion'])) $ubicacion = $_GET['ubicacion']; else $ubicacion = null;
if(isset($_POST['ubicada'])) $ubicada = $_POST['ubicada']; elseif(isset($_GET['ubicada'])) $ubicada = $_GET['ubicada']; else $ubicada = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['impuestos'])) $impuestos = $_POST['impuestos']; elseif(isset($_GET['impuestos'])) $impuestos = $_GET['impuestos']; else $impuestos = "no";
if(isset($_POST['porcentaje_comision'])) $porcentaje_comision = $_POST['porcentaje_comision']; elseif(isset($_GET['porcentaje_comision'])) $porcentaje_comision = $_GET['porcentaje_comision']; else $porcentaje_comision = 0;
if(isset($_POST['local_id'])) $local_id = $_POST['local_id']; elseif(isset($_GET['local_id'])) $local_id = $_GET['local_id']; else $local_id = 0;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php 
//consulto el local enviado desde el select del formulario
$consulta_local_g = $conexion->query("SELECT local, tipo FROM local WHERE local_id = '$local_id'");           

if ($fila = $consulta_local_g->fetch_assoc()) 
{    
    $local_g = ucfirst($fila['local']);
    $local_g = "<option value='$local_id'>$local_g</option>";
}
else
{
    $local_g = "<option value=''></option>";
    $local_tipo_g = null;
}
?>

<?php
//agregar la ubicacion
if ($agregar == 'si')
{
    $consulta = $conexion->query("SELECT * FROM ubicacion WHERE ubicacion = '$ubicacion' and ubicada = '$ubicada' and tipo = '$tipo' and local_id = '$local_id'");

    if ($consulta->num_rows == 0)
    {
        $insercion = $conexion->query("INSERT INTO ubicacion values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$ubicacion', '$ubicada', '$tipo', '$impuestos', '$porcentaje_comision', '$local_id')");        

        $mensaje = "Ubicación <b>" . ($ubicacion) . "</b> agregada";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "La ubicación <b>" . ($ubicacion) . "</b> ya existe, no es posible agregarla de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ubicaciones - ManGo!</title>    
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
            <a href="ubicaciones_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Ubicaciones</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Agregar</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    
        <section class="rdm-formulario">
        
            <p class="rdm-formularios--label"><label for="ubicacion">Nombre*</label></p>
            <p><input type="text" id="ubicacion" name="ubicacion" value="<?php echo "$ubicacion"; ?>" spellcheck="false" required autofocus/></p>
            <p class="rdm-formularios--ayuda">Ej: mesa 1, habitación 3, silla 4, etc.</p>

            <p class="rdm-formularios--label"><label for="ubicada">Ubicada en*</label></p>
            <p><input type="text" id="ubicada" name="ubicada" value="<?php echo "$ubicada"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Ej: interior, segundo piso, terraza, etc.</p>

            <p class="rdm-formularios--label"><label for="tipo">Tipo*</label></p>
            <p><select id="tipo" name="tipo" required>
                <option value="<?php echo "$tipo"; ?>"><?php echo ucfirst($tipo) ?></option>
                <option value=""></option>
                <option value="barra">Barra</option>
                <option value="caja">Caja</option>
                <option value="domicilio">Domicilio</option>
                <option value="habitacion">Habitación</option>
                <option value="mesa">Mesa</option>
                <option value="persona">Persona</option>
                <option value="silla">Silla</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Tipo de ubicación</p>
            
            <?php
            //consulto y muestro los locales
            $consulta = $conexion->query("SELECT * FROM local WHERE estado = 'activo' ORDER BY local");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="local_id" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $local_id = $fila['local_id'];
                        $local = $fila['local'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($local_id) ?>" name="local_id" value="<?php echo ($local_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="local_id">Local*</label></p>
                    <p><select id="local_id" name="local_id" required autofocus>

                    <?php
                    //si hay mas de un registro los muestro todos menos el local que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM local WHERE local_id != $local_id and estado = 'activo' ORDER BY local");

                    ?>
                        
                    <?php echo "$local_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $local_id = $fila['local_id'];
                        $local = $fila['local'];
                        ?>

                        <option value="<?php echo "$local_id"; ?>"><?php echo ucfirst($local) ?></option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">Local al que se relaciona el usuario</p>
                    
                    <?php
                }
            }
            ?>

            <?php
            //atributo checked
            if ($impuestos == "si")
            {
                $impuestos_checked = "checked";
            }
            else
            {
                $impuestos_checked = "";
            }
            ?>
    
            <p class="rdm-formularios--label"><label for="impuestos">Impuestos*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="impuestos" name="impuestos" class="rdm-formularios--switch" value="si" <?php echo "$impuestos_checked"; ?>>
                <label for="impuestos" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">¿Esta ubicación genera impuestos?</p>

            <p class="rdm-formularios--label"><label for="porcentaje_comision">Comisión de ventas</label></p>
            <p><input type="number" min="0" max="100" id="porcentaje_comision" name="porcentaje_comision" value="<?php echo "$porcentaje_comision"; ?>" step="any" required /></p>
            <p class="rdm-formularios--ayuda">Valor del porcentaje sin símbolos o guiones</p>
            
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