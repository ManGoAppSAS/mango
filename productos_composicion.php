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
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['agregar'])) $agregar = $_POST['agregar']; elseif(isset($_GET['agregar'])) $agregar = $_GET['agregar']; else $agregar = null;

//variable para eliminar o editar
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;
if(isset($_POST['producto_composicion_id'])) $producto_composicion_id = $_POST['producto_composicion_id']; elseif(isset($_GET['producto_composicion_id'])) $producto_composicion_id = $_GET['producto_composicion_id']; else $producto_composicion_id = null;

//variable de consulta
if(isset($_POST['busqueda'])) $busqueda = $_POST['busqueda']; elseif(isset($_GET['busqueda'])) $busqueda = $_GET['busqueda']; else $busqueda = null;

//capturo las variables que pasan por URL o formulario
if(isset($_POST['producto_id'])) $producto_id = $_POST['producto_id']; elseif(isset($_GET['producto_id'])) $producto_id = $_GET['producto_id']; else $producto_id = null;
if(isset($_POST['ingrediente_id'])) $ingrediente_id = $_POST['ingrediente_id']; elseif(isset($_GET['ingrediente_id'])) $ingrediente_id = $_GET['ingrediente_id']; else $ingrediente_id = null;
if(isset($_POST['cantidad'])) $cantidad = $_POST['cantidad']; elseif(isset($_GET['cantidad'])) $cantidad = $_GET['cantidad']; else $cantidad = null;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//consulto el ingrediente
$consulta_ingrediente = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = '$ingrediente_id'");

if ($fila_ingrediente = $consulta_ingrediente->fetch_assoc())
{
    $ingrediente_id = $fila_ingrediente['ingrediente_id'];
    $ingrediente = $fila_ingrediente['ingrediente'];
}
?>

