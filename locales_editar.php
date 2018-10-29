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
if(isset($_POST['local_id'])) $local_id = $_POST['local_id']; elseif(isset($_GET['local_id'])) $local_id = $_GET['local_id']; else $local_id = null;
?>

<?php
//consulto la información del local
$consulta = $conexion->query("SELECT * FROM local WHERE local_id = '$local_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $local_id = $fila['local_id'];
    $local = $fila['local'];
    $direccion = $fila['direccion'];
    $telefono = $fila['telefono'];
    $apertura = $fila['apertura'];
    $cierre = $fila['cierre'];
    $propina = $fila['propina'];
    $imagen = $fila['imagen'];
    $imagen_nombre = $fila['imagen_nombre'];
}
else
{
    header("location:locales_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Local - ManGo!</title>
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
            <a href="locales_detalle.php?local_id=<?php echo "$local_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Local</h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <div class="rdm-toolbar--icono-derecha">
                <a href="" data-toggle="modal" data-target="#dialogo" data-dato1="<?php echo ucfirst($local_id) ?>" data-dato2="<?php echo "$local"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
            </div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="locales_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">
    
            <input type="hidden" name="action" value="image" />
            <input type="hidden" name="local_id" value="<?php echo "$local_id"; ?>" />
            <input type="hidden" name="imagen" value="<?php echo "$imagen"; ?>" />
            <input type="hidden" name="imagen_nombre" value="<?php echo "$imagen_nombre"; ?>" />

            <p class="rdm-formularios--label"><label for="local">Nombre*</label></p>
            <p><input type="text" id="local" name="local" value="<?php echo "$local"; ?>" spellcheck="false" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del local o punto de venta</p>           
            
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

            <p class="rdm-formularios--label"><label for="propina">Propina*</label></p>
            <p><input type="number" id="propina" name="propina" value="<?php echo "$propina"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Porcentaje de la propina sin símbolos o guiones</p>            

            <p class="rdm-formularios--label"><label for="archivo">Imagen</label></p>
            <p><input type="file" id="archivo" name="archivo" /></p>
            <p class="rdm-formularios--ayuda">Usa una imagen para identificarlo</p>            

            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

        </section>
    
    </form>

    

<footer></footer>

<div class="modal" id="dialogo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        
        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">
                Eliminar local
            </h1>
        </div>

        <div class="rdm-tarjeta--cuerpo">            
            ¿Desea eliminar <b><span class="modal-texto-dato2"></span></b>?
        </div>            

        <div class="rdm-tarjeta--acciones-derecha">
            <form action="locales_ver.php" method="post" enctype="multipart/form-data">
                <input type="hidden" class="modal-input1" name="local_id" value="">

                <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="rdm-boton--plano-resaltado" name="eliminar" value="si">Eliminar</button>                  
            </form>
        </div>
      
    </div>
    </div>
</div>

<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

<script>
$('#dialogo').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var dato1 = button.data('dato1') 
  var dato2 = button.data('dato2') 
  var modal = $(this)
  modal.find('.modal-texto-dato1').text('' + dato1 + '')
  modal.find('.modal-texto-dato2').text('' + dato2 + '')
  modal.find('.modal-input1').val(dato1)
})
</script>

</body>
</html>