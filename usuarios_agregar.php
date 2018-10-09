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
if(isset($_POST['nombres'])) $nombres = $_POST['nombres']; elseif(isset($_GET['nombres'])) $nombres = $_GET['nombres']; else $nombres = null;
if(isset($_POST['apellidos'])) $apellidos = $_POST['apellidos']; elseif(isset($_GET['apellidos'])) $apellidos = $_GET['apellidos']; else $apellidos = null;
if(isset($_POST['documento_tipo'])) $documento_tipo = $_POST['documento_tipo']; elseif(isset($_GET['documento_tipo'])) $documento_tipo = $_GET['documento_tipo']; else $documento_tipo = null;
if(isset($_POST['documento_numero'])) $documento_numero = $_POST['documento_numero']; elseif(isset($_GET['documento_numero'])) $documento_numero = $_GET['documento_numero']; else $documento_numero = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['correo'])) $correo = $_POST['correo']; elseif(isset($_GET['correo'])) $correo = $_GET['correo']; else $correo = null;
if(isset($_POST['contrasena'])) $contrasena = $_POST['contrasena']; elseif(isset($_GET['contrasena'])) $contrasena = $_GET['contrasena']; else $contrasena = null;
if(isset($_POST['telefono'])) $telefono = $_POST['telefono']; elseif(isset($_GET['telefono'])) $telefono = $_GET['telefono']; else $telefono = null;
if(isset($_POST['direccion'])) $direccion = $_POST['direccion']; elseif(isset($_GET['direccion'])) $direccion = $_GET['direccion']; else $direccion = null;
if(isset($_POST['fecha_nacimiento'])) $fecha_nacimiento = $_POST['fecha_nacimiento']; elseif(isset($_GET['fecha_nacimiento'])) $fecha_nacimiento = $_GET['fecha_nacimiento']; else $fecha_nacimiento = null;
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
}
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

    $consulta = $conexion->query("SELECT correo FROM usuario WHERE correo = '$correo'");

    if ($consulta->num_rows == 0)
    {
        $imagen_ref = "usuarios";
        $insercion = $conexion->query("INSERT INTO usuario values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$nombres', '$apellidos', '$documento_tipo', '$documento_numero', '$tipo', '$correo', '$contrasena', '$telefono', '$direccion', '$fecha_nacimiento', '$imagen', '$ahora_img', '$local_id')");        

        $mensaje = "Usuario <b>" . ($nombres) . " " . ($apellidos) . "</b> agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";

        $id = $conexion->insert_id;

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $mensaje = "El usuario <b>" . ($nombres) . " " . ($apellidos) . "</b> ya existe, no es posible agregarlo de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Usuarios - ManGo!</title>    
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
            <a href="usuarios_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Usuarios</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Agregar</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    
        <section class="rdm-formulario">
        
            <input type="hidden" name="action" value="image" />

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

            <p class="rdm-formularios--label"><label for="nombres">Nombres*</label></p>
            <p><input type="text" id="nombres" name="nombres" value="<?php echo "$nombres"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Nombres del usuario</p>
            
            <p class="rdm-formularios--label"><label for="apellidos">Apellidos*</label></p>
            <p><input type="text" id="apellidos" name="apellidos" value="<?php echo "$apellidos"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Apellidos del usuario</p>

            <p class="rdm-formularios--label"><label for="documento_tipo">Tipo de documento*</label></p>
            <p><select id="documento_tipo" name="documento_tipo" required>
                <option value="<?php echo "$documento_tipo"; ?>"><?php echo ucfirst($documento_tipo) ?></option>
                <option value=""></option>
                <option value="CC">CC</option>
                <option value="cedula extranjeria">Cédula de extranjería</option>
                <option value="NIT">NIT</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="TI">TI</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Tipo de documento, CC, NIT, TI, etc.</p>

            <p class="rdm-formularios--label"><label for="documento_numero">Documento*</label></p>
            <p><input type="number" id="documento_numero" name="documento_numero" value="<?php echo "$documento_numero"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Documento de identificación del usuario</p>

            <p class="rdm-formularios--label"><label for="tipo">Tipo*</label></p>
            <p><input type="text" id="tipo" name="tipo" value="<?php echo "$tipo"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Tipo de usuario, socio, administrador, vendedor, etc.</p>            
            
            <p class="rdm-formularios--label"><label for="correo">Correo electrónico*</label></p>
            <p><input type="email" id="correo" name="correo" value="<?php echo "$correo"; ?>" spellcheck="false" required  /></p>
            <p class="rdm-formularios--ayuda">Correo electrónico para ingresar a ManGo!</p>
            
            <p class="rdm-formularios--label"><label for="contrasena">Contraseña*</label></p>
            <p><input type="text" id="contrasena" name="contrasena" value="<?php echo "$contrasena"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Contraseña para ingresar a ManGo!</p>

            <p class="rdm-formularios--label"><label for="telefono">Teléfono</label></p>
            <p><input type="number" id="telefono" name="telefono" value="<?php echo "$telefono"; ?>"  /></p>
            <p class="rdm-formularios--ayuda">Teléfono del usuario</p>

            <p class="rdm-formularios--label"><label for="direccion">Dirección</label></p>
            <p><input type="text" id="direccion" name="direccion" value="<?php echo "$direccion"; ?>" spellcheck="false"  /></p>
            <p class="rdm-formularios--ayuda">Dirección del usuario</p>

            <p class="rdm-formularios--label"><label for="fecha_nacimiento">Fecha de nacimiento</label></p>
            <p><input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo "$fecha_nacimiento"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Fecha de nacimiento del usuario</p>

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