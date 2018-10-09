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
//capturo las variables que pasan por URL o formulario
if(isset($_POST['descuento_id'])) $descuento_id = $_POST['descuento_id']; elseif(isset($_GET['descuento_id'])) $descuento_id = $_GET['descuento_id']; else $descuento_id = null;
?>

<?php
//consulto la información del descuento
$consulta = $conexion->query("SELECT * FROM descuento WHERE descuento_id = '$descuento_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $descuento_id = $fila['descuento_id'];
    
    $descuento = $fila['descuento'];
    $porcentaje = $fila['porcentaje'];
    $aplica = $fila['aplica'];
}
else
{
    header("location:descuentos_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Descuento - ManGo!</title>
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>
</head>
<body>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="descuentos_detalle.php?descuento_id=<?php echo "$descuento_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Descuento</h2>
        </div>
        <div class="rdm-toolbar--derecha" id="abrir_modal">
            <div class="rdm-toolbar--icono-derecha"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="descuentos_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">

            <input type="hidden" name="descuento_id" value="<?php echo "$descuento_id"; ?>" />
            
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
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

    </section>

    </form>

    <div id="dialogo" class="rdm-tarjeta--modal">     
        <div class="rdm-tarjeta--modal-contenido">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">¿Eliminar descuento?</h1>
            </div>
            <div class="rdm-tarjeta--cuerpo">
                ¿Deseas eliminar <b><?php echo ($descuento); ?></b>?
            </div>
            <br>
            <div class="rdm-tarjeta--acciones-derecha">
                <button class="rdm-boton--plano" id="cerrar_modal">Cancelar</button>
                <a href="descuentos_ver.php?eliminar=si&descuento_id=<?php echo "$descuento_id"; ?>"><button class="rdm-boton--resaltado">Eliminar</button></a>
            </div>
        </div>
    </div>

<footer></footer>

<script type="text/javascript">
    var modal = document.getElementById('dialogo');
    var btn = document.getElementById("abrir_modal");
    var span = document.getElementById("cerrar_modal");
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>