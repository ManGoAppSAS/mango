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
if(isset($_POST['ingrediente_producido_id'])) $ingrediente_producido_id = $_POST['ingrediente_producido_id']; elseif(isset($_GET['ingrediente_producido_id'])) $ingrediente_producido_id = $_GET['ingrediente_producido_id']; else $ingrediente_producido_id = null;
?>

<?php
//consulto la información del ingrediente
$consulta = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = '$ingrediente_producido_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $ingrediente_producido_id = $fila['ingrediente_id'];
    
    $ingrediente = $fila['ingrediente'];
    $unidad_minima = $fila['unidad_minima'];
    $unidad_compra = $fila['unidad_compra'];
    $costo_unidad_minima = $fila['costo_unidad_minima'];
    $costo_unidad_compra = $fila['costo_unidad_compra'];
    $cantidad_unidad_compra = $fila['cantidad_unidad_compra'];

    $productor_id = $fila['productor_id'];

    //consulto el productor
    $consulta_productor = $conexion->query("SELECT * FROM productor WHERE productor_id = '$productor_id'");           

    if ($fila = $consulta_productor->fetch_assoc()) 
    {
        $productor_id_g = $fila['productor_id'];
        $productor_g = ucfirst($fila['productor']);
        $productor_g = "<option value='$productor_id_g'>$productor_g</option>";
    }
    else
    {
        $productor_id_g = 0;
        $productor_g = "<option value=''>No se ha asignado un productor</option>";
    }
}
else
{
    header("location:ingredientes_producidos_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingrediente producido - ManGo!</title>
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
            <a href="ingredientes_producidos_detalle.php?ingrediente_producido_id=<?php echo "$ingrediente_producido_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Ingrediente producido</h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <div class="rdm-toolbar--icono-derecha">
                <a href="" data-toggle="modal" data-target="#dialogo" data-dato1="<?php echo ucfirst($ingrediente_producido_id) ?>" data-dato2="<?php echo "$ingrediente"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
            </div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="ingredientes_producidos_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">

            <input type="hidden" name="ingrediente_producido_id" value="<?php echo "$ingrediente_producido_id"; ?>" />

            <?php
            //consulto y muestro los productores
            $consulta = $conexion->query("SELECT * FROM productor WHERE estado = 'activo' ORDER BY productor");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="productor_id" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $productor_id = $fila['productor_id'];
                        $productor = $fila['productor'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($productor_id) ?>" name="productor_id" value="<?php echo ($productor_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="productor_id">Productor*</label></p>
                    <p><select id="productor_id" name="productor_id" required autofocus>

                    <?php
                    //si hay mas de un registro los muestro todos menos el productor que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM productor WHERE productor_id != $productor_id and estado = 'activo' ORDER BY productor");

                    ?>
                        
                    <?php echo "$productor_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $productor_id = $fila['productor_id'];
                        $productor = $fila['productor'];
                        ?>

                        <option value="<?php echo "$productor_id"; ?>"><?php echo ucfirst($productor) ?></option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">Productor que produce el ingrediente producido/p>
                    
                    <?php
                }
            }
            ?>
            
            <p class="rdm-formularios--label"><label for="ingrediente">Nombre*</label></p>
            <p><input type="text" id="ingrediente" name="ingrediente" value="<?php echo "$ingrediente"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del ingrediente producido</p>

            <p class="rdm-formularios--label"><label for="cantidad_unidad_compra">Cantidad mínima de producción*</label></p>
            <p><input type="number" id="cantidad_unidad_compra" name="cantidad_unidad_compra" value="<?php echo "$cantidad_unidad_compra"; ?>" step="any" required /></p>
            <p class="rdm-formularios--ayuda">Cantidad mínima que se produce</p>
            
            <p class="rdm-formularios--label"><label for="unidad_compra">Unidad de produccion*</label></p>
            <p><select id="unidad_compra" name="unidad_compra" required>
                <option value="<?php echo "$unidad_compra"; ?>"><?php echo ucfirst($unidad_compra) ?></option>
                <option value="">---------</option>
                <option value="g">Gramo (G)</option>
                <option value="ml">Mililitro (Ml)</option>
                <option value="mm">Milimetro (Mm)</option>
                <option value="">---------</option>
                <option value="kg">Kilogramo (Kg)</option>
                <option value="l">Litro (L)</option>
                <option value="m">Metro (M)</option>
                <option value="">---------</option>
                <option value="unid">Unid</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Unidad de producción del ingrediente</p>
            
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
                    Eliminar ingrediente producido
                </h1>
            </div>

            <form action="ingredientes_producidos_ver.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea eliminar <b><span class="modal-texto-dato2"></span></b>?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" class="modal-input1" name="ingrediente_producido_id" value="">
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