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
if(isset($_POST['crear_compra'])) $crear_compra = $_POST['crear_compra']; elseif(isset($_GET['crear_compra'])) $crear_compra = $_GET['crear_compra']; else $crear_compra = null;
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;

//variable para eliminar o editar
if(isset($_POST['agregar'])) $agregar = $_POST['agregar']; elseif(isset($_GET['agregar'])) $agregar = $_GET['agregar']; else $agregar = null;
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;

//variable de consulta
if(isset($_POST['busqueda'])) $busqueda = $_POST['busqueda']; elseif(isset($_GET['busqueda'])) $busqueda = $_GET['busqueda']; else $busqueda = null;

//capturo las variables que pasan por URL o formulario
if(isset($_POST['local_id'])) $local_id = $_POST['local_id']; elseif(isset($_GET['local_id'])) $local_id = $_GET['local_id']; else $local_id = null;
if(isset($_POST['ingrediente_id'])) $ingrediente_id = $_POST['ingrediente_id']; elseif(isset($_GET['ingrediente_id'])) $ingrediente_id = $_GET['ingrediente_id']; else $ingrediente_id = null;
if(isset($_POST['compra_id'])) $compra_id = $_POST['compra_id']; elseif(isset($_GET['compra_id'])) $compra_id = $_GET['compra_id']; else $compra_id = null;
if(isset($_POST['cantidad_enviada'])) $cantidad_enviada = $_POST['cantidad_enviada']; elseif(isset($_GET['cantidad_enviada'])) $cantidad_enviada = $_GET['cantidad_enviada']; else $cantidad_enviada = null;
if(isset($_POST['compra_ingrediente_id'])) $compra_ingrediente_id = $_POST['compra_ingrediente_id']; elseif(isset($_GET['compra_ingrediente_id'])) $compra_ingrediente_id = $_GET['compra_ingrediente_id']; else $compra_ingrediente_id = null;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//creo la compra
if ($crear_compra == 'si')
{
    $consulta = $conexion->query("SELECT * FROM compra WHERE destino = '$local_id' and estado = 'creado'");

    if ($consulta->num_rows == 0)
    {
        $insercion = $conexion->query("INSERT INTO compra values ('', '$ahora', '', '', '$sesion_id', '', '', 'creado', '0', '', '', '$local_id')");

        $compra_id = $conexion->insert_id;
        
        $mensaje = "Compra <b>No " . ($compra_id) . "</b> creada";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        if ($filas = $consulta->fetch_assoc())
        {
            $compra_id = $filas['compra_id'];

            $mensaje = "Continúa la compra <b>No " . ($compra_id) . "</b>";
            $body_snack = 'onLoad="Snackbar()"';
            $mensaje_tema = "aviso";
        }
    }
}
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
    $borrar = $conexion->query("DELETE FROM compra_ingrediente WHERE compra_ingrediente_id = '$compra_ingrediente_id'");

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
    $actualizar = $conexion->query("UPDATE compra_ingrediente SET cantidad_enviada = '$cantidad_enviada' WHERE compra_ingrediente_id = '$compra_ingrediente_id'");

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
    if ($cantidad_enviada == 0)
    {
        $cantidad_enviada = 1;
    }

    $consulta = $conexion->query("SELECT * FROM compra_ingrediente WHERE compra_id = '$compra_id' and ingrediente_id = '$ingrediente_id'");

    if ($consulta->num_rows == 0)
    {
        $insercion = $conexion->query("INSERT INTO compra_ingrediente values ('', '$ahora', '', '', '$sesion_id', '', '', 'creado', '$cantidad_enviada', '0', '0', '$compra_id', '$ingrediente_id')");
        
        $mensaje = "Ingrediente <b>".($ingrediente)."</b> agregado a la compra</b>";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "El ingrediente <b>".($ingrediente)."</b> ya fue agregado a esta compra</b>";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Compra - ManGo!</title>
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
                $.post("compras_ingredientes_buscar.php?compra_id=<?php echo ($compra_id) ?>", {busqueda: textoBusqueda}, function(mensaje) {
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
            <a href="compras_ver.php?local_id=<?php echo "$local_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Compra</h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <div class="rdm-toolbar--icono-derecha">
                <a href="" data-toggle="modal" data-target="#dialogo_eliminar_compra" data-compra_id="<?php echo ucfirst($compra_id) ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
            </div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">    

    <input type="search" name="busqueda" id="busqueda" value="<?php echo "$busqueda"; ?>" placeholder="Buscar ingrediente o proveedor" maxlength="30" autofocus autocomplete="off" onKeyUp="buscar();" onFocus="buscar(); this.select();" />

    <div id="resultadoBusqueda"></div>       

    <?php
    //consulto y muestros los ingredientes en esta compra
    $consulta = $conexion->query("SELECT * FROM compra_ingrediente WHERE compra_id = '$compra_id' ORDER BY fecha_alta DESC");

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
                        <h2 class="rdm-lista--texto-secundario">Esta compra no tiene ingredientes agregados</h2>
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
            //datos de la composicion de la compra
            $compra_ingrediente_id = $fila['compra_ingrediente_id'];            
            $cantidad_enviada = $fila['cantidad_enviada'];
            $ingrediente_id = $fila['ingrediente_id'];

            //consulto el ingrediente
            $consulta2 = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = $ingrediente_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $ingrediente = $filas2['ingrediente'];
                $unidad_compra = $filas2['unidad_compra'];
                $costo_unidad_compra = $filas2['costo_unidad_compra'];
                $proveedor_id = $filas2['proveedor_id'];

                //consulto el proveedor
                $consulta2 = $conexion->query("SELECT * FROM proveedor WHERE proveedor_id = $proveedor_id");

                if ($filas2 = $consulta2->fetch_assoc())
                {
                    $proveedor = $filas2['proveedor'];
                }
                else
                {
                    $proveedor = "";
                }

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
                $unidad_compra = "";
                $costo_unidad_compra = 0;
            }

            //calculo el costo del ingrediente
            $ingrediente_costo = $costo_unidad_compra * $cantidad_enviada;
            ?>

            <div class="rdm-lista--item-doble">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <?php echo "$imagen"; ?>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo"><?php echo ($cantidad_enviada); ?> <?php echo ucfirst($unidad_compra); ?> de <?php echo ucfirst($ingrediente); ?></h2>
                        <h2 class="rdm-lista--texto-secundario">$<?php echo number_format($ingrediente_costo, 2, ",", "."); ?></h2>
                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <a href="" data-toggle="modal" data-target="#dialogo_editar" data-ingrediente="<?php echo ucfirst($ingrediente) ?>" data-ingrediente_id="<?php echo "$ingrediente_id"; ?>" data-unidad_compra="<?php echo ucfirst($unidad_compra) ?>" data-cantidad_enviada="<?php echo ucfirst($cantidad_enviada) ?>" data-compra_ingrediente_id="<?php echo ucfirst($compra_ingrediente_id) ?>" data-proveedor="<?php echo ucfirst($proveedor) ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-edit zmdi-hc-2x" style="color: rgba(0, 0, 0, 0.6)"></i></div></a>

                    <a href="" data-toggle="modal" data-target="#dialogo_eliminar" data-compra_ingrediente_id="<?php echo ($compra_ingrediente_id) ?>" data-ingrediente="<?php echo ucfirst($ingrediente); ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-minus-circle-outline zmdi-hc-2x" style="color: rgba(0, 0, 0, 0.6)"></i></div></a>
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
    //consulto y muestro los datos de la compra
    $consulta = $conexion->query("SELECT * FROM compra WHERE compra_id = '$compra_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Esta compra ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $compra_id = $fila['compra_id'];

            $estado = $fila['estado'];
            $valor = $fila['valor'];
            $destino = $fila['destino'];

            //consulto la cantidad de ingredientes en la compra
            $consulta_ingredientes = $conexion->query("SELECT * FROM compra_ingrediente WHERE compra_id = '$compra_id'");
            $total_ingredientes = $consulta_ingredientes->num_rows;

            //consulto el destino
            $consulta2 = $conexion->query("SELECT * FROM local WHERE local_id = $destino");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $local = $filas2['local'];
            }
            else
            {
                $local = "";
            }

            //consulto el costo
            $consulta_costo = $conexion->query("SELECT * FROM compra_ingrediente WHERE compra_id = '$compra_id' ORDER BY fecha_alta DESC");

            if ($consulta_costo->num_rows != 0)
            {
                $composicion_costo = 0;

                while ($fila = $consulta_costo->fetch_assoc())
                {
                    //datos de la composicion
                    $compra_ingrediente_id = $fila['compra_ingrediente_id'];
                    $cantidad_enviada = $fila['cantidad_enviada'];
                    $ingrediente_id = $fila['ingrediente_id'];

                    //consulto el ingrediente
                    $consulta2 = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = $ingrediente_id");

                    if ($filas2 = $consulta2->fetch_assoc())
                    {            
                        $unidad_compra_c = $filas2['unidad_compra'];
                        $costo_unidad_compra_c = $filas2['costo_unidad_compra'];            
                    }
                    else
                    {            
                        $unidad_compra_c = "unid";
                        $costo_unidad_compra_c = 0;
                    }

                    //costo del ingrediente
                    $ingrediente_costo = $costo_unidad_compra_c * $cantidad_enviada;

                    //costo de la composicion
                    $composicion_costo = $composicion_costo + $ingrediente_costo;
                }

                //valor del costo
                $costo_valor = $composicion_costo;       
            }
            else                 
            {
                //valor del costo
                $costo_valor = 0;
            }
            ?>

            <section class="rdm-tarjeta">

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($local) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo">Compra No <?php echo ($compra_id); ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">                    
                
                    <p><b>Ingredientes</b> <br><?php echo ($total_ingredientes); ?></p>
                
                    <p><b>Costo</b> <br>$<?php echo number_format($costo_valor, 2, ",", "."); ?></p>                    

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

            <form action="compras_ingredientes.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Cuantos <b><span class="unidad_compra"></span></b> de <b><span class="ingrediente"></span></b> del proveedor <b><span class="proveedor"></span></b> desea agregar a esta compra?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" name="compra_id" value="<?php echo "$compra_id"; ?>">
                    <input type="hidden" class="ingrediente_id" name="ingrediente_id" value="">

                    <p><input class="rdm-formularios--input-mediano" type="number" name="cantidad_enviada" value="" placeholder="Cantidad..." step="any" required autofocus></p>
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
  var ingrediente = button.data('ingrediente') 
  var ingrediente_id = button.data('ingrediente_id') 
  var unidad_compra = button.data('unidad_compra')
  var proveedor = button.data('proveedor')
  var modal = $(this)
  modal.find('.ingrediente').text('' + ingrediente + '')
  modal.find('.ingrediente_id').val(ingrediente_id)
  modal.find('.unidad_compra').text('' + unidad_compra + '')
  modal.find('.proveedor').text('' + proveedor + '')
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

            <form action="compras_ingredientes.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Cuantos <b><span class="unidad_compra"></span></b> de <b><span class="ingrediente"></span></b> del proveedor <b><span class="proveedor"></span></b> desea agregar a esta compra?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" name="compra_id" value="<?php echo "$compra_id"; ?>">
                    <input type="hidden" class="ingrediente_id" name="ingrediente_id" value="">
                    <input type="hidden" class="compra_ingrediente_id" name="compra_ingrediente_id" value="">

                    <p><input class="rdm-formularios--input-mediano" type="number" name="cantidad_enviada" value="" placeholder="cantidad_enviada..." step="any" required autofocus></p>
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
  var ingrediente = button.data('ingrediente') 
  var ingrediente_id = button.data('ingrediente_id') 
  var unidad_compra = button.data('unidad_compra')
  var cantidad_enviada = button.data('cantidad_enviada')
  var compra_ingrediente_id = button.data('compra_ingrediente_id')
  var proveedor = button.data('proveedor')
  var modal = $(this)
  modal.find('.ingrediente').text('' + ingrediente + '')
  modal.find('.ingrediente_id').val(ingrediente_id)
  modal.find('.unidad_compra').text('' + unidad_compra + '')
  modal.find('.rdm-formularios--input-mediano').val(cantidad_enviada)
  modal.find('.compra_ingrediente_id').val(compra_ingrediente_id)
  modal.find('.proveedor').text('' + proveedor + '')
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

            <form action="compras_ingredientes.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea retirar el ingrediente <b><span class="ingrediente"></span></b> de la compra?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" name="compra_id" value="<?php echo "$compra_id"; ?>">
                    <input type="hidden" class="compra_ingrediente_id" name="compra_ingrediente_id" value="">
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
  var compra_ingrediente_id = button.data('compra_ingrediente_id') //compra_ingrediente_id
  var ingrediente = button.data('ingrediente') //ingrediente
  var modal = $(this)    
  modal.find('.compra_ingrediente_id').val(compra_ingrediente_id)
  modal.find('.ingrediente').text('' + ingrediente + '')
})
</script>



