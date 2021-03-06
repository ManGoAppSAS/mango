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
if(isset($_POST['ingrediente'])) $ingrediente = $_POST['ingrediente']; elseif(isset($_GET['ingrediente'])) $ingrediente = $_GET['ingrediente']; else $ingrediente = null;
if(isset($_POST['unidad_minima'])) $unidad_minima = $_POST['unidad_minima']; elseif(isset($_GET['unidad_minima'])) $unidad_minima = $_GET['unidad_minima']; else $unidad_minima = null;
if(isset($_POST['unidad_compra'])) $unidad_compra = $_POST['unidad_compra']; elseif(isset($_GET['unidad_compra'])) $unidad_compra = $_GET['unidad_compra']; else $unidad_compra = null;
if(isset($_POST['costo_unidad_minima'])) $costo_unidad_minima = $_POST['costo_unidad_minima']; elseif(isset($_GET['costo_unidad_minima'])) $costo_unidad_minima = $_GET['costo_unidad_minima']; else $costo_unidad_minima = 0;
if(isset($_POST['costo_unidad_compra'])) $costo_unidad_compra = $_POST['costo_unidad_compra']; elseif(isset($_GET['costo_unidad_compra'])) $costo_unidad_compra = $_GET['costo_unidad_compra']; else $costo_unidad_compra = 0;
if(isset($_POST['cantidad_unidad_compra'])) $cantidad_unidad_compra = $_POST['cantidad_unidad_compra']; elseif(isset($_GET['cantidad_unidad_compra'])) $cantidad_unidad_compra = $_GET['cantidad_unidad_compra']; else $cantidad_unidad_compra = null;

if(isset($_POST['productor_id'])) $productor_id = $_POST['productor_id']; elseif(isset($_GET['productor_id'])) $productor_id = $_GET['productor_id']; else $productor_id = 0;

//variables del mensaje
if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//consulto el productor enviado desde el select del formulario
$consulta_productor_g = $conexion->query("SELECT * FROM productor WHERE productor_id = '$productor_id'");           

if ($fila = $consulta_productor_g->fetch_assoc()) 
{    
    $productor_g = ucfirst($fila['productor']);
    $productor_g = "<option value='$productor_id'>$productor_g</option>";
}
else
{
    $productor_g = "<option value=''></option>";
}
?>

<?php
//agregar el ingrediente
if ($agregar == 'si')
{
    $consulta = $conexion->query("SELECT * FROM ingrediente WHERE ingrediente = '$ingrediente' and productor_id = '$productor_id'");

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

        $insercion = $conexion->query("INSERT INTO ingrediente values ('', '$ahora', '', '', '$sesion_id', '', '', 'activo', '$ingrediente', 'producido', '$unidad_minima', '$unidad_compra', '$costo_unidad_minima', '$costo_unidad_compra', '$cantidad_unidad_compra', '0', '0')");        

        $mensaje = "ingrediente <b>" . ($ingrediente) . "</b> agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }
    else
    {
        $mensaje = "El ingrediente <b>" . ($ingrediente) . "</b> ya existe, no es posible agregarlo de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingredientes producidos - ManGo!</title>    
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
            <a href="ingredientes_producidos_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Ingredientes producidos</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Agregar</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    
        <section class="rdm-formulario">            
        
            <p class="rdm-formularios--label"><label for="ingrediente">Nombre*</label></p>
            <p><input type="text" id="ingrediente" name="ingrediente" value="<?php echo "$ingrediente"; ?>" required autofocus/></p>
            <p class="rdm-formularios--ayuda">Nombre del ingrediente producido</p>

            <p class="rdm-formularios--label"><label for="cantidad_unidad_compra">Cantidad mínima de producción*</label></p>
            <p><input type="number" id="cantidad_unidad_compra" name="cantidad_unidad_compra" value="<?php echo "$cantidad_unidad_compra"; ?>" step="any" required /></p>
            <p class="rdm-formularios--ayuda">Cantidad mínima que se produce</p>
                        
            <p class="rdm-formularios--label"><label for="unidad_compra">Unidad de produccion*</label></p>
            <p><select id="unidad_compra" name="unidad_compra" required>
                <option value="<?php echo "$unidad_compra"; ?>"><?php echo ucfirst($unidad_compra) ?></option>
                <option value="">---------</option>
                <option value="g">Gramo (G)</option>
                <option value="ml">Mililitro (Ml)</option>
                <option value="mm">Milimetro (Mm)</option>
                <option value="">---------</option>
                <option value="kg">Kilogramo (Kg)</option>
                <option value="l">Litro (L)</option>
                <option value="m">Metro (M)</option>
                <option value="">---------</option>
                <option value="unid">Unid</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Unidad de producción del ingrediente</p>            
            
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