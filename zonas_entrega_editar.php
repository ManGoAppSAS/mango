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
        <div class="rdm-toolbar--derecha">
            <div class="rdm-toolbar--icono-derecha">
                <a href="" data-toggle="modal" data-target="#dialogo" data-dato1="<?php echo ucfirst($zona_entrega_id) ?>" data-dato2="<?php echo "$zona_entrega"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
            </div>
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

<footer></footer>

<div class="modal" id="dialogo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        
        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">
                Eliminar zona de entrega
            </h1>
        </div>

        <div class="rdm-tarjeta--cuerpo">            
            ¿Desea eliminar <b><span class="modal-texto-dato2"></span></b>?
        </div>            

        <div class="rdm-tarjeta--acciones-derecha">
            <form action="zonas_entrega_ver.php" method="post" enctype="multipart/form-data">
                <input type="hidden" class="modal-input1" name="zona_entrega_id" value="">

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