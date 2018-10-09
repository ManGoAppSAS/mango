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
if(isset($_POST['zona_entrega_id'])) $zona_entrega_id = $_POST['zona_entrega_id']; elseif(isset($_GET['zona_entrega_id'])) $zona_entrega_id = $_GET['zona_entrega_id']; else $zona_entrega_id = null;
?>

<?php
//consulto la información de la zona de entrega
$consulta = $conexion->query("SELECT * FROM zona_entrega WHERE zona_entrega_id = '$zona_entrega_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $zona_entrega_id = $fila['zona_entrega_id'];
    
    $zona_entrega = $fila['zona_entrega'];
}
else
{
    header("location:zonas_entrega_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Zona de entrega - ManGo!</title>
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
            <a href="zonas_entrega_detalle.php?zona_entrega_id=<?php echo "$zona_entrega_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Zona de entrega</h2>
        </div>
        <div class="rdm-toolbar--derecha" id="abrir_modal">
            <div class="rdm-toolbar--icono-derecha"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="zonas_entrega_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">

            <input type="hidden" name="zona_entrega_id" value="<?php echo "$zona_entrega_id"; ?>" />
            
            <p class="rdm-formularios--label"><label for="zona_entrega">Nombre*</label></p>
            <p><input type="text" id="zona_entrega" name="zona_entrega" value="<?php echo "$zona_entrega"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Ej: cocina, bar, asadero, bodega, etc.</p>            
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

    </section>

    </form>

    <div id="dialogo" class="rdm-tarjeta--modal">     
        <div class="rdm-tarjeta--modal-contenido">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">¿Eliminar zona de entrega?</h1>
            </div>
            <div class="rdm-tarjeta--cuerpo">
                ¿Deseas eliminar <b><?php echo ($zona_entrega); ?></b>?
            </div>
            <br>
            <div class="rdm-tarjeta--acciones-derecha">
                <button class="rdm-boton--plano" id="cerrar_modal">Cancelar</button>
                <a href="zonas_entrega_ver.php?eliminar=si&zona_entrega_id=<?php echo "$zona_entrega_id"; ?>"><button class="rdm-boton--resaltado">Eliminar</button></a>
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