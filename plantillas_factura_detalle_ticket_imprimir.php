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
//capturo las variables que pasan por URL o formulario
if(isset($_POST['plantilla_factura_id'])) $plantilla_factura_id = $_POST['plantilla_factura_id']; elseif(isset($_GET['plantilla_factura_id'])) $plantilla_factura_id = $_GET['plantilla_factura_id']; else $plantilla_factura_id = null;
?>

<?php
//variables de la conexion, sesion y subida
include ("sis/variables_sesion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Plantilla de factura - ManGo!</title>    
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>
</head>
<body>

    <?php
    //consulto y muestro la plantila de factura
    $consulta = $conexion->query("SELECT * FROM plantilla_factura WHERE plantilla_factura_id = '$plantilla_factura_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Esta plantilla de factura ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $plantilla_factura_id = $fila['plantilla_factura_id'];
            
            $fecha_alta = date('d/m/Y', strtotime($fila['fecha_alta']));
            $hora_alta = date('h:i a', strtotime($fila['fecha_alta']));

            $fecha_mod = date('d/m/Y', strtotime($fila['fecha_mod']));
            $hora_mod = date('h:i a', strtotime($fila['fecha_mod']));

            $fecha_baja = date('d/m/Y', strtotime($fila['fecha_baja']));
            $hora_baja = date('h:i a', strtotime($fila['fecha_baja']));

            $usuario_alta = $fila['usuario_alta'];
            $usuario_mod = $fila['usuario_mod'];
            $usuario_baja = $fila['usuario_baja'];

            $estado = $fila['estado'];

            $titulo = $fila['titulo'];
            $prefijo = $fila['prefijo'];
            $numero_inicio = $fila['numero_inicio'];
            $numero_fin = $fila['numero_fin'];
            $numero_longitud = strlen($numero_fin);
            $numero_relleno = str_pad($numero_inicio, $numero_longitud, "0", STR_PAD_LEFT);
            $sufijo = $fila['sufijo'];
            $encabezado = $fila['encabezado'];
            $mostrar_local = $fila['mostrar_local'];
            $mostrar_atendido = $fila['mostrar_atendido'];
            $mostrar_impuesto = $fila['mostrar_impuesto'];
            $pie = $fila['pie'];

            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];

            $local_id = $fila['local_id'];

            //consulto el local
            $consulta_local = $conexion->query("SELECT * FROM local WHERE local_id = '$local_id'");           

            if ($fila = $consulta_local->fetch_assoc()) 
            {
                $local = $fila['local'];
                $tipo = $fila['tipo'];
                $direccion = $fila['direccion'];
                $telefono = $fila['telefono'];
            }
            else
            {
                $local = "No se ha asignado un local";
                $direccion = "";
                $telefono = "";

            }

            //consulto el usuario alta
            $consulta_usuario = $conexion->query("SELECT * FROM usuario WHERE usuario_id = '$usuario_alta'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $usuario_alta = $fila['correo'];
            }
            else
            {
                $usuario_alta = "";
            }

            //consulto el usuario mod
            $consulta_usuario = $conexion->query("SELECT * FROM usuario WHERE usuario_id = '$usuario_mod'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $usuario_mod = $fila['correo'];
            }
            else
            {
                $usuario_mod = "";
            }            

            //consulto el usuario baja
            $consulta_usuario = $conexion->query("SELECT * FROM usuario WHERE usuario_id = '$usuario_baja'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $usuario_baja = $fila['correo'];
            }
            else
            {
                $usuario_baja = "";
            }

            //logo de la plantilla
            $logo = "img/avatares/plantillas_factura-$plantilla_factura_id-$imagen_nombre.jpg";
            
        }
    }
    ?>

    <main class="rdm--contenedor-imprimir">    

    <section class="rdm-factura-ticket" style="box-shadow: none; max-width: 300px;">

        <article class="rdm-factura--ticket-contenedor" style="width: 100%">

            <div class="rdm-factura--ticket-fila">

                <?php if ($imagen == "si") { ?>
                    
                <img src="<?php echo ($logo)?>" alt="Logo" style="width: 33%;">

                <?php } ?>

            </div>

            <div class="rdm-factura--ticket-fila">                
                
                <div><b><?php echo ucfirst($titulo)?> #<?php echo ($prefijo)?><?php echo ($numero_relleno)?><?php echo ($sufijo)?></b><br>
                <?php echo "$fecha_mod"; ?> - <?php echo "$hora_mod"; ?></div>                

            </div>

            <div class="rdm-factura--ticket-fila">

                <div><?php echo ucfirst(nl2br($encabezado)) ?></div>                

            </div>

            <div class="rdm-factura--ticket-fila">                

                <?php if ($mostrar_local == "si") { ?>

                <div><?php echo ucfirst($local)?><br>
                <?php echo ucfirst($direccion)?><br>
                <?php echo ucfirst($telefono)?></div>  

                <?php } ?>

            </div>

            <div class="rdm-factura--ticket-fila">

                <?php if ($mostrar_atendido == "si") { ?>

                <div>Atendido por <?php echo ucwords($sesion_nombres); ?> <?php echo ucwords($sesion_apellidos); ?><br>
                En la ubicación Mesa 1</div>

                <?php } ?>

            </div>            

            

            <p class="rdm-factura--ticket-izquierda"><b>Producto / Servicio</b></p>
            <p class="rdm-factura--ticket-derecha"><b>Precio</b></p>

            <section class="rdm-factura--ticket-item">
                <div class="rdm-factura--ticket-izquierda"><b>Item 1</b></div>
                <div class="rdm-factura--ticket-derecha"><b>$ x.xxx</b></div>

                <?php if ($mostrar_impuesto == "si") { ?>

                <div class="rdm-factura--ticket-izquierda">Base Imp.</div>
                <div class="rdm-factura--ticket-derecha">$ x</div>

                <div class="rdm-factura--ticket-izquierda">Valor Imp. (x %)</div>
                <div class="rdm-factura--ticket-derecha">$ x</div>

                <?php } ?>
            </section>

            <section class="rdm-factura--ticket-item">
                <div class="rdm-factura--ticket-izquierda"><b>Item 2</b></div>
                <div class="rdm-factura--ticket-derecha"><b>$ x.xxx</b></div>

                <?php if ($mostrar_impuesto == "si") { ?>

                <div class="rdm-factura--ticket-izquierda">Base Imp.</div>
                <div class="rdm-factura--ticket-derecha">$ x</div>

                <div class="rdm-factura--ticket-izquierda">Valor Imp. (x %)</div>
                <div class="rdm-factura--ticket-derecha">$ x</div>

                <?php } ?>
            </section>            

            <br>

            <section class="rdm-factura--ticket-item">
                <div class="rdm-factura--ticket-izquierda">Total Base Imp.</div>
                <div class="rdm-factura--ticket-derecha">$ x</div>

                <div class="rdm-factura--ticket-izquierda">Total Valor Imp.</div>
                <div class="rdm-factura--ticket-derecha">$ x</div>

                <div class="rdm-factura--ticket-izquierda"><b>Sub Total</b></div>
                <div class="rdm-factura--ticket-derecha"><b>$ x.xxx</b></div>
            </section>

            <br>

            <section class="rdm-factura--ticket-item">
                <div class="rdm-factura--ticket-izquierda">Descuento xx %</div>
                <div class="rdm-factura--ticket-derecha">- $ x.xxx</div>
            </section>

            <section class="rdm-factura--ticket-item">
                <div class="rdm-factura--ticket-izquierda">Propina xx %</div>
                <div class="rdm-factura--ticket-derecha"> $ xxx</div>
            </section>

            <section class="rdm-factura--ticket-item">
                <div class="rdm-factura--ticket-izquierda"><b>TOTAL A PAGAR</b></div>
                <div class="rdm-factura--ticket-derecha"><b>$ x.xxx</b></div>
            </section>

            <section class="rdm-factura--ticket-item">
                <div class="rdm-factura--ticket-izquierda">Dinero recibido</div>
                <div class="rdm-factura--ticket-derecha">$ x.xxx</div>
            </section>

            <section class="rdm-factura--ticket-item">
                <div class="rdm-factura--ticket-izquierda"><b>Cambio</b></div>
                <div class="rdm-factura--ticket-derecha"><b>$ x.xxx</b></div>
            </section>

            <section class="rdm-factura--ticket-item">
                <div class="rdm-factura--ticket-izquierda">Tipo de pago</div>
                <div class="rdm-factura--ticket-derecha">Efectivo</div>
            </section>

            <br>

            <div class="rdm-factura--ticket-fila">
                <div><?php echo ucfirst(nl2br($pie)); ?></div>
            </div>

        </article>
        

    </section>

    <br>

</main>

<footer>
    
    

</footer>

</body>
</html>