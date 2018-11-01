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
if(isset($_POST['productor'])) $productor = $_POST['productor']; elseif(isset($_GET['productor'])) $productor = $_GET['productor']; else $productor = null;
if(isset($_POST['documento_tipo'])) $documento_tipo = $_POST['documento_tipo']; elseif(isset($_GET['documento_tipo'])) $documento_tipo = $_GET['documento_tipo']; else $documento_tipo = null;
if(isset($_POST['documento_numero'])) $documento_numero = $_POST['documento_numero']; elseif(isset($_GET['documento_numero'])) $documento_numero = $_GET['documento_numero']; else $documento_numero = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['correo'])) $correo = $_POST['correo']; elseif(isset($_GET['correo'])) $correo = $_GET['correo']; else $correo = null;
if(isset($_POST['contacto'])) $contacto = $_POST['contacto']; elseif(isset($_GET['contacto'])) $contacto = $_GET['contacto']; else $contacto = null;
if(isset($_POST['telefono'])) $telefono = $_POST['telefono']; elseif(isset($_GET['telefono'])) $telefono = $_GET['telefono']; else $telefono = null;
if(isset($_POST['direccion'])) $direccion = $_POST['direccion']; elseif(isset($_GET['direccion'])) $direccion = $_GET['direccion']; else $direccion = null;
if(isset($_POST['cuenta_bancaria'])) $cuenta_bancaria = $_POST['cuenta_bancaria']; elseif(isset($_GET['cuenta_bancaria'])) $cuenta_bancaria = $_GET['cuenta_bancaria']; else $cuenta_bancaria = null;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//agregar el usuario
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

    $consulta = $conexion->query("SELECT documento_numero FROM productor WHERE documento_numero = '$documento_numero'");

    if ($consulta->num_rows == 0)
    {
        $imagen_ref = "productores";
        $insercion = $conexion->query("INSERT INTO productor values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$productor', '$documento_tipo', '$documento_numero', '$tipo', '$correo', '$contacto', '$telefono', '$direccion', '$cuenta_bancaria', '$imagen', '$ahora_img')");        

        $mensaje = "Productor <b>" . ucfirst($productor) . "</b> agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";

        $id = $conexion->insert_id;

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $mensaje = "El productor <b>" . ucfirst($productor) . "</b> ya existe, no es posible agregarlo de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Productores - ManGo!</title>    
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
            <a href="productores_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Productores</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Agregar</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    
        <section class="rdm-formulario">
        
            <input type="hidden" name="action" value="image" />            

            <p class="rdm-formularios--label"><label for="productor">Nombre*</label></p>
            <p><input type="text" id="productor" name="productor" value="<?php echo "$productor"; ?>" spellcheck="false" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del productor</p>           

            <p class="rdm-formularios--label"><label for="documento_tipo">Tipo de documento*</label></p>
            <p><select id="documento_tipo" name="documento_tipo" required>
                <option value="<?php echo "$documento_tipo"; ?>"><?php echo ucfirst($documento_tipo) ?></option>
                <option value=""></option>
                <option value="CC">CC</option>
                <option value="cedula extranjeria">Cédula de extranjería</option>
                <option value="NIT">NIT</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="RUT">RUT</option>
                <option value="TI">TI</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Tipo de documento, CC, NIT, TI, etc.</p>

            <p class="rdm-formularios--label"><label for="documento_numero">Documento*</label></p>
            <p><input type="number" id="documento_numero" name="documento_numero" value="<?php echo "$documento_numero"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Documento de identificación del usuario</p>

            <p class="rdm-formularios--label"><label for="tipo">Tipo</label></p>
            <p><input type="text" id="tipo" name="tipo" value="<?php echo "$tipo"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Tipo de productor, salsas, masas, coberturas, etc.</p>            
            
            <p class="rdm-formularios--label"><label for="correo">Correo electrónico</label></p>
            <p><input type="email" id="correo" name="correo" value="<?php echo "$correo"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Correo electrónico de contacto</p>
            
            <p class="rdm-formularios--label"><label for="contacto">Contacto</label></p>
            <p><input type="text" id="contacto" name="contacto" value="<?php echo "$contacto"; ?>" /></p>
            <p class="rdm-formularios--ayuda">Nombre de la persona encargada de producción</p>

            <p class="rdm-formularios--label"><label for="telefono">Teléfono</label></p>
            <p><input type="number" id="telefono" name="telefono" value="<?php echo "$telefono"; ?>" /></p>
            <p class="rdm-formularios--ayuda">Teléfono del productor</p>

            <p class="rdm-formularios--label"><label for="direccion">Dirección</label></p>
            <p><input type="text" id="direccion" name="direccion" value="<?php echo "$direccion"; ?>" spellcheck="false"  /></p>
            <p class="rdm-formularios--ayuda">Dirección del productor</p>

            <p class="rdm-formularios--label"><label for="cuenta_bancaria">Cuenta bancaria</label></p>
            <p><input type="text" id="cuenta_bancaria" name="cuenta_bancaria" value="<?php echo "$cuenta_bancaria"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Número, tipo y banco</p>

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