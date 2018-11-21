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
//variable para eliminar
if(isset($_POST['eliminar_compra'])) $eliminar_compra = $_POST['eliminar_compra']; elseif(isset($_GET['eliminar_compra'])) $eliminar_compra = $_GET['eliminar_compra']; else $eliminar_compra = null;

//variable de consulta
if(isset($_POST['busqueda'])) $busqueda = $_POST['busqueda']; elseif(isset($_GET['busqueda'])) $busqueda = $_GET['busqueda']; else $busqueda = null;

//variables de envio de inventario
if(isset($_POST['recibir_ingrediente'])) $recibir_ingrediente = $_POST['recibir_ingrediente']; elseif(isset($_GET['recibir_ingrediente'])) $recibir_ingrediente = $_GET['recibir_ingrediente']; else $recibir_ingrediente = null;
if(isset($_POST['ingrediente_id'])) $ingrediente_id = $_POST['ingrediente_id']; elseif(isset($_GET['ingrediente_id'])) $ingrediente_id = $_GET['ingrediente_id']; else $ingrediente_id = null;
if(isset($_POST['compra_id'])) $compra_id = $_POST['compra_id']; elseif(isset($_GET['compra_id'])) $compra_id = $_GET['compra_id']; else $compra_id = null;
if(isset($_POST['compra_ingrediente_id'])) $compra_ingrediente_id = $_POST['compra_ingrediente_id']; elseif(isset($_GET['compra_ingrediente_id'])) $compra_ingrediente_id = $_GET['compra_ingrediente_id']; else $compra_ingrediente_id = null;

//cantidades
if(isset($_POST['cantidad_enviada'])) $cantidad_enviada = $_POST['cantidad_enviada']; elseif(isset($_GET['cantidad_enviada'])) $cantidad_enviada = $_GET['cantidad_enviada']; else $cantidad_enviada = null;
if(isset($_POST['cantidad_recibida'])) $cantidad_recibida = $_POST['cantidad_recibida']; elseif(isset($_GET['cantidad_recibida'])) $cantidad_recibida = $_GET['cantidad_recibida']; else $cantidad_recibida = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>


<?php
//agrego el componente al inventario del local o punto de venta
if ($recibir_ingrediente == 'si')
{
    //consutlo si ya existe este componente en el inventario
    $consulta_inventario = $conexion->query("SELECT * FROM inventario WHERE ingrediente_id = '$ingrediente_id' and local_id = '$sesion_local_id'");

    //si no existe lo creo en el inventario
    if ($consulta_inventario->num_rows == 0)
    { 
        $cantidad_maxima = $cantidad_recibida;
        $cantidad_minima = floor(($cantidad_recibida * 20) / 100);

        $crear_inventario = $conexion->query("INSERT INTO inventario values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$cantidad_recibida', '$cantidad_minima', '$cantidad_maxima', '$ingrediente_id', '$sesion_local_id')");

        $inventario_id = $conexion->insert_id;

        if ($crear_inventario)
        {
            $mensaje = "Ingrediente recibido";
            $body_snack = 'onLoad="Snackbar()"';
            $mensaje_tema = "aviso";
        }
    }
    else
    {
        if ($fila_inventario = $consulta_inventario->fetch_assoc()) 
        {
            $inventario_id = $fila_inventario['inventario_id'];
            $cantidad_actual = $fila_inventario['cantidad_actual'];
        }

        $nueva_cantidad = $cantidad_actual + $cantidad_recibida;

        $cantidad_maxima = $nueva_cantidad;
        $cantidad_minima = floor(($nueva_cantidad * 20) / 100);

        $actualizar_inventario = $conexion->query("UPDATE inventario SET fecha_mod = '$ahora', usuario_mod = '$sesion_id', cantidad_actual = '$nueva_cantidad', cantidad_minima = '$cantidad_minima', cantidad_maxima = '$cantidad_maxima' WHERE inventario_id = '$inventario_id'");

        if ($actualizar_inventario)
        {
            $mensaje = "Ingrediente actualizado";
            $body_snack = 'onLoad="Snackbar()"';
            $mensaje_tema = "aviso";
        }
    }

    //actualizo el estado del componente en el despacho a recibido
    $actualizo_ingrediente = $conexion->query("UPDATE compra_ingrediente SET estado = 'enviado' WHERE compra_ingrediente_id = '$compra_ingrediente_id'");    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Recibir inventario - ManGo!</title>
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
                $$.post("zonas_entrega_buscar.php", {busqueda: textoBusqueda}, function(mensaje) {
                    $("#resultadoBusqueda").html(mensaje);
                 }); 
             } else { 
                $("#resultadoBusqueda").html('');
                };
        
        }, 500); // Will do the ajax stuff after 1000 ms, or 1 s
    }
    </script>
