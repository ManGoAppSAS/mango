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

//variables que van al ingrediente
if(isset($_POST['costo'])) $costo = $_POST['costo']; elseif(isset($_GET['costo'])) $costo = $_GET['costo']; else $costo = null;
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

    $imagen = $fila['imagen'];
    $imagen_nombre = $fila['imagen_nombre'];

    $categoria_id = $fila['categoria_id'];
    $zona_entrega_id = $fila['zona_entrega_id'];

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

    //consulto la zona de entrega
    $consulta_zona = $conexion->query("SELECT * FROM zona_entrega WHERE zona_entrega_id = '$zona_entrega_id'");           

    if ($fila = $consulta_zona->fetch_assoc()) 
    {
        $zona_entrega_id_g = $fila['zona_entrega_id'];
        $zona_entrega_g = ucfirst($fila['zona_entrega']);
        $zona_entrega_g = "<option value='$zona_entrega_id_g'>$zona_entrega_g</option>";
    }
    else
    {
        $zona_entrega_id_g = 0;
        $zona_entrega_g = "<option value=''>No se ha asignado una zona de entrega</option>";
    }

    //consulto el precio principal
    $consulta_precio_pal = $conexion->query("SELECT * FROM producto_precio WHERE producto_id = '$producto_id' and tipo = 'principal' and estado = 'activo'");           

    if ($fila = $consulta_precio_pal->fetch_assoc()) 
    {
        $precio = $fila['precio'];
        $impuesto_incluido = $fila['impuesto_incluido'];
        $impuesto_id = $fila['impuesto_id'];

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
    <title>Producto - ManGo!</title>
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

    <script type="text/javascript">
        $(document).ready(function () {
                 
        }); 

        jQuery(function($) {
            $('#costo').autoNumeric('init', {aSep: '.', aDec: ',', mDec: '0'}); 
            
        });
    </script>

    <script language="javascript" type="text/javascript">
        function mostrar_costo(selectTag){

         if(selectTag.value == 'simple'){
        document.getElementById('costo_div').style.display='block';
        
         }else{
         document.getElementById('costo_div').style.display='none';
         }
        }
    </script>
</head>
<body>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="productos_detalle.php?producto_id=<?php echo "$producto_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Producto</h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <div class="rdm-toolbar--icono-derecha">
                <a href="" data-toggle="modal" data-target="#dialogo" data-dato1="<?php echo ucfirst($producto_id) ?>" data-dato2="<?php echo "$producto"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
            </div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="productos_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">
        
            <input type="hidden" name="action" value="image" />
            <input type="hidden" name="producto_id" value="<?php echo "$producto_id"; ?>" />
            <input type="hidden" name="imagen" value="<?php echo "$imagen"; ?>" />
            <input type="hidden" name="imagen_nombre" value="<?php echo "$imagen_nombre"; ?>" />
            
            <?php
            //consulto y muestro las categorias
            $consulta = $conexion->query("SELECT * FROM categoria WHERE estado = 'activo' ORDER BY categoria");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="categoria_id" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $categoria_id = $fila['categoria_id'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($categoria_id) ?>" name="categoria_id" value="<?php echo ($categoria_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="categoria_id">Categoría*</label></p>
                    <p><select id="categoria_id" name="categoria_id" required autofocus>

                    <?php
                    //si hay mas de un registro los muestro todos menos la categoria que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM categoria WHERE categoria_id != $categoria_id and estado = 'activo' ORDER BY categoria");

                    ?>
                        
                    <?php echo "$categoria_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $categoria_id = $fila['categoria_id'];
                        $categoria = $fila['categoria'];
                        ?>

                        <option value="<?php echo "$categoria_id"; ?>"><?php echo ucfirst($categoria) ?></option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">Categoría a la que se relaciona el producto</p>
                    
                    <?php
                }
            }
            ?>

            <p class="rdm-formularios--label"><label for="producto">Nombre*</label></p>
            <p><input type="text" id="producto" name="producto" value="<?php echo "$producto"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Nombre del producto o servicio</p>







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
                    <p><select id="impuesto_id" name="impuesto_id" required autofocus>

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

                        <option value="<?php echo "$impuesto_id"; ?>"><?php echo ucfirst($impuesto) ?> <?php echo ($porcentaje) ?>%</option>

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
            
            <p class="rdm-formularios--label"><label for="mostrar_local">Impuesto incluido*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="impuesto_incluido" name="impuesto_incluido" class="rdm-formularios--switch" value="si" <?php echo "$impuesto_incluido_checked"; ?>>
                <label for="impuesto_incluido" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">¿El impuesto está incluido en el precio?</p>
            
            <p class="rdm-formularios--label"><label for="tipo">Tipo de inventario*</label></p>
            <p><select id="tipo" name="tipo" onchange="mostrar_costo(this)" required>
                <option value="<?php echo "$tipo"; ?>"><?php echo ucfirst($tipo) ?></option>
                <option value="compuesto">Compuesto (Lleva varios ingredientes)</option>
                <option value="simple">Simple (Lleva un solo ingrediente)</option>
            </select></p>
            <p class="rdm-formularios--ayuda">¿El producto está compuesto de uno o varios ingredientes?</p>

            <?php
            //consulto y muestro los locales
            $consulta = $conexion->query("SELECT * FROM local WHERE estado = 'activo' ORDER BY local");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="local_id[]" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $local_id = $fila['local_id'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($local_id) ?>" name="local_id[]" value="<?php echo ($local_id) ?>">

                    <?php                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="locales">Local en que se vende*</label></p>
                    <p class="rdm-formularios--checkbox">

                    <?php
                    //sino creo la lista de checbox
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $local_id = $fila['local_id'];
                        $local = $fila['local'];
                        $tipo = $fila['tipo'];

                        //consulto si hay un registro ingresado para marcarlo como checked
                        $consulta_local_id = $conexion->query("SELECT * FROM producto_local WHERE producto_id = $producto_id and local_id = $local_id");

                        if (!($consulta_local_id->num_rows == 0))
                        {
                            $local_id_checked = "checked";
                        }
                        else
                        {
                            $local_id_checked = "";
                        }
                        ?>

                        <input type="checkbox" id="<?php echo ($local); ?>" name="local_id[]" class="rdm-formularios--switch" value="<?php echo ($local_id); ?>" <?php echo "$local_id_checked"; ?>>

                        <label for="<?php echo ($local); ?>" class="rdm-formularios--switch-label">
                            <span class="rdm-formularios--switch-encendido"><?php echo ucfirst($local) ?></span>
                            <span class="rdm-formularios--switch-apagado"><?php echo ucfirst($local) ?></span>
                        </label>

                        <br>

                        <?php
                    }

                    ?>

                    </p>
                    <p class="rdm-formularios--ayuda">Elige una o varias opciones</p>
                    
                    <?php
                }
            }
            ?>

            <?php
            //consulto y muestro las zonas de entrega
            $consulta = $conexion->query("SELECT * FROM zona_entrega WHERE estado = 'activo' ORDER BY zona_entrega");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="zona_entrega_id" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $zona_entrega_id = $fila['zona_entrega_id'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($zona_entrega_id) ?>" name="zona_entrega_id" value="<?php echo ($zona_entrega_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="zona_entrega_id">Zona de entrega*</label></p>
                    <p><select id="zona_entrega_id" name="zona_entrega_id" required autofocus>

                    <?php
                    //si hay mas de un registro los muestro todos menos la zona de ntrega que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM zona_entrega WHERE zona_entrega_id != $zona_entrega_id and estado = 'activo' ORDER BY zona_entrega");

                    ?>
                        
                    <?php echo "$zona_entrega_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $zona_entrega_id = $fila['zona_entrega_id'];
                        $zona_entrega = $fila['zona_entrega'];
                        ?>

                        <option value="<?php echo "$zona_entrega_id"; ?>"><?php echo ucfirst($zona_entrega) ?></option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">En que zona de entrega es preparado y entregado</p>
                    
                    <?php
                }
            }
            ?>            
            
            <p class="rdm-formularios--label"><label for="descripcion">Descripción</label></p>
            <p><textarea id="descripcion" name="descripcion"><?php echo "$descripcion"; ?></textarea></p>
            <p class="rdm-formularios--ayuda">Escribe una descripción del producto o servicio</p>
            
            <p class="rdm-formularios--label"><label for="codigo_barras">Código de barras</label></p>
            <p><input type="text" id="codigo_barras" name="codigo_barras" value="<?php echo "$codigo_barras"; ?>" /></p>
            <p class="rdm-formularios--ayuda">Escribe el código de barras para buscarlo con un lector</p>
            
            <p class="rdm-formularios--label"><label for="archivo">Imagen</label></p>
            <p><input type="file" id="archivo" name="archivo" /></p>
            <p class="rdm-formularios--ayuda">Usa una imagen para identificarlo</p>
            
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
                    Eliminar producto
                </h1>
            </div>

            <form action="productos_ver.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea eliminar <b><span class="modal-texto-dato2"></span></b>?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" class="modal-input1" name="producto_id" value="">
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