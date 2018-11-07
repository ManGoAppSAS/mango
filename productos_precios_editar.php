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
if(isset($_POST['producto_id'])) $producto_id = $_POST['producto_id']; elseif(isset($_GET['producto_id'])) $producto_id = $_GET['producto_id']; else $producto_id = null;
if(isset($_POST['producto_precio_id'])) $producto_precio_id = $_POST['producto_precio_id']; elseif(isset($_GET['producto_precio_id'])) $producto_precio_id = $_GET['producto_precio_id']; else $producto_precio_id = null;
?>

<?php
//consulto la información del producto
$consulta = $conexion->query("SELECT * FROM producto WHERE producto_id = '$producto_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $producto_id = $fila['producto_id'];
    
    $producto = $fila['producto'];
    $tipo = $fila['tipo'];
    $descripcion = $fila['descripcion'];
    $codigo_barras = $fila['codigo_barras'];

    $categoria_id = $fila['categoria_id'];

    //consulto la categoria
    $consulta_categoria = $conexion->query("SELECT * FROM categoria WHERE categoria_id = '$categoria_id'");           

    if ($fila = $consulta_categoria->fetch_assoc()) 
    {
        $categoria_id_g = $fila['categoria_id'];
        $categoria_g = ucfirst($fila['categoria']);
        $categoria_g = "<option value='$categoria_id_g'>$categoria_g</option>";
    }
    else
    {
        $categoria_id_g = 0;
        $categoria_g = "<option value=''>No se ha asignado una categoría</option>";
    }

    

    //consulto el precio principal
    $consulta_precio_pal = $conexion->query("SELECT * FROM producto_precio WHERE producto_id = '$producto_id' and producto_precio_id = '$producto_precio_id'");           

    if ($fila = $consulta_precio_pal->fetch_assoc()) 
    {
        $nombre = $fila['nombre'];
        $tipo = $fila['tipo'];
        $precio = $fila['precio'];
        $impuesto_incluido = $fila['impuesto_incluido'];
        $impuesto_id = $fila['impuesto_id'];

        if ($tipo == "principal")
        {
           $precio_principal = "si";
        }
        else
        {
           $precio_principal = "no";
        }
        

        //consulto el impuesto
        $consulta_impuesto = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id = '$impuesto_id'");           

        if ($fila_impuesto = $consulta_impuesto->fetch_assoc()) 
        {
            $impuesto_id_g = $fila_impuesto['impuesto_id'];
            $impuesto_g = ucfirst($fila_impuesto['impuesto']);
            $impuesto_porcentaje_g = ($fila_impuesto['porcentaje']);
            $impuesto_g = "<option value='$impuesto_id_g'>$impuesto_g $impuesto_porcentaje_g%</option>";
        }
        else
        {
            $impuesto_id_g = 0;
            $impuesto_g = "<option value=''>No se ha asignado un impuesto</option>";
        }
    }
    else
    {
        $precio = 0;
        $impuesto_incluido = "no";
        $impuesto_id = 0;
        $impuesto = 0;
        $impuesto_porcentaje = 0;
    }

   
}
else
{
    header("location:productos_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Precio - ManGo!</title>
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>

    <script type="text/javascript">
        $(document).ready(function () {
                 
        }); 

        jQuery(function($) {
            $('#precio').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'}); 
            
        });
    </script>
</head>
<body>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="productos_precios_detalle.php?producto_id=<?php echo "$producto_id"; ?>&producto_precio_id=<?php echo "$producto_precio_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Precio</h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <div class="rdm-toolbar--icono-derecha">
                <a href="" data-toggle="modal" data-target="#dialogo" data-dato1="<?php echo ucfirst($producto_precio_id) ?>" data-dato2="<?php echo "$nombre"; ?>" data-dato3="<?php echo "$producto_id"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
            </div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="productos_precios_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">

            <input type="hidden" name="producto_id" value="<?php echo "$producto_id"; ?>" />
            <input type="hidden" name="producto_precio_id" value="<?php echo "$producto_precio_id"; ?>" />
            
            <p class="rdm-formularios--label"><label for="nombre">Nombre*</label></p>
            <p><input type="text" id="nombre" name="nombre" value="<?php echo "$nombre"; ?>" required autofocus/></p>
            <p class="rdm-formularios--ayuda">Ej: Distribuidor, franquiciado, por mayor, etc.</p>

            <p class="rdm-formularios--label"><label for="precio">Precio*</label></p>
            <p><input type="tel" id="precio" name="precio" id="precio" value="<?php echo "$precio"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Precio del producto o servicio</p>

            <?php
            //consulto y muestro los impuestos
            $consulta = $conexion->query("SELECT * FROM impuesto WHERE estado = 'activo' ORDER BY impuesto");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="impuesto_id" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $impuesto_id = $fila['impuesto_id'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($impuesto_id) ?>" name="impuesto_id" value="<?php echo ($impuesto_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="impuesto_id">Impuesto*</label></p>
                    <p><select id="impuesto_id" name="impuesto_id" required >

                    <?php
                    //si hay mas de un registro los muestro todos menos el impuesto acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id != $impuesto_id and estado = 'activo' ORDER BY impuesto");

                    ?>
                        
                    <?php echo "$impuesto_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $impuesto_id = $fila['impuesto_id'];
                        $impuesto = $fila['impuesto'];
                        $porcentaje = $fila['porcentaje'];
                        ?>

                        <option value="<?php echo "$impuesto_id"; ?>"><?php echo ucfirst($impuesto) ?> <?php echo ($porcentaje); ?>%</option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">Elige el impuesto que aplica</p>
                    
                    <?php
                }
            }
            ?>

            <?php
            //impuesto incluido checked
            if ($impuesto_incluido == "si")
            {
                $impuesto_incluido_checked = "checked";
            }
            else
            {
                $impuesto_incluido_checked = "";
            }
            ?>
            
            <p class="rdm-formularios--label"><label for="impuesto_incluido">Impuesto incluido*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="impuesto_incluido" name="impuesto_incluido" class="rdm-formularios--switch" value="si" <?php echo "$impuesto_incluido_checked"; ?>>
                <label for="impuesto_incluido" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">¿El impuesto está incluido en el precio?</p>





            <?php
            //establecer como principal checked
            if ($precio_principal == "si")
            {
                $precio_principal_checked = "checked";
            }
            else
            {
                $precio_principal_checked = "";
            }
            ?>
            
            <p class="rdm-formularios--label"><label for="precio_principal">Precio principal*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="precio_principal" name="precio_principal" class="rdm-formularios--switch" value="si" <?php echo "$precio_principal_checked"; ?>>
                <label for="precio_principal" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">¿Establecer como precio principal?</p>
            
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
                    Eliminar precio
                </h1>
            </div>

            <form action="productos_detalle.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea eliminar <b><span class="modal-texto-dato2"></span></b>?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" class="modal-input1" name="producto_precio_id" value="">
                    <input type="hidden" class="modal-input3" name="producto_id" value="">
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
  var dato3 = button.data('dato3') 
  var modal = $(this)
  modal.find('.modal-texto-dato1').text('' + dato1 + '')
  modal.find('.modal-texto-dato2').text('' + dato2 + '')
  modal.find('.modal-input1').val(dato1)
  modal.find('.modal-input3').val(dato3)
})
</script>

</body>
</html>