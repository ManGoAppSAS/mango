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

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="plantillas_factura_detalle.php?plantilla_factura_id=<?php echo "$plantilla_factura_id"; ?>#factura"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Plantilla de factura</h2>
        </div>
    </div>
</header>

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
                $nit = $fila['nit'];
                $regimen = $fila['regimen'];
                $local = $fila['local'];
                $direccion = $fila['direccion'];
                $telefono = $fila['telefono'];
            }
            else
            {
                $nit = "";
                $regimen = "";
                $local = "";
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
    
    

    <main class="rdm--contenedor-toolbar" style="width: 100%; max-width: 1000px">

        <h2 class="rdm-lista--titulo-largo">Factura</h2>

        <section class="rdm-factura-estandar">

            <article class="rdm-factura--estandar-contenedor">

                <div class="rdm-factura--estandar-fila">
            
                    <div class="rdm-factura--estandar-columna">

                        <?php if ($imagen == "si") { ?>

                        <img src="<?php echo ($logo)?>" alt="Logo" style="width: 50%;">

                        <?php } ?>

                    </div>

                    <div class="rdm-factura--estandar-columna">

                        <div><?php echo ucfirst(nl2br($encabezado)) ?></div>
                        
                        
                        <?php if (!empty($nit)) { ?><div>NIT <?php echo ucfirst($nit) ?></div> <?php } ?>
                        <?php if (!empty($regimen)) { ?><div><?php echo ucfirst($regimen) ?></div> <?php } ?>    
                        <?php if (!empty($local)) { ?><div><?php echo ucfirst($local) ?></div> <?php } ?>
                        <?php if (!empty($direccion)) { ?><div><?php echo ucfirst($direccion) ?></div> <?php } ?>
                        <?php if (!empty($telefono)) { ?><div><?php echo ucfirst($telefono) ?></div> <?php } ?>

                        

                    </div>                

                    <div class="rdm-factura--estandar-columna">

                        <div><b><?php echo ucfirst($titulo)?> #<?php echo ($prefijo)?><?php echo ($numero_relleno)?><?php echo ($sufijo)?></b><br>
                        <?php echo "$fecha_mod"; ?> - <?php echo "$hora_mod"; ?></div> 

                        <?php if ($mostrar_atendido == "si") { ?>

                        <br>

                        <div>Atendido por <?php echo ucwords($sesion_nombres); ?> <?php echo ucwords($sesion_apellidos); ?><br>
                        En la ubicación Mesa 1</div>

                        <?php } ?>

                    </div>

                </div>


                <br>



                <div class="rdm-factura--estandar-fila">
            
                    <div class="rdm-factura--estandar-columna">
                        
                        <div><span style="font-weight: bold">Cliente:</span> Nombre del cliente</div>
                        <div><span style="font-weight: bold">Documento No:</span> Documento del cliente</div>

                    </div>

                    <div class="rdm-factura--estandar-columna">

                        <div><span style="font-weight: bold">Dirección:</span> Dirección del cliente</div>
                        <div><span style="font-weight: bold">Teléfono:</span> Teléfono del cliente</div>

                    </div>

                </div>



                <br>



                <div class="rdm-factura--estandar-fila">
            
                    <div class="rdm-factura--estandar-columna" style="text-align: center;"><b>Cantidad</b></div>

                    <div class="rdm-factura--estandar-columna" style="text-align: center;"><b>Producto</b></div>

                    <?php if ($mostrar_impuesto == "si") { ?>

                    <div class="rdm-factura--estandar-columna" style="text-align: right;"><b>Base Imp.</b></div>

                    <div class="rdm-factura--estandar-columna" style="text-align: right;"><b>Valor Imp.</b></div>

                    <?php } ?>

                    <div class="rdm-factura--estandar-columna" style="text-align: right;"><b>Total Base</b></div>

                    <div class="rdm-factura--estandar-columna" style="text-align: right;"><b>Total Impuestos</b></div>

                    <div class="rdm-factura--estandar-columna" style="text-align: right; "><b>TOTAL</b></div>
                    
                </div>



                
                <div class="rdm-factura--estandar-item">

                    <div class="rdm-factura--estandar-fila">
                
                        <div class="rdm-factura--estandar-columna" style="text-align: center;">No xx</div>

                        <div class="rdm-factura--estandar-columna" style="text-align: center;">Item 1</div>

                        <?php if ($mostrar_impuesto == "si") { ?>

                        <div class="rdm-factura--estandar-columna" style="text-align: right;">$xxxx</div>

                        <div class="rdm-factura--estandar-columna" style="text-align: right;">(xx%) $x.xxxx</div>

                        <?php } ?>

                        <div class="rdm-factura--estandar-columna" style="text-align: right;">$x.xxxx</div>

                        <div class="rdm-factura--estandar-columna" style="text-align: right;">$x.xxxx</div>

                        <div class="rdm-factura--estandar-columna" style="text-align: right;">$x.xxxx</div>

                    </div>

                </div>

                <div class="rdm-factura--estandar-item">

                    <div class="rdm-factura--estandar-fila">
                
                        <div class="rdm-factura--estandar-columna" style="text-align: center;">No xx</div>

                        <div class="rdm-factura--estandar-columna" style="text-align: center;">Item 2</div>

                        <?php if ($mostrar_impuesto == "si") { ?>

                        <div class="rdm-factura--estandar-columna" style="text-align: right;">$xxxx</div>

                        <div class="rdm-factura--estandar-columna" style="text-align: right;">(xx%) $x.xxxx</div>

                        <?php } ?>

                        <div class="rdm-factura--estandar-columna" style="text-align: right;">$x.xxxx</div>

                        <div class="rdm-factura--estandar-columna" style="text-align: right;">$x.xxxx</div>

                        <div class="rdm-factura--estandar-columna" style="text-align: right;">$x.xxxx</div>

                    </div>

                </div>


                <br>
                

                

                <div class="rdm-factura--estandar-fila">
                    
                    <div class="rdm-factura--estandar-columna"></div>
                    <div class="rdm-factura--estandar-columna"></div>
                    <div class="rdm-factura--estandar-columna"></div>
                    

                    <div class="rdm-factura--estandar-columna" style="text-align: right;">

                        
                        <div class="rdm-factura--estandar-item">
                            <div>Total Base Imp.</div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div>Total Valor Imp.</div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div><b>Subtotal Venta:</b></div>
                        </div>

                        <br>                    
                        
                        <div class="rdm-factura--estandar-item">
                            <div>Descuento (xx%)</div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div>Propina</div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div><b>TOTAL A PAGAR</b></div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div>Dinero recibido</div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div><b>Cambio</b></div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div>Tipo de pago</div>
                        </div>

                    </div>

                    <div class="rdm-factura--estandar-columna" style="text-align: right;">

                        <div class="rdm-factura--estandar-item">
                            <div>$x.xxx</div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div>$x.xxx</div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div><b>$x.xxx</b></div>
                        </div>

                        <br>
                        
                        <div class="rdm-factura--estandar-item">
                            <div>$x.xxx</div>
                        </div>                   
                        <div class="rdm-factura--estandar-item">
                            <div>$x.xxx</div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div><b>$x.xxx</b></div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div>$x.xxx</div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div><b>$x.xxx</b></div>
                        </div>
                        <div class="rdm-factura--estandar-item">
                            <div>Efectivo</div>
                        </div>

                    </div>


                </div>

                <br>

                <div class="rdm-factura--estandar-fila">

                    <div class="rdm-factura--estandar-columna"><?php echo ucfirst(nl2br($pie)) ?></div>                     

                </div>        

            </article>

            <div class="rdm-tarjeta--acciones-izquierda">                
                <a href="plantillas_factura_detalle_factura_imprimir.php?plantilla_factura_id=<?php echo "$plantilla_factura_id"; ?>" target="_blank"><button class="rdm-boton--resaltado">Imprimir</button></a>
            </div>

        </section>

        <br>

    </main>  
    

<footer>   
    

</footer>

</body>
</html>