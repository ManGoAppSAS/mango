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
//variables de subida
if(isset($_POST['agregar'])) $agregar = $_POST['agregar']; elseif(isset($_GET['agregar'])) $agregar = $_GET['agregar']; else $agregar = null;

//variables del formulario
if(isset($_POST['componente'])) $componente = $_POST['componente']; elseif(isset($_GET['componente'])) $componente = $_GET['componente']; else $componente = null;
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
//consulto el proveedor enviado desde el select del formulario
$consulta_proveedor_g = $conexion->query("SELECT * FROM proveedor WHERE proveedor_id = '$proveedor_id'");           

if ($fila = $consulta_proveedor_g->fetch_assoc()) 
{    
    $proveedor_g = ucfirst($fila['proveedor']);
    $proveedor_g = "<option value='$proveedor_id'>$proveedor_g</option>";
}
else
{
    $proveedor_g = "<option value=''></option>";
}
?>

<?php
//agregar el componente
if ($agregar == 'si')
{
    $consulta = $conexion->query("SELECT * FROM componente WHERE componente = '$componente' and proveedor_id = '$proveedor_id'");

    if ($consulta->num_rows == 0)
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

        $insercion = $conexion->query("INSERT INTO componente values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$componente', 'comprado', '$unidad_minima', '$unidad_compra', '$costo_unidad_minima', '$costo_unidad_compra', '', '0', '$proveedor_id', '0')");        

        $mensaje = "Componente <b>" . ($componente) . "</b> agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "El componente <b>" . ($componente) . "</b> ya existe, no es posible agregarlo de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Componentes - ManGo!</title>    
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
            <a href="componentes_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Componentes</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Agregar</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    
        <section class="rdm-formulario">            

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
                    <p class="rdm-formularios--ayuda">Proveedor que vende el componente</p>
                    
                    <?php
                }
            }
            ?>

            <p class="rdm-formularios--label"><label for="componente">Nombre*</label></p>
            <p><input type="text" id="componente" name="componente" value="<?php echo "$componente"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del componente</p>
            
            <p class="rdm-formularios--label"><label for="unidad_compra">Unidad de compra*</label></p>
            <p><select id="unidad_compra" name="unidad_compra" required>
                <option value="<?php echo "$unidad_compra"; ?>"><?php echo $unidad_compra ?></option>
                <option value="">---------</option>
                <option value="g">Gramo (g)</option>
                <option value="ml">Mililitro (ml)</option>
                <option value="mm">Milimetro (mm)</option>
                <option value="">---------</option>
                <option value="kg">Kilogramo (kg)</option>
                <option value="l">Litro (l)</option>
                <option value="m">Metro (m)</option>
                <option value="">---------</option>
                <option value="arroba 12.5 kg">arroba 12.5 kg</option>
                <option value="bulto 25 kg">bulto 25 kg</option>
                <option value="bulto 50 kg">bulto 50 kg</option>
                <option value="">---------</option>
                <option value="botella 375 ml">botella 375 ml</option>
                <option value="botella 750 ml">botella 750 ml</option>
                <option value="botella 1500 ml">botella 1500 ml</option>
                <option value="garrafa 2000 ml">garrafa 2000 ml</option>
                <option value="">---------</option>
                <option value="galon 3.7 l">galon 3.7 l</option>
                <option value="botella 3 l">botella 3 l</option>
                <option value="botella 5 l">botella 5 l</option>
                <option value="botellon 18 l">botellon 18 l</option>
                <option value="botellon 20 l">botellon 20 l</option>
                <option value="">---------</option>
                <option value="unid">unid</option>
                <option value="par">par</option>
                <option value="trio">trio</option>
                <option value="decena">decena</option>
                <option value="docena">docena</option>
                <option value="quincena">quincena</option>
                <option value="treintena">treintena</option>
                <option value="centena">centena</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Unidad de compra del componente</p>

            <p class="rdm-formularios--label"><label for="costo_unidad_compra">Costo unidad de compra*</label></p>
            <p><input type="number" id="costo_unidad_compra" name="costo_unidad_compra" value="<?php echo "$costo_unidad_compra"; ?>" step="any" required /></p>
            <p class="rdm-formularios--ayuda">Costo de la unidad de compra</p>
            
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