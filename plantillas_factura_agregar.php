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
if(isset($_POST['titulo'])) $titulo = $_POST['titulo']; elseif(isset($_GET['titulo'])) $titulo = $_GET['titulo']; else $titulo = null;
if(isset($_POST['prefijo'])) $prefijo = $_POST['prefijo']; elseif(isset($_GET['prefijo'])) $prefijo = $_GET['prefijo']; else $prefijo = null;
if(isset($_POST['numero_inicio'])) $numero_inicio = $_POST['numero_inicio']; elseif(isset($_GET['numero_inicio'])) $numero_inicio = $_GET['numero_inicio']; else $numero_inicio = 1;
if(isset($_POST['numero_fin'])) $numero_fin = $_POST['numero_fin']; elseif(isset($_GET['numero_fin'])) $numero_fin = $_GET['numero_fin']; else $numero_fin = null;
if(isset($_POST['sufijo'])) $sufijo = $_POST['sufijo']; elseif(isset($_GET['sufijo'])) $sufijo = $_GET['sufijo']; else $sufijo = null;
if(isset($_POST['encabezado'])) $encabezado = $_POST['encabezado']; elseif(isset($_GET['encabezado'])) $encabezado = $_GET['encabezado']; else $encabezado = null;
if(isset($_POST['mostrar_atendido'])) $mostrar_atendido = $_POST['mostrar_atendido']; elseif(isset($_GET['mostrar_atendido'])) $mostrar_atendido = $_GET['mostrar_atendido']; else $mostrar_atendido = "no";
if(isset($_POST['mostrar_impuesto'])) $mostrar_impuesto = $_POST['mostrar_impuesto']; elseif(isset($_GET['mostrar_impuesto'])) $mostrar_impuesto = $_GET['mostrar_impuesto']; else $mostrar_impuesto = "no";
if(isset($_POST['pie'])) $pie = $_POST['pie']; elseif(isset($_GET['pie'])) $pie = $_GET['pie']; else $pie = null;
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
//agregar la plantilla de factura
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

    $consulta = $conexion->query("SELECT local_id FROM plantilla_factura WHERE local_id = '$local_id' and estado = 'activo'");

    if ($consulta->num_rows == 0)
    {
        $imagen_ref = "plantillas_factura";
        $insercion = $conexion->query("INSERT INTO plantilla_factura values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$titulo', '$prefijo', '$numero_inicio', '$numero_fin', '$sufijo', '$encabezado', '$mostrar_atendido', '$mostrar_impuesto', '$pie', '$imagen', '$ahora_img', '$local_id')");        

        $mensaje = "Plantilla de factura <b>" . ucfirst($titulo) . "</b> agregada";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";

        $id = $conexion->insert_id;

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $mensaje = "La plantilla de factura <b>" . ucfirst($titulo) . "</b> ya existe, no es posible agregarla de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Plantillas de factura - ManGo!</title>    
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
            <a href="plantillas_factura_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Plantillas de factura</h2>
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
                    <p class="rdm-formularios--ayuda">Local al que se relaciona la plantilla de factura</p>
                    
                    <?php
                }
            }
            ?>            

            <p class="rdm-formularios--label"><label for="archivo">Logo</label></p>
            <p><input type="file" id="archivo" name="archivo" /></p>
            <p class="rdm-formularios--ayuda">Logo de la factura</p>
            
            <p class="rdm-formularios--label"><label for="titulo">Titulo*</label></p>
            <p><input type="text" id="titulo" name="titulo" value="<?php echo "$titulo"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Ej: Factura de venta, Recibo, Cuenta de cobro, etc.</p>

            <p class="rdm-formularios--label"><label for="prefijo">Prefijo de facturación (ABC...)</label></p>
            <p><input type="text" id="prefijo" name="prefijo" value="<?php echo "$prefijo"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Prefijo que va antes del número de facturación</p>

            <p class="rdm-formularios--label"><label for="fecha_inicio">Numeración*</label></p>
            <div class="rdm-formularios--fecha">
                <p><input type="number" id="numero_inicio" name="numero_inicio" value="<?php echo "$numero_inicio"; ?>" required></p>
                <p class="rdm-formularios--ayuda">Inicio</p>
            </div>
            <div class="rdm-formularios--fecha">
                <p><input type="number" id="numero_fin" name="numero_fin" value="<?php echo "$numero_fin"; ?>" ></p>
                <p class="rdm-formularios--ayuda">Fin</p>
            </div>

            <p class="rdm-formularios--label" style="margin-top: 0"><label for="sufijo">Sufijo de facturación (...ABC)</label></p>
            <p><input type="text" id="sufijo" name="sufijo" value="<?php echo "$sufijo"; ?>" spellcheck="false"  /></p>
            <p class="rdm-formularios--ayuda">Sufijo que va después del número de facturación</p>

            <p class="rdm-formularios--label"><label for="encabezado">Encabezado*</label></p>
            <p><textarea rows="8" id="encabezado" name="encabezado"><?php echo "$encabezado"; ?></textarea></p>
            <p class="rdm-formularios--ayuda">Ej: Resolución de faturación No xxx, Razón social, etc.</p>            

            <?php
            //atributo checked
            if ($mostrar_atendido == "si")
            {
                $mostrar_atendido_checked = "checked";
            }
            else
            {
                $mostrar_atendido_checked = "";
            }
            ?>
    
            <p class="rdm-formularios--label"><label for="mostrar_local">Atendido por*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="mostrar_atendido" name="mostrar_atendido" class="rdm-formularios--switch" value="si" <?php echo "$mostrar_atendido_checked"; ?>>
                <label for="mostrar_atendido" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">Mostrar atendido por</p>

            <?php
            //atributo checked
            if ($mostrar_impuesto == "si")
            {
                $mostrar_impuesto_checked = "checked";
            }
            else
            {
                $mostrar_impuesto_checked = "";
            }
            ?>
            
            <p class="rdm-formularios--label"><label for="mostrar_local">Impuestos*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="mostrar_impuesto" name="mostrar_impuesto" class="rdm-formularios--switch" value="si" <?php echo "$mostrar_impuesto_checked"; ?>>
                <label for="mostrar_impuesto" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">Mostrar impuestos en cada producto/servicio</p>

            <p class="rdm-formularios--label"><label for="pie">Pié de página*</label></p>
            <p><textarea rows="8" id="pie" name="pie"><?php echo "$pie"; ?></textarea></p>
            <p class="rdm-formularios--ayuda">Ej: Gracias por su compra, vuelva pronto, propina voluntaria, etc.</p>            
            
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