<?php
//elimino el ingrediente de la composición
if ($eliminar == "si")
{
    $borrar = $conexion->query("DELETE FROM producto_composicion WHERE producto_composicion_id = '$producto_composicion_id'");

    if ($borrar)
    {
        $mensaje = "Ingrediente retirado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
}
?>

<?php
//edito el ingrediente de la composición
if ($editar == "si")
{
    $actualizar = $conexion->query("UPDATE producto_composicion SET cantidad = '$cantidad' WHERE producto_composicion_id = '$producto_composicion_id'");

    if ($actualizar)
    {
        $mensaje = "Ingrediente editado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
}
?>

<?php
//agrego el ingrediente a la composición
if ($agregar == 'si')
{   
    if ($cantidad == 0)
    {
        $cantidad = 1;
    }

    $consulta = $conexion->query("SELECT * FROM producto_composicion WHERE producto_id = '$producto_id' and ingrediente_id = '$ingrediente_id'");

    if ($consulta->num_rows == 0)
    {
        $insercion = $conexion->query("INSERT INTO producto_composicion values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$cantidad', '$producto_id', '$ingrediente_id')");
        
        $mensaje = "Ingrediente <b>".($ingrediente)."</b> agregado a la composición</b>";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "El ingrediente <b>".($ingrediente)."</b> ya fue agregado</b>";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Composición - ManGo!</title>    
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>  

    <script>
    $(document).ready(function() {
        $("#resultadoBusqueda").html('');
    });

    var delayTimer;
    function buscar() {
        clearTimeout(delayTimer);
        delayTimer = setTimeout(function() {
            
            var textoBusqueda = $("input#busqueda").val();
         
             if (textoBusqueda != "") {
                $.post("productos_composicion_buscar.php?producto_id=<?php echo "$producto_id"; ?>&busqueda=<?php echo($busqueda) ?>", {busqueda: textoBusqueda}, function(mensaje) {
                    $("#resultadoBusqueda").html(mensaje);
                 }); 
             } else { 
                $("#resultadoBusqueda").html('');
                };
        
        }, 500); // Will do the ajax stuff after 1000 ms, or 1 s
    }
    </script>    

    <script>
        $(function () {
            var focusedElement;
            $(document).on('focus', 'input#busqueda', function () {
                if (focusedElement == this) return; //already focused, return so user can now place cursor at specific point in input.
                focusedElement = this;
                setTimeout(function () { focusedElement.select(); }, 50); //select all text in any field on focus for easy re-entry. Delay sightly to allow focus to "stick" before selecting.
            });
        });
    </script>
</head>

<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="productos_detalle.php?producto_id=<?php echo "$producto_id"; ?>#composicion"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Composición</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">    

    <input type="search" name="busqueda" id="busqueda" value="<?php echo "$busqueda"; ?>" placeholder="Buscar y agregar ingrediente" maxlength="30" autofocus autocomplete="off" onKeyUp="buscar();" onFocus="buscar(); this.select();" />

    <div id="resultadoBusqueda"></div>

    <h2 class="rdm-lista--titulo-largo">Ingredientes</h2>

    <?php
    //consulto y muestros la composición de este producto
    $consulta = $conexion->query("SELECT * FROM producto_composicion WHERE producto_id = '$producto_id' ORDER BY fecha_alta DESC");

    if ($consulta->num_rows == 0)
    {
        ?>        

        <section class="rdm-lista">
            
            <article class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--avatar"><div class="rdm-lista--icono"><i class="zmdi zmdi-info zmdi-hc-2x"></i></div></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>
                        <h2 class="rdm-lista--texto-secundario">No se han agregado ingredientes</h2>
                    </div>
                </div>
            </article>

        </section>

        <?php
        
    }
    else                 
    {
        ?>

        <section class="rdm-lista"> 

        <?php

        while ($fila = $consulta->fetch_assoc())
        {
            //datos de la composicion
            $producto_composicion_id = $fila['producto_composicion_id'];            
            $cantidad = $fila['cantidad'];
            $ingrediente_id = $fila['ingrediente_id'];

            //consulto el ingrediente
            $consulta2 = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = $ingrediente_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $ingrediente = $filas2['ingrediente'];
                $unidad_minima = $filas2['unidad_minima'];
                $costo_unidad_minima = $filas2['costo_unidad_minima'];

                //color de fondo segun la primer letra
                $avatar_id = $ingrediente_id;
                $avatar_nombre = "$ingrediente";

                include ("sis/avatar_color.php");
                
                //consulto el avatar
                $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';
            }
            else
            {
                $ingrediente = "No se ha asignado un ingrediente";
                $unidad_minima = "";
                $costo_unidad_minima = 0;
            }

            //calculo el costo del ingrediente
            $ingrediente_costo = $costo_unidad_minima * $cantidad;
            ?>

            <div class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <?php echo "$imagen"; ?>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo"><?php echo ($cantidad); ?> <?php echo ucfirst($unidad_minima); ?> de <?php echo ucfirst($ingrediente); ?></h2>
                        <h2 class="rdm-lista--texto-secundario">$<?php echo number_format($ingrediente_costo, 2, ",", "."); ?></h2>
                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <a href="" data-toggle="modal" data-target="#dialogo_editar" data-busqueda="<?php echo ucfirst($busqueda) ?>" data-ingrediente="<?php echo ucfirst($ingrediente) ?>" data-ingrediente_id="<?php echo "$ingrediente_id"; ?>" data-unidad_minima="<?php echo ucfirst($unidad_minima) ?>" data-cantidad="<?php echo ucfirst($cantidad) ?>" data-producto_composicion_id="<?php echo ucfirst($producto_composicion_id) ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-edit zmdi-hc-2x" style="color: rgba(0, 0, 0, 0.6)"></i></div></a>

                    <a href="" data-toggle="modal" data-target="#dialogo_eliminar" data-busqueda="<?php echo ucfirst($busqueda) ?>" data-producto_composicion_id="<?php echo ($producto_composicion_id) ?>" data-ingrediente="<?php echo ucfirst($ingrediente); ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-minus-circle-outline zmdi-hc-2x" style="color: rgba(0, 0, 0, 0.6)"></i></div></a>
                </div>
            </div>
           
        <?php
        }
        ?>

        </section>

    <?php        
    }
    ?>

    <h2 class="rdm-lista--titulo-largo">Detalle</h2>

    <?php
    //consulto y muestro el producto
    $consulta = $conexion->query("SELECT * FROM producto WHERE producto_id = '$producto_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $producto_id = $fila['producto_id'];            

            $producto = $fila['producto'];
            $tipo = $fila['tipo']; 

            $categoria_id = $fila['categoria_id'];

            //consulto la categoria
            $consulta_categoria = $conexion->query("SELECT * FROM categoria WHERE categoria_id = '$categoria_id'");

            if ($fila = $consulta_categoria->fetch_assoc()) 
            {
                $categoria = $fila['categoria'];
            }
            else
            {
                $categoria = "No se ha asignado una categoria";
            }

            //consulto el precio principal
            $consulta_precio_pal = $conexion->query("SELECT * FROM producto_precio WHERE producto_id = '$producto_id' and tipo = 'principal' and estado = 'activo'");           

            if ($fila = $consulta_precio_pal->fetch_assoc()) 
            {
                //precio
                $precio = $fila['precio'];
                $impuesto_incluido = $fila['impuesto_incluido'];
                $impuesto_id = $fila['impuesto_id'];

                //consulto el impuesto
                $consulta_impuesto = $conexion->query("SELECT * FROM impuesto WHERE impuesto_id = '$impuesto_id'");           

                if ($fila_impuesto = $consulta_impuesto->fetch_assoc()) 
                {
                    $impuesto = $fila_impuesto['impuesto'];
                    $impuesto_porcentaje = $fila_impuesto['porcentaje'];
                }
                else
                {
                    $impuesto = "sin impuesto";
                    $impuesto_porcentaje = 0;
                }
            }
            else
            {
                //precio
                $precio = 0;
                $impuesto_incluido = "no";

                $impuesto = "sin impuesto";
                $impuesto_porcentaje = 0;
            }





            //calculo el valor de la base y el impuesto en el precio
            if ($impuesto_incluido == "si")
            {
                //valor de la base
                $base_valor = $precio / ($impuesto_porcentaje / 100 + 1);

                //valor del impuesto
                $impuesto_valor = $precio - $base_valor;

                //precio
                $precio = $base_valor + $impuesto_valor;
            }
            else
            {
                //valor de la base
                $base_valor = $precio;

                //valor del impuesto
                $impuesto_valor = ($precio * $impuesto_porcentaje) / 100;

                //precio
                $precio = $base_valor + $impuesto_valor;
            }





            //consulto el costo
            $consulta_costo = $conexion->query("SELECT * FROM producto_composicion WHERE producto_id = '$producto_id' ORDER BY fecha_alta DESC");

            if ($consulta_costo->num_rows != 0)
            {
                $composicion_costo = 0;

                while ($fila = $consulta_costo->fetch_assoc())
                {
                    

                    //datos de la composicion
                    $producto_composicion_id = $fila['producto_composicion_id'];
                    $cantidad = $fila['cantidad'];
                    $ingrediente_id = $fila['ingrediente_id'];

                    //consulto el ingrediente
                    $consulta2 = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = $ingrediente_id");

                    if ($filas2 = $consulta2->fetch_assoc())
                    {            
                        $unidad_minima = $filas2['unidad_minima'];
                        $costo_unidad_minima = $filas2['costo_unidad_minima'];            
                    }
                    else
                    {            
                        $unidad_minima = "unid";
                        $costo_unidad_minima = 0;
                    }

                    //costo del ingrediente
                    $ingrediente_costo = $costo_unidad_minima * $cantidad;

                    //costo de la composicion
                    $composicion_costo = $composicion_costo + $ingrediente_costo;
                }

                //valor del costo
                $costo_valor = $composicion_costo;

                //porcentaje del costo
                $costo_porcentaje = $costo_valor / $base_valor * 100;                
            }
            else                 
            {
                //valor del costo
                $costo_valor = 0;

                //porcentaje del costo
                $costo_porcentaje = 0;
            }






            //utilidad
            $utilidad_valor = $base_valor - $costo_valor;
            $utilidad_porcentaje = $utilidad_valor / $base_valor * 100;    
            ?>            

            <section class="rdm-tarjeta">

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($producto) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo ucfirst($categoria) ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">

                    
                    <p><b>Precio</b> <br>$<?php echo number_format($precio, 2, ",", "."); ?></p>
                    
                    <p><b>Base</b> <br>$<?php echo number_format($base_valor, 2, ",", "."); ?></p>
                    
                    <p><b><?php echo ucfirst($impuesto) ?> <?php echo ($impuesto_porcentaje); ?>%</b> <br>$<?php echo number_format($impuesto_valor, 2, ",", "."); ?></p>

                    <?php if (!empty($impuesto_incluido)) { ?>
                        <p><b>Impuesto incluido</b> <br><?php echo ucfirst($impuesto_incluido); ?></p>
                    <?php } ?>

                    <?php if (!empty($tipo)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Tipo de inventario</b> <br><?php echo ucfirst($tipo) ?></p>
                    <?php } ?>

                    <?php if (!empty($precio)) { ?>
                        <p><b>Costo</b> <br><span class="rdm-lista--texto-negativo">$<?php echo number_format($costo_valor, 2, ",", "."); ?> (<?php echo number_format($costo_porcentaje, 2, ",", "."); ?>%)</span></p>
                    <?php } ?>

                    <?php if (!empty($precio)) { ?>
                        <p><b>Utilidad</b> <br><span class="rdm-lista--texto-positivo">$<?php echo number_format($utilidad_valor, 2, ",", "."); ?> (<?php echo number_format($utilidad_porcentaje, 2, ",", "."); ?>%)</span></p>
                    <?php } ?>

                </div>

            </section>
            
            <?php
        }
    }
    ?>    

</main>

<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>
    
<footer></footer>

<!--dialogo para agregar el ingrediente-->

<div class="modal" id="dialogo_agregar" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Agregar ingrediente
                </h1>
            </div>

            <form action="productos_composicion.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Cuantos <b><span class="unidad_minima"></span></b> de <b><span class="ingrediente"></span></b> desea agregar a la composición de este producto?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" name="producto_id" value="<?php echo "$producto_id"; ?>">
                    <input type="hidden" class="ingrediente_id" name="ingrediente_id" value="">
                    <input type="hidden" class="busqueda" name="busqueda">                    

                    <p class="rdm-formularios--label"><label for="cantidad">Cantidad*</label></p>
                    <p><input type="number" class="cantidad" id="cantidad" name="cantidad" id="cantidad" step="any" required autofocus/></p>

                </div>            

                <div class="rdm-tarjeta--acciones-derecha">
                    <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="rdm-boton--plano-resaltado" name="agregar" value="si">Agregar</button>
                </div>

            </form>
          
        </div>
    </div>
</div>


<script>
$('#dialogo_agregar').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var busqueda = button.data('busqueda') 
  var ingrediente = button.data('ingrediente') 
  var ingrediente_id = button.data('ingrediente_id') 
  var unidad_minima = button.data('unidad_minima')
  var modal = $(this)
  modal.find('.busqueda').val(busqueda)
  modal.find('.ingrediente').text('' + ingrediente + '')
  modal.find('.ingrediente_id').val(ingrediente_id)
  modal.find('.unidad_minima').text('' + unidad_minima + '')
})
</script>







