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
//variables de la conexion, sesion y subida
include ("sis/variables_sesion.php");
include('sis/subir.php');

$carpeta_destino = (isset($_GET['dir']) ? $_GET['dir'] : 'img/avatares');
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $carpeta_destino);
?>

<?php
//variables de subida
if(isset($_POST['agregar'])) $agregar = $_POST['agregar']; elseif(isset($_GET['agregar'])) $agregar = $_GET['agregar']; else $agregar = null;
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

//variables del formulario
if(isset($_POST['producto'])) $producto = $_POST['producto']; elseif(isset($_GET['producto'])) $producto = $_GET['producto']; else $producto = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['descripcion'])) $descripcion = $_POST['descripcion']; elseif(isset($_GET['descripcion'])) $descripcion = $_GET['descripcion']; else $descripcion = null;
if(isset($_POST['codigo_barras'])) $codigo_barras = $_POST['codigo_barras']; elseif(isset($_GET['codigo_barras'])) $codigo_barras = $_GET['codigo_barras']; else $codigo_barras = null;

//variables foraneas
if(isset($_POST['categoria_id'])) $categoria_id = $_POST['categoria_id']; elseif(isset($_GET['categoria_id'])) $categoria_id = $_GET['categoria_id']; else $categoria_id = 0;
if(isset($_POST['zona_entrega_id'])) $zona_entrega_id = $_POST['zona_entrega_id']; elseif(isset($_GET['zona_entrega_id'])) $zona_entrega_id = $_GET['zona_entrega_id']; else $zona_entrega_id = 0;
if(isset($_POST['impuesto_id'])) $impuesto_id = $_POST['impuesto_id']; elseif(isset($_GET['impuesto_id'])) $impuesto_id = $_GET['impuesto_id']; else $impuesto_id = 0;

//variables del checkbox
if(isset($_POST['local_id'])) $local_id = $_POST['local_id']; elseif(isset($_GET['local_id'])) $local_id = $_GET['local_id']; else $local_id = 0;

//variables que van al precio
if(isset($_POST['precio'])) $precio = $_POST['precio']; elseif(isset($_GET['precio'])) $precio = $_GET['precio']; else $precio = null;
if(isset($_POST['impuesto_incluido'])) $impuesto_incluido = $_POST['impuesto_incluido']; elseif(isset($_GET['impuesto_incluido'])) $impuesto_incluido = $_GET['impuesto_incluido']; else $impuesto_incluido = "no";

//variables que van al ingrediente
if(isset($_POST['crear_ingrediente'])) $crear_ingrediente = $_POST['crear_ingrediente']; elseif(isset($_GET['crear_ingrediente'])) $crear_ingrediente = $_GET['crear_ingrediente']; else $crear_ingrediente = "no";
if(isset($_POST['costo'])) $costo = $_POST['costo']; elseif(isset($_GET['costo'])) $costo = $_GET['costo']; else $costo = 0;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php 
//consulto la categoría enviada desde el select del formulario
$consulta_categoria_g = $conexion->query("SELECT * FROM categoria WHERE categoria_id = '$categoria_id'");           

if ($fila = $consulta_categoria_g->fetch_assoc()) 
{    
    $categoria_g = ucfirst($fila['categoria']);
    $categoria_tipo_g = ucfirst($fila['tipo']);
    $categoria_g = "<option value='$categoria_id'>$categoria_g</option>";
}
else
{
    $categoria_g = "<option value=''></option>";
    $categoria_tipo_g = null;
}
?>

<?php 
//consulto la zona de entrega enviada desde el select del formulario
$consulta_zona_entrega_g = $conexion->query("SELECT * FROM zona_entrega WHERE zona_entrega_id = '$zona_entrega_id'");           

if ($fila = $consulta_zona_entrega_g->fetch_assoc()) 
{    
    $zona_entrega_g = ucfirst($fila['zona_entrega']);
    $zona_entrega_g = "<option value='$zona_entrega_id'>$zona_entrega_g</option>";
}
else
{
    $zona_entrega_g = "<option value=''></option>";
}
?>

<?php 
//consulto el impuesto enviado desde el select del formulario
$consulta_impuesto_g = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id = '$impuesto_id'");

if ($fila = $consulta_impuesto_g->fetch_assoc()) 
{    
    $impuesto_g = ucfirst($fila['impuesto']);
    $porcentaje_g = ucfirst($fila['porcentaje']);
    $impuesto_g = "<option value='$impuesto_id'>$impuesto_g $porcentaje_g%</option>";
}
else
{
    $impuesto_g = "<option value=''></option>";
    $porcentaje_g = null;
}
?>

