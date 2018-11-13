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
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;

//variables del formulario
if(isset($_POST['ingrediente_id'])) $ingrediente_id = $_POST['ingrediente_id']; elseif(isset($_GET['ingrediente_id'])) $ingrediente_id = $_GET['ingrediente_id']; else $ingrediente_id = null;
if(isset($_POST['ingrediente'])) $ingrediente = $_POST['ingrediente']; elseif(isset($_GET['ingrediente'])) $ingrediente = $_GET['ingrediente']; else $ingrediente = null;
if(isset($_POST['unidad_minima'])) $unidad_minima = $_POST['unidad_minima']; elseif(isset($_GET['unidad_minima'])) $unidad_minima = $_GET['unidad_minima']; else $unidad_minima = null;
if(isset($_POST['unidad_compra'])) $unidad_compra = $_POST['unidad_compra']; elseif(isset($_GET['unidad_compra'])) $unidad_compra = $_GET['unidad_compra']; else $unidad_compra = null;
if(isset($_POST['costo_unidad_minima'])) $costo_unidad_minima = $_POST['costo_unidad_minima']; elseif(isset($_GET['costo_unidad_minima'])) $costo_unidad_minima = $_GET['costo_unidad_minima']; else $costo_unidad_minima = null;
if(isset($_POST['costo_unidad_compra'])) $costo_unidad_compra = $_POST['costo_unidad_compra']; elseif(isset($_GET['costo_unidad_compra'])) $costo_unidad_compra = $_GET['costo_unidad_compra']; else $costo_unidad_compra = null;
if(isset($_POST['proveedor_id'])) $proveedor_id = $_POST['proveedor_id']; elseif(isset($_GET['proveedor_id'])) $proveedor_id = $_GET['proveedor_id']; else $proveedor_id = 0;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información de la ubicación
if ($editar == "si")
{
    //calculo la unidad minima con base a la unidad de compra
    if (($unidad_compra == "kg") or ($unidad_compra == "arroba 12.5 kg") or ($unidad_compra == "bulto 25 kg") or ($unidad_compra == "bulto 50 kg"))
    {
        $unidad_minima = "g";
    }
    else
    {
    if (($unidad_compra == "l") or ($unidad_compra == "botella 375 ml") or ($unidad_compra == "botella 750 ml") or ($unidad_compra == "botella 1500 ml") or ($unidad_compra == "garrafa 2000 ml") or ($unidad_compra == "galon 3.7 l") or ($unidad_compra == "botella 5 l") or ($unidad_compra == "botellon 18 l") or ($unidad_compra == "botellon 20 l") or ($unidad_compra == "botella 3 l"))
        {
            $unidad_minima = "ml";
        }
        else
        {
            if ($unidad_compra == "m")
            {
                $unidad_minima = "mm";
            }
            else
            {
                if (($unidad_compra == "par") or ($unidad_compra == "trio") or ($unidad_compra == "decena") or ($unidad_compra == "docena") or ($unidad_compra == "quincena") or ($unidad_compra == "treintena") or ($unidad_compra == "centena"))
                {
                    $unidad_minima = "unid";
                }
                else
                {
                    $unidad_minima = $unidad_compra;
                }
            }
        }
    }

    //si la unidad es kilos, litros o metros se divide por mil para obtener la unidad minima
    if (($unidad_compra == "kg") or ($unidad_compra == "l") or ($unidad_compra == "m"))
    {
        $costo_unidad_minima = $costo_unidad_compra / 1000;
    }
    else
    {
        if ($unidad_compra == "botella 375 ml")
        {
            $costo_unidad_minima = $costo_unidad_compra / 375;
        }
        else
        {
            if ($unidad_compra == "botella 750 ml")
            {
                $costo_unidad_minima = $costo_unidad_compra / 750;
            }
            else
            {
                if ($unidad_compra == "botella 1500 ml")
                {
                    $costo_unidad_minima = $costo_unidad_compra / 1500;
                }
                else
                {
                    if ($unidad_compra == "garrafa 2000 ml")
                    {
                        $costo_unidad_minima = $costo_unidad_compra / 2000;
                    }
                    else
                    {
                        if ($unidad_compra == "arroba 12.5 kg")
                        {
                            $costo_unidad_minima = $costo_unidad_compra / 12500;
                        }
                        else
                        {
                            if ($unidad_compra == "bulto 25 kg")
                            {
                                $costo_unidad_minima = $costo_unidad_compra / 25000;
                            }
                            else
                            {
                                if ($unidad_compra == "bulto 50 kg")
                                {
                                    $costo_unidad_minima = $costo_unidad_compra / 50000;
                                }
                                else
                                {
                                    if ($unidad_compra == "galon 3.7 l")
                                    {
                                        $costo_unidad_minima = $costo_unidad_compra / 3785;
                                    }
                                    else
                                    {
                                        if ($unidad_compra == "botella 5 l")
                                        {
                                            $costo_unidad_minima = $costo_unidad_compra / 5000;
                                        }
                                        else
                                        {
                                            if ($unidad_compra == "botellon 18 l")
                                            {
                                                $costo_unidad_minima = $costo_unidad_compra / 18000;
                                            }
                                            else
                                            {
                                                if ($unidad_compra == "botellon 20 l")
                                                {
                                                    $costo_unidad_minima = $costo_unidad_compra / 20000;
                                                }
                                                else
                                                {
                                                    if ($unidad_compra == "botella 3 l")
                                                    {
                                                        $costo_unidad_minima = $costo_unidad_compra / 3000;
                                                    }
                                                    else
                                                    {
                                                        if ($unidad_compra == "par")
                                                        {
                                                            $costo_unidad_minima = $costo_unidad_compra / 2;
                                                        }
                                                        else
                                                        {
                                                            if ($unidad_compra == "trio")
                                                            {
                                                                $costo_unidad_minima = $costo_unidad_compra / 3;
                                                            }
                                                            else
                                                            {
                                                                if ($unidad_compra == "decena")
                                                                {
                                                                    $costo_unidad_minima = $costo_unidad_compra / 10;
                                                                }
                                                                else
                                                                {
                                                                    if ($unidad_compra == "docena")
                                                                    {
                                                                        $costo_unidad_minima = $costo_unidad_compra / 12;
                                                                    }
                                                                    else
                                                                    {
                                                                        if ($unidad_compra == "quincena")
                                                                        {
                                                                            $costo_unidad_minima = $costo_unidad_compra / 15;
                                                                        }
                                                                        else
                                                                        {
                                                                            if ($unidad_compra == "treintena")
                                                                            {
                                                                                $costo_unidad_minima = $costo_unidad_compra / 30;
                                                                            }
                                                                            else
                                                                            {
                                                                                if ($unidad_compra == "centena")
                                                                                {
                                                                                    $costo_unidad_minima = $costo_unidad_compra / 100;
                                                                                }
                                                                                else
                                                                                {
                                                                                    $costo_unidad_minima = $costo_unidad_compra;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
        
    $actualizar = $conexion->query("UPDATE ingrediente SET fecha_mod = '$ahora', usuario_mod = '$sesion_id', ingrediente = '$ingrediente', unidad_minima = '$unidad_minima', unidad_compra = '$unidad_compra', costo_unidad_minima = '$costo_unidad_minima', costo_unidad_compra = '$costo_unidad_compra', proveedor_id = '$proveedor_id' WHERE ingrediente_id = '$ingrediente_id'");

    if ($actualizar)
    {
        $mensaje = "Cambios guardados";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }     
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
<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="ingredientes_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Ingrediente</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro el ingrediente
    $consulta = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente_id = '$ingrediente_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Este ingrediente ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $ingrediente_id = $fila['ingrediente_id'];
            
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

            $ingrediente = $fila['ingrediente'];
            $tipo = $fila['tipo'];
            $unidad_minima = $fila['unidad_minima'];
            $unidad_compra = $fila['unidad_compra'];
            $costo_unidad_minima = $fila['costo_unidad_minima'];
            $costo_unidad_compra = $fila['costo_unidad_compra'];

            $proveedor_id = $fila['proveedor_id'];

            //consulto el proveedor
            $consulta2 = $conexion->query("SELECT * FROM proveedor WHERE proveedor_id = $proveedor_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $proveedor = $filas2['proveedor'];
                $telefono = $filas2['telefono'];
                $correo = $filas2['correo'];
            }
            else
            {
                $proveedor = "";
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
            ?>

            <section class="rdm-tarjeta">

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($ingrediente) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo">$<?php echo number_format($costo_unidad_compra, 2, ",", "."); ?> x <?php echo ucfirst($unidad_compra); ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">

                    <?php if (!empty($tipo)) { ?>
                        <p><b>Tipo</b> <br><?php echo ucfirst($tipo) ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_compra)) { ?>
                        <p><b>Unidad de compra</b> <br><?php echo ucfirst($unidad_compra); ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_compra)) { ?>
                        <p><b>Costo de unidad de compra</b> <br>$<?php echo number_format($costo_unidad_compra, 2, ",", "."); ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_minima)) { ?>
                        <p><b>Unidad mínima</b> <br><?php echo ucfirst($unidad_minima); ?></p>
                    <?php } ?>

                    <?php if (!empty($unidad_minima)) { ?>
                        <p><b>Costo de unidad mínima</b> <br>$<?php echo number_format($costo_unidad_minima, 2, ",", "."); ?></p>
                    <?php } ?>

                    

                    

                    <?php if (!empty($proveedor)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Proveedor</b> <br><?php echo ucfirst($proveedor) ?></p>
                    <?php } ?>

                    <?php if (!empty($contacto)) { ?>
                        <p><b>Contacto</b> <br><?php echo ucwords($contacto) ?></p>
                    <?php } ?>

                    <?php if (!empty($correo)) { ?>
                        <p><b>Correo electrónico</b> <br><a href="mailto:<?php echo ($correo) ?>"><?php echo ($correo) ?></a></p>
                    <?php } ?>

                    <?php if (!empty($telefono)) { ?><p><b>Teléfono</b> <br><a href="https://api.whatsapp.com/send?phone=57<?php echo ucfirst($telefono) ?>" target="_blank"><?php echo ucfirst($telefono) ?></a></p><?php } ?>


                    <?php if (!empty($usuario_alta)) { ?>
                        <div class="rdm-tarjeta--separador"></div>
                        <p><b>Creado</b> <br><?php echo ucfirst("$fecha_alta"); ?> - <?php echo ucfirst("$hora_alta"); ?><br><?php echo ("$usuario_alta"); ?></p>
                    <?php } ?>

                    <?php if (!empty($usuario_mod)) { ?>
                        <p><b>Modificado</b> <br><?php echo ucfirst("$fecha_mod"); ?> - <?php echo ucfirst("$hora_mod"); ?><br><?php echo ("$usuario_mod"); ?></p>
                    <?php } ?>

                    <?php if (!empty($usuario_baja)) { ?>
                        <p><b>Eliminado</b> <br><?php echo ucfirst("$fecha_baja"); ?> - <?php echo ucfirst("$hora_baja"); ?><br><?php echo ("$usuario_baja"); ?></p>
                    <?php } ?>

                    <p><b>Estado</b> <br><?php echo ucfirst($estado) ?></p>
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

<footer>
    
    <a href="ingredientes_editar.php?ingrediente_id=<?php echo "$ingrediente_id"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>