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
        <div class="rdm-toolbar--derecha">
            <div class="rdm-toolbar--icono-derecha">
                <a href="" data-toggle="modal" data-target="#dialogo" data-dato1="<?php echo ucfirst($metodo_pago_id) ?>" data-dato2="<?php echo "$metodo"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
            </div>
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

<footer></footer>

<!--dialogo para eliminar-->

<div class="modal" id="dialogo" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Eliminar método de pago
                </h1>
            </div>

            <form action="metodos_pago_ver.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea eliminar <b><span class="modal-texto-dato2"></span></b>?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" class="modal-input1" name="metodo_pago_id" value="">
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