<?php
//agregar el producto
if ($agregar == 'si')
{
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
    }
    else
    {
        $imagen = "no";
    }

    $precio = str_replace('.','',$precio);    

    $consulta = $conexion->query("SELECT * FROM producto WHERE producto = '$producto' and categoria_id = '$categoria_id'");

    if ($consulta->num_rows == 0)
    {
        $imagen_ref = "productos";

        $insercion = $conexion->query("INSERT INTO producto values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$producto', '$tipo', '$descripcion', '$codigo_barras', '$imagen', '$ahora_img', '$categoria_id', '$zona_entrega_id')");

        $mensaje = "Producto <b>" . ($producto) . "</b> agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";

        $id = $conexion->insert_id;
        $producto_id = $id;
        $agregar_producto_local = "si";

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');

        //ingreso el precio principal
        $consulta_precio = $conexion->query("SELECT * FROM producto_precio WHERE  producto_id = '$producto_id' and tipo = 'principal'");

        if ($consulta_precio->num_rows == 0)
        {            
            $insercion_precio = $conexion->query("INSERT INTO producto_precio values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', 'precio normal', 'principal', '$precio', '$impuesto_incluido', '$producto_id', '$impuesto_id')");
        }

        //agregar el ingrediente
        if ($crear_ingrediente == 'si')
        {
            $costo = str_replace('.','',$costo);

            $consulta = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente = '$producto' and costo_unidad_compra = '$costo'");

            if ($consulta->num_rows == 0)
            {
                $insercion = $conexion->query("INSERT INTO ingrediente values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$producto', 'comprado', 'unid', 'unid', '$costo', '$costo', '', '0', '1', '0')");

                $ingrediente_id = $conexion->insert_id;

                //agrego la composición
                $insercion = $conexion->query("INSERT INTO producto_composicion values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '1', '$producto_id', '$ingrediente_id')");
            }
            else
            {

            }
        }

    }
    else
    {
        $mensaje = "El producto <b>" . ($producto) . "</b> ya existe, no es posible agregarlo de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<?php
//agregar el producto a los locales en que se vende
error_reporting(0);
if ($agregar_producto_local == 'si')
{    
    foreach ($local_id as $local_id)
    {        
        $consulta = $conexion->query("SELECT * FROM producto_local WHERE local_id = '$local_id' and producto_id = '$producto_id'");

        if ($consulta->num_rows == 0)
        {
            $insercion = $conexion->query("INSERT INTO producto_local VALUES ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$producto_id', '$local_id')");              
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Productos - ManGo!</title>    
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
<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="productos_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Productos</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Agregar</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    
        <section class="rdm-formulario">
        
            <input type="hidden" name="action" value="image" />

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
                    
                    //muestro el checkbox de impuesto incluido
                    $mostrar_impuesto_incluido = "si";
                }
                else
                {
                    

                    ?>

                    <p class="rdm-formularios--label"><label for="impuesto_id">Impuesto*</label></p>
                    <p><select id="impuesto_id" name="impuesto_id" required>

                    <?php
                    //si hay mas de un registro los muestro todos menos el impuesto acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id != $impuesto_id and estado = 'activo' ORDER BY impuesto");

                    //muestro el checkbox de impuesto incluido
                    $mostrar_impuesto_incluido = "si";
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

            <?php if (!empty($mostrar_impuesto_incluido)) { ?>

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

            <?php } ?>
            
            <p class="rdm-formularios--label"><label for="tipo">Tipo de inventario*</label></p>
            <p><select id="tipo" name="tipo" onchange="mostrar_costo(this)" required>
                <option value="<?php echo "$tipo"; ?>"><?php echo ucfirst($tipo) ?></option>
                <option value="compuesto">Compuesto (Lleva varios ingredientes)</option>
                <option value="simple">Simple (Lleva un solo ingrediente)</option>
            </select></p>
            <p class="rdm-formularios--ayuda">¿El producto está compuesto de uno o varios ingredientes?</p>

            <div id="costo_div" >
                <p class="rdm-formularios--label"><label for="costo">Costo</label></p>
                <p><input type="tel" id="costo" name="costo" value="<?php echo "$costo"; ?>" /></p>
                <p class="rdm-formularios--ayuda">Costo del producto</p>
            </div>

            <?php
            //impuesto incluido checked
            if ($crear_ingrediente == "si")
            {
                $crear_ingrediente_checked = "checked";
            }
            else
            {
                $crear_ingrediente_checked = "";
            }
            ?>
            
            <p class="rdm-formularios--label"><label for="mostrar_local">Crear ingrediente*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="crear_ingrediente" name="crear_ingrediente" class="rdm-formularios--switch" value="si" <?php echo "$crear_ingrediente_checked"; ?>>
                <label for="crear_ingrediente" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">Crea el ingrediente y se relaciona a la composición del producto</p>






            <?php
            //consulto y muestro los locales
            $consulta_local = $conexion->query("SELECT * FROM local WHERE estado = 'activo' ORDER BY local");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta_local->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="local_id[]" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta_local->num_rows == 1)
                {
                    while ($fila_local = $consulta_local->fetch_assoc()) 
                    {
                        $local_id = $fila_local['local_id'];
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
                    while ($fila_local = $consulta_local->fetch_assoc()) 
                    {
                        $local_id = $fila_local['local_id'];
                        $local = $fila_local['local'];

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
            
            <button type="submit" class="rdm-boton--fab" name="agregar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>        
            
        </section>

    </form>
    
</main>

<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>

<footer></footer>

</body> 
</html>