</head>
<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="inventario_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Recibir inventario</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    





    <?php
    //consulto los proveedores
    $consulta = $conexion->query("SELECT DISTINCT p.proveedor AS proveedor,p.proveedor_id AS proveedor_id FROM compra AS c JOIN compra_ingrediente AS ci ON c.compra_id = ci.compra_id JOIN ingrediente AS i ON i.ingrediente_id = ci.ingrediente_id JOIN proveedor AS p ON p.proveedor_id = i.proveedor_id WHERE c.destino = '$sesion_local_id' AND ci.estado = 'enviado' AND c.compra_id = '$compra_id'");    
           
    while ($fila = $consulta->fetch_assoc()) 
    {
        $proveedor_id = $fila['proveedor_id'];
        $proveedor = $fila['proveedor'];

        ?>                
                
        <h2 class="rdm-lista--titulo-largo"><?php echo ucfirst($proveedor) ?></h2>

        <section class="rdm-lista">

        <?php

        //consulto los ingredientes
        $consulta2 = $conexion->query("SELECT ci.ingrediente_id AS ingrediente_id,i.ingrediente AS ingrediente,ci.cantidad_enviada AS cantidad_enviada,i.costo_unidad_compra AS costo_unidad_compra,i.unidad_compra AS unidad_compra,ci.compra_ingrediente_id AS compra_ingrediente_id FROM compra AS c JOIN compra_ingrediente AS ci ON c.compra_id = ci.compra_id JOIN ingrediente AS i ON i.ingrediente_id = ci.ingrediente_id WHERE ci.compra_id = '$compra_id' AND i.proveedor_id = '$proveedor_id' AND ci.estado = 'enviado'");    
               
        while ($fila = $consulta2->fetch_assoc()) 
        {
            $ingrediente_id = $fila['ingrediente_id'];
            $ingrediente = $fila['ingrediente'];
            $cantidad_enviada = $fila['cantidad_enviada'];
            $costo_unidad_compra = $fila['costo_unidad_compra'];
            $unidad_compra = $fila['unidad_compra'];
            $compra_ingrediente_id = $fila['compra_ingrediente_id'];

            //color de fondo segun la primer letra
            $avatar_id = $ingrediente_id;
            $avatar_nombre = "$ingrediente";

            include ("sis/avatar_color.php");
            
            //consulto el avatar
            $imagen = '<div class="rdm-lista--avatar-color" style="background-color: hsl('.$ab_hue.', '.$ab_sat.', '.$ab_lig.'); color: hsl('.$at_hue.', '.$at_sat.', '.$at_lig.');"><span class="rdm-lista--avatar-texto">'.strtoupper(substr($avatar_nombre, 0, 1)).'</span></div>';
            
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
                    <a href="" data-toggle="modal" data-target="#dialogo_recibir" data-ingrediente="<?php echo ucfirst($ingrediente) ?>" data-ingrediente_id="<?php echo "$ingrediente_id"; ?>" data-unidad_compra="<?php echo ucfirst($unidad_compra) ?>" data-cantidad_enviada="<?php echo ucfirst($cantidad_enviada) ?>" data-compra_ingrediente_id="<?php echo ucfirst($compra_ingrediente_id) ?>" data-proveedor="<?php echo ucfirst($proveedor) ?>" data-costo_unidad_compra="<?php echo ucfirst($costo_unidad_compra) ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-download zmdi-hc-2x" style="color: rgba(0, 0, 0, 0.6)"></i></div></a>
                </div>
            </div>

            <?php
        }
        ?>

        </section>            
        
    <?php
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





<!--dialogo para recibir el ingrediente-->

<div class="modal" id="dialogo_recibir" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">
                    Recibir ingrediente
                </h1>
            </div>

            <form action="inventario_recibir.php" method="post" enctype="multipart/form-data">

                <div class="rdm-tarjeta--cuerpo">
                    Vas a recibir <b><span class="cantidad_enviada"></span> <span class="unidad_compra"></span></b> de <b><span class="ingrediente"></span></b> del proveedor <b><span class="proveedor"></span></b> en el inventario de <b><?php echo ucfirst($sesion_local) ?></b>
                </div>

                <div class="rdm-tarjeta--modal-cuerpo">
                    <input type="hidden" name="compra_id" value="<?php echo "$compra_id"; ?>">
                    <input type="hidden" class="ingrediente_id" name="ingrediente_id" value="">
                    <input type="hidden" class="compra_ingrediente_id" name="compra_ingrediente_id" value="">
                    <input type="hidden" class="cantidad_enviada" name="cantidad_enviada" value="">

                    <p class="rdm-formularios--label"><label for="cantidad_recibida">Cantidad recibida*</label></p>
                    <p><input type="tel" class="cantidad_enviada" id="cantidad_recibida" name="cantidad_recibida" id="cantidad_recibida" value="" required /></p>

                    <p class="rdm-formularios--label"><label for="costo_unidad_compra">Costo unidad de compra*</label></p>
                    <p><input type="tel" class="costo_unidad_compra" id="costo_unidad_compra" name="costo_unidad_compra" id="costo_unidad_compra" value="" required /></p>

                    <p class="rdm-formularios--label"><label for="observaciones">Observaciones</label></p>
                    <p><textarea id="observaciones" name="observaciones"></textarea></p>
                </div>

                <div class="rdm-tarjeta--acciones-derecha">
                    <button class="rdm-boton--plano" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="rdm-boton--plano-resaltado" name="recibir_ingrediente" value="si">Recibir</button>
                </div>

            </form>
          
        </div>
    </div>
</div>


<script>
$('#dialogo_recibir').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var ingrediente = button.data('ingrediente') 
  var ingrediente_id = button.data('ingrediente_id') 
  var unidad_compra = button.data('unidad_compra')
  var cantidad_enviada = button.data('cantidad_enviada')
  var compra_ingrediente_id = button.data('compra_ingrediente_id')
  var proveedor = button.data('proveedor')
  var costo_unidad_compra = button.data('costo_unidad_compra')
  var modal = $(this)
  modal.find('.ingrediente').text('' + ingrediente + '')
  modal.find('.ingrediente_id').val(ingrediente_id)
  modal.find('.unidad_compra').text('' + unidad_compra + '')
  modal.find('.cantidad_enviada').val(cantidad_enviada)
  modal.find('.cantidad_enviada').text('' + cantidad_enviada + '')
  modal.find('.compra_ingrediente_id').val(compra_ingrediente_id)
  modal.find('.proveedor').text('' + proveedor + '')
  modal.find('.costo_unidad_compra').val(costo_unidad_compra)
})
</script>


<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
    
<footer>
    
    

</footer>

</body>
</html>