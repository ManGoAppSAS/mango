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
if(isset($_POST['metodo_pago_id'])) $metodo_pago_id = $_POST['metodo_pago_id']; elseif(isset($_GET['metodo_pago_id'])) $metodo_pago_id = $_GET['metodo_pago_id']; else $metodo_pago_id = null;
?>

<?php
//consulto la información del metodo de pago
$consulta = $conexion->query("SELECT * FROM metodo_pago WHERE metodo_pago_id = '$metodo_pago_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $metodo_pago_id = $fila['metodo_pago_id'];
    
    $metodo = $fila['metodo'];
    $tipo = $fila['tipo'];
    $porcentaje_comision = $fila['porcentaje_comision'];
}
else
{
    header("location:metodos_pago_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Método de pago - ManGo!</title>
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
            <a href="metodos_pago_detalle.php?metodo_pago_id=<?php echo "$metodo_pago_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Método de pago</h2>
        </div>
        <div class="rdm-toolbar--derecha" id="abrir_modal">
            <div class="rdm-toolbar--icono-derecha"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="metodos_pago_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">

            <input type="hidden" name="metodo_pago_id" value="<?php echo "$metodo_pago_id"; ?>" />            

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
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

    </section>

    </form>

    <div id="dialogo" class="rdm-tarjeta--modal">     
        <div class="rdm-tarjeta--modal-contenido">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">¿Eliminar método de pago?</h1>
            </div>
            <div class="rdm-tarjeta--cuerpo">
                ¿Deseas eliminar <b><?php echo ($metodo); ?></b>?
            </div>
            <br>
            <div class="rdm-tarjeta--acciones-derecha">
                <button class="rdm-boton--plano" id="cerrar_modal">Cancelar</button>
                <a href="metodos_pago_ver.php?eliminar=si&metodo_pago_id=<?php echo "$metodo_pago_id"; ?>"><button class="rdm-boton--resaltado">Eliminar</button></a>
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