<!--dialogo para editar el ingrediente-->

<div class="modal" id="dialogo_editar" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Actualizar ingrediente
                </h1>
            </div>

            <form action="productos_composicion.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Cuantos <b><span class="unidad_minima"></span></b> de <b><span class="ingrediente"></span></b> lleva la composición de este producto?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" name="producto_id" value="<?php echo "$producto_id"; ?>">
                    <input type="hidden" class="ingrediente_id" name="ingrediente_id" value="">
                    <input type="hidden" class="producto_composicion_id" name="producto_composicion_id" value="">
                    <input type="hidden" class="busqueda" name="busqueda">                    

                    <p class="rdm-formularios--label"><label for="cantidad">Cantidad*</label></p>
                    <p><input type="number" class="cantidad" id="cantidad" name="cantidad" id="cantidad" step="any" required autofocus/></p>

                </div>

                <div class="rdm-tarjeta--acciones-derecha">
                    <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="rdm-boton--plano-resaltado" name="editar" value="si">Actualizar</button>     
                </div>

            </form>
          
        </div>
    </div>
</div>



<script>
$('#dialogo_editar').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var busqueda = button.data('busqueda') 
  var ingrediente = button.data('ingrediente') 
  var ingrediente_id = button.data('ingrediente_id') 
  var unidad_minima = button.data('unidad_minima')
  var cantidad = button.data('cantidad')
  var producto_composicion_id = button.data('producto_composicion_id')
  var modal = $(this)
  modal.find('.busqueda').val(busqueda)
  modal.find('.ingrediente').text('' + ingrediente + '')
  modal.find('.ingrediente_id').val(ingrediente_id)
  modal.find('.unidad_minima').text('' + unidad_minima + '')
  modal.find('.cantidad').val(cantidad)
  modal.find('.producto_composicion_id').val(producto_composicion_id)
})
</script>





<!--dialogo para eliminar el ingrediente-->

<div class="modal" id="dialogo_eliminar" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Retirar ingrediente
                </h1>
            </div>

            <form action="productos_composicion.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea retirar el ingrediente <b><span class="ingrediente"></span></b> de la composición de este producto?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" name="producto_id" value="<?php echo "$producto_id"; ?>">
                    <input type="hidden" class="producto_composicion_id" name="producto_composicion_id" value="">
                    <input type="hidden" class="busqueda" name="busqueda">
                </div>            

                <div class="rdm-tarjeta--acciones-derecha">
                    <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="rdm-boton--plano-resaltado" name="eliminar" value="si">Retirar</button>
                </div>

            </form>
          
        </div>
    </div>
</div>


<script>
$('#dialogo_eliminar').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var busqueda = button.data('busqueda') 
  var producto_composicion_id = button.data('producto_composicion_id') //producto_composicion_id
  var ingrediente = button.data('ingrediente') //ingrediente
  var modal = $(this)    
  modal.find('.busqueda').val(busqueda)
  modal.find('.producto_composicion_id').val(producto_composicion_id)
  modal.find('.ingrediente').text('' + ingrediente + '')
})
</script>


<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>








</body>
</html>