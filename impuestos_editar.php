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
if(isset($_POST['impuesto_id'])) $impuesto_id = $_POST['impuesto_id']; elseif(isset($_GET['impuesto_id'])) $impuesto_id = $_GET['impuesto_id']; else $impuesto_id = null;
?>

<?php
//consulto la información del impuesto
$consulta = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id = '$impuesto_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $impuesto_id = $fila['impuesto_id'];
    
    $impuesto = $fila['impuesto'];
    $porcentaje = $fila['porcentaje'];
}
else
{
    header("location:impuestos_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Impuesto - ManGo!</title>
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
            <a href="impuestos_detalle.php?impuesto_id=<?php echo "$impuesto_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Impuesto</h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <div class="rdm-toolbar--icono-derecha">
                <a href="" data-toggle="modal" data-target="#dialogo" data-dato1="<?php echo ucfirst($impuesto_id) ?>" data-dato2="<?php echo "$impuesto"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
            </div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="impuestos_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">

            <input type="hidden" name="impuesto_id" value="<?php echo "$impuesto_id"; ?>" />
            
            <p class="rdm-formularios--label"><label for="impuesto">Nombre*</label></p>
            <p><input type="text" id="impuesto" name="impuesto" value="<?php echo "$impuesto"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del impuesto</p>

            <p class="rdm-formularios--label"><label for="porcentaje">Porcentaje*</label></p>
            <p><input type="number" min="0" max="100" id="porcentaje" name="porcentaje" value="<?php echo "$porcentaje"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Valor del porcentaje sin símbolos o guiones</p>
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

        </section>

    </form>

<footer></footer>

<!--dialogo para eliminar-->

<div class="modal" id="dialogo" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Eliminar impuesto
                </h1>
            </div>

            <form action="impuestos_ver.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea eliminar <b><span class="modal-texto-dato2"></span></b>?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" class="modal-input1" name="impuesto_id" value="">
                </div>            

                <div class="rdm-tarjeta--acciones-derecha">
                    <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="rdm-boton--plano-resaltado" name="eliminar" value="si">Eliminar</button>                    
                </div>

            </form>
          
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