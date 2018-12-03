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
include('sis/subir.php');

$carpeta_destino = (isset($_GET['dir']) ? $_GET['dir'] : 'img/avatares');
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $carpeta_destino);
?>

<?php
//variables de subida
if(isset($_POST['agregar'])) $agregar = $_POST['agregar']; elseif(isset($_GET['agregar'])) $agregar = $_GET['agregar']; else $agregar = null;
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

//variables del formulario
if(isset($_POST['local'])) $local = $_POST['local']; elseif(isset($_GET['local'])) $local = $_GET['local']; else $local = null;
if(isset($_POST['nit'])) $nit = $_POST['nit']; elseif(isset($_GET['nit'])) $nit = $_GET['nit']; else $nit = null;
if(isset($_POST['regimen'])) $regimen = $_POST['regimen']; elseif(isset($_GET['regimen'])) $regimen = $_GET['regimen']; else $regimen = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['direccion'])) $direccion = $_POST['direccion']; elseif(isset($_GET['direccion'])) $direccion = $_GET['direccion']; else $direccion = null;
if(isset($_POST['telefono'])) $telefono = $_POST['telefono']; elseif(isset($_GET['telefono'])) $telefono = $_GET['telefono']; else $telefono = null;
if(isset($_POST['apertura'])) $apertura = $_POST['apertura']; elseif(isset($_GET['apertura'])) $apertura = $_GET['apertura']; else $apertura = "09:00:00";
if(isset($_POST['cierre'])) $cierre = $_POST['cierre']; elseif(isset($_GET['cierre'])) $cierre = $_GET['cierre']; else $cierre = "17:00:00";
if(isset($_POST['propina'])) $propina = $_POST['propina']; elseif(isset($_GET['propina'])) $propina = $_GET['propina']; else $propina = 0;


//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//agregar el local
if ($agregar == 'si')
{
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
    }
    else
    {
        $imagen = "no";
    }

    $consulta = $conexion->query("SELECT local, telefono FROM local WHERE local = '$local' and telefono = '$telefono'");

    if ($consulta->num_rows == 0)
    {
        $imagen_ref = "locales";
        $insercion = $conexion->query("INSERT INTO local values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$local', '$nit','$regimen', 'punto de venta', '$direccion', '$telefono', '$apertura', '$cierre', '$propina', '$imagen', '$ahora_img')");

        $mensaje = "Local <b>" . ($local) . "</b> agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";

        $id = $conexion->insert_id;

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $mensaje = "El local <b>" . ucfirst($local) . "</b> ya existe, no es posible agregarlo de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Locales - ManGo!</title>    
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
            <a href="locales_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Locales</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Agregar</h2>
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">
        
            <input type="hidden" name="action" value="image" />

            <p class="rdm-formularios--label"><label for="local">Nombre*</label></p>
            <p><input type="text" id="local" name="local" value="<?php echo "$local"; ?>" spellcheck="false" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del local o punto de venta</p>

            <p class="rdm-formularios--label"><label for="nit">NIT</label></p>
            <p><input type="tel" id="nit" name="nit" value="<?php echo "$nit"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Número de NIT o RUT</p>

            <p class="rdm-formularios--label"><label for="regimen">Texto de régimen</label></p>
            <p><input type="text" id="regimen" name="regimen" value="<?php echo "$regimen"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Ej: Común, simplificado, gran contribuyente, etc.</p>            

            <p class="rdm-formularios--label"><label for="direccion">Dirección*</label></p>
            <p><input type="text" id="direccion" name="direccion" value="<?php echo "$direccion"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Dirección del local o punto de venta</p>

            <p class="rdm-formularios--label"><label for="telefono">Teléfono*</label></p>
            <p><input type="tel" id="telefono" name="telefono" value="<?php echo "$telefono"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Solo números, sin guiones o comas</p>

            <p class="rdm-formularios--label"><label for="fecha_inicio">Horario de atención*</label></p>
            <div class="rdm-formularios--fecha">
                <p><input type="time" id="apertura" name="apertura" value="<?php echo "$apertura"; ?>" required></p>
                <p class="rdm-formularios--ayuda">Apertura</p>
            </div>
            <div class="rdm-formularios--fecha">
                <p><input type="time" id="cierre" name="cierre" value="<?php echo "$cierre"; ?>" required></p>
                <p class="rdm-formularios--ayuda">Cierre</p>
            </div>

            <p class="rdm-formularios--label" style="margin-top: 0"><label for="propina">Propina*</label></p>
            <p><input type="number" id="propina" name="propina" value="<?php echo "$propina"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Porcentaje de la propina sin símbolos o guiones</p>

            <p class="rdm-formularios--label"><label for="archivo">Imagen</label></p>
            <p><input type="file" id="archivo" name="archivo" /></p>
            <p class="rdm-formularios--ayuda">Usa una imagen para identificarlo</p>

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