<!--dialogo para eliminar la compra-->

<div class="modal" id="dialogo_eliminar_compra" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Eliminar compra
                </h1>
            </div>

            <form action="compras_ver.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea eliminar la compra <b>No <?php echo "$compra_id"; ?></b>?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" name="compra_id" value="<?php echo "$compra_id"; ?>">
                </div>            

                <div class="rdm-tarjeta--acciones-derecha">
                    <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="rdm-boton--plano-resaltado" name="eliminar_compra" value="si">Eliminar</button>
                </div>

            </form>
          
        </div>
    </div>
</div>


<script>
$('#dialogo_eliminar').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var compra_id = button.data('compra_id') //compra_id
  var modal = $(this)    
  modal.find('.compra_id').val(compra_id)
})
</script>





<!--dialogo para confirmar envio de compra-->

<div class="modal" id="dialogo_enviar" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Terminar y enviar
                </h1>
            </div>

            <form action="compras_ver.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    ¿Desea terminar la compra <b>No <?php echo "$compra_id"; ?></b> y enviar todos los ingredientes hacia <b><?php echo "$local"; ?></b> para ser recibidos en el inventario?
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" name="compra_id" value="<?php echo "$compra_id"; ?>">

                    <p class="rdm-formularios--label"><label for="observacion_envio">Observaciones</label></p>
                    <p><textarea id="observacion_envio" name="observacion_envio"></textarea></p>
                    <p class="rdm-formularios--ayuda"></p>
                </div>

                <div class="rdm-tarjeta--acciones-derecha">
                    <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="rdm-boton--plano-resaltado" name="enviar" value="si">Terminar y enviar</button>
                </div>

            </form>
          
        </div>
    </div>
</div>


<script>
$('#dialogo_enviar').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var compra_id = button.data('compra_id') //compra_ingrediente_id
  var modal = $(this)    
  modal.find('.compra_id').val(compra_id)
})
</script>






<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>



<footer>
    
    <a href="" data-toggle="modal" data-target="#dialogo_enviar" data-compra_id="<?php echo ucfirst($compra_id) ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-mail-send zmdi-hc-2x"></i></button></a>

</footer>




</body>
</html>