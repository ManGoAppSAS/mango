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
if(isset($_POST['metodo'])) $metodo = $_POST['metodo']; elseif(isset($_GET['metodo'])) $metodo = $_GET['metodo']; else $metodo = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['porcentaje_comision'])) $porcentaje_comision = $_POST['porcentaje_comision']; elseif(isset($_GET['porcentaje_comision'])) $porcentaje_comision = $_GET['porcentaje_comision']; else $porcentaje_comision = 0;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//agregar el metodo de pago
if ($agregar == 'si')
{
    $consulta = $conexion->query("SELECT * FROM metodo_pago WHERE metodo = '$metodo' and tipo = '$tipo'");

    if ($consulta->num_rows == 0)
    {
        $insercion = $conexion->query("INSERT INTO metodo_pago values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$metodo', '$tipo', '$porcentaje_comision')");        

        $mensaje = "Método de pago <b>" . ($metodo) . "</b> agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "El método de pago <b>" . ($metodo) . "</b> ya existe, no es posible agregarlo de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Métodos de pago - ManGo!</title>    
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
            <a href="metodos_pago_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Métodos de pago</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Agregar</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    
        <section class="rdm-formulario">
        
            <p class="rdm-formularios--label"><label for="tipo">Tipo*</label></p>
            <p><select id="tipo" name="tipo" required autofocus>
                <option value="<?php echo "$tipo"; ?>"><?php echo ucfirst($tipo) ?></option>
                <option value=""></option>
                <option value="bono">Bono</option>
                <option value="canje">Canje</option>
                <option value="cheque">Cheque</option>
                <option value="consignacion">Consignación</option>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Elige un tipo</p>

            <p class="rdm-formularios--label"><label for="metodo">Nombre*</label></p>
            <p><input type="text" id="metodo" name="metodo" value="<?php echo "$metodo"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Nombre del método de pago</p>            

            <p class="rdm-formularios--label"><label for="porcentaje_comision">Porcentaje de comisión</label></p>
            <p><input type="number" min="0" max="100" id="porcentaje_comision" name="porcentaje_comision" value="<?php echo "$porcentaje_comision"; ?>" step="any" /></p>
            <p class="rdm-formularios--ayuda">Valor del porcentaje de la comisión sin símbolos o guiones</p>
            
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