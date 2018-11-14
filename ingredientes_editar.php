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
if(isset($_POST['ingrediente_id'])) $ingrediente_id = $_POST['ingrediente_id']; elseif(isset($_GET['ingrediente_id'])) $ingrediente_id = $_GET['ingrediente_id']; else $ingrediente_id = null;
?>

<?php
//consulto la información del ingrediente
$consulta = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = '$ingrediente_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $ingrediente_id = $fila['ingrediente_id'];
    
    $ingrediente = $fila['ingrediente'];
    $unidad_minima = $fila['unidad_minima'];
    $unidad_compra = $fila['unidad_compra'];
    $costo_unidad_minima = $fila['costo_unidad_minima'];
    $costo_unidad_compra = $fila['costo_unidad_compra'];

    $proveedor_id = $fila['proveedor_id'];

    //consulto el proveedor
    $consulta_proveedor = $conexion->query("SELECT * FROM proveedor WHERE proveedor_id = '$proveedor_id'");           

    if ($fila = $consulta_proveedor->fetch_assoc()) 
    {
        $proveedor_g = ucfirst($fila['proveedor']);
        $proveedor_g = "<option value='$proveedor_id'>$proveedor_g</option>";
    }
    else
    {
        $proveedor_g = "<option value=''></option>";
    }
}
else
{
    header("location:ingredientes_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingrediente - ManGo!</title>
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
            <a href="ingredientes_detalle.php?ingrediente_id=<?php echo "$ingrediente_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Ingrediente</h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <div class="rdm-toolbar--icono-derecha">
                <a href="" data-toggle="modal" data-target="#dialogo" data-dato1="<?php echo ucfirst($ingrediente_id) ?>" data-dato2="<?php echo "$ingrediente"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
            </div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="ingredientes_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">

            <input type="hidden" name="ingrediente_id" value="<?php echo "$ingrediente_id"; ?>" />
            
            <?php
            //consulto y muestro los proveedores
            $consulta = $conexion->query("SELECT * FROM proveedor WHERE estado = 'activo' ORDER BY proveedor");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="proveedor_id" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $proveedor_id = $fila['proveedor_id'];
                        $proveedor = $fila['proveedor'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($proveedor_id) ?>" name="proveedor_id" value="<?php echo ($proveedor_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="proveedor_id">Proveedor*</label></p>
                    <p><select id="proveedor_id" name="proveedor_id" required autofocus>

                    <?php
                    //si hay mas de un registro los muestro todos menos el proveedor que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM proveedor WHERE proveedor_id != $proveedor_id and estado = 'activo' ORDER BY proveedor");

                    ?>
                        
                    <?php echo "$proveedor_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $proveedor_id = $fila['proveedor_id'];
                        $proveedor = $fila['proveedor'];
                        ?>

                        <option value="<?php echo "$proveedor_id"; ?>"><?php echo ucfirst($proveedor) ?></option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">Proveedor que vende el ingrediente</p>
                    
                    <?php
                }
            }
            ?>

            <p class="rdm-formularios--label"><label for="ingrediente">Nombre*</label></p>
            <p><input type="text" id="ingrediente" name="ingrediente" value="<?php echo "$ingrediente"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del ingrediente</p>
            
            <p class="rdm-formularios--label"><label for="unidad_compra">Unidad de compra*</label></p>
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
                <option value="arroba 12.5 kg">arroba 12.5 Kg</option>
                <option value="bulto 25 kg">bulto 25 Kg</option>
                <option value="bulto 50 kg">bulto 50 Kg</option>
                <option value="">---------</option>
                <option value="botella 375 ml">botella 375 Ml</option>
                <option value="botella 750 ml">botella 750 Ml</option>
                <option value="botella 1500 ml">botella 1500 Ml</option>
                <option value="garrafa 2000 ml">garrafa 2000 Ml</option>
                <option value="">---------</option>
                <option value="galon 3.7 l">galon 3.7 L</option>
                <option value="botella 3 l">botella 3 L</option>
                <option value="botella 5 l">botella 5 L</option>
                <option value="botellon 18 l">botellon 18 L</option>
                <option value="botellon 20 l">botellon 20 L</option>
                <option value="">---------</option>
                <option value="unid">Unid</option>
                <option value="par">Par</option>
                <option value="trio">Trio</option>
                <option value="decena">Decena</option>
                <option value="docena">Docena</option>
                <option value="quincena">Quincena</option>
                <option value="treintena">Treintena</option>
                <option value="centena">Centena</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Unidad de compra del ingrediente</p>

            <p class="rdm-formularios--label"><label for="costo_unidad_compra">Costo unidad de compra*</label></p>
            <p><input type="number" id="costo_unidad_compra" name="costo_unidad_compra" value="<?php echo "$costo_unidad_compra"; ?>" step="any" required /></p>
            <p class="rdm-formularios--ayuda">Costo de la unidad de compra</p>  
            
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
                    Eliminar ingrediente
                </h1>
            </div>

            <form action="ingredientes_ver.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea eliminar <b><span class="modal-texto-dato2"></span></b>?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" class="modal-input1" name="ingrediente_id" value="">
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