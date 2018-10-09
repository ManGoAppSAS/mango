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
if(isset($_POST['plantilla_factura_id'])) $plantilla_factura_id = $_POST['plantilla_factura_id']; elseif(isset($_GET['plantilla_factura_id'])) $plantilla_factura_id = $_GET['plantilla_factura_id']; else $plantilla_factura_id = null;
?>

<?php
//consulto la información de la plantilla de factura
$consulta = $conexion->query("SELECT * FROM plantilla_factura WHERE plantilla_factura_id = '$plantilla_factura_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $plantilla_factura_id = $fila['plantilla_factura_id'];
    
    $titulo = $fila['titulo'];
    $prefijo = $fila['prefijo'];
    $numero_inicio = $fila['numero_inicio'];
    $numero_fin = $fila['numero_fin'];
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
        $local_id_g = $fila['local_id'];
        $local_g = ucfirst($fila['local']);
        $local_g = "<option value='$local_id_g'>$local_g</option>";
    }
    else
    {
        $local_id_g = 0;
        $local_g = "<option value=''>No se ha asignado un local</option>";
    }
}
else
{
    header("location:plantillas_factura_ver.php");
}
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
            <a href="plantillas_factura_detalle.php?plantilla_factura_id=<?php echo "$plantilla_factura_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Plantilla de factura</h2>
        </div>
        <div class="rdm-toolbar--derecha" id="abrir_modal">
            <div class="rdm-toolbar--icono-derecha"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="plantillas_factura_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">
        
            <input type="hidden" name="action" value="image" />
            <input type="hidden" name="plantilla_factura_id" value="<?php echo "$plantilla_factura_id"; ?>" />
            <input type="hidden" name="imagen" value="<?php echo "$imagen"; ?>" />
            <input type="hidden" name="imagen_nombre" value="<?php echo "$imagen_nombre"; ?>" />
            
            <?php
            //consulto y muestro los locales
            $consulta = $conexion->query("SELECT * FROM local WHERE estado = 'activo' ORDER BY local");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="local_id" value="1">

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
                        $local = $fila['local'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($local_id) ?>" name="local_id" value="<?php echo ($local_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="local_id">Local*</label></p>
                    <p><select id="local_id" name="local_id" required autofocus>

                    <?php
                    //si hay mas de un registro los muestro todos menos el local que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM local WHERE local_id != $local_id and estado = 'activo' ORDER BY local");

                    ?>
                        
                    <?php echo "$local_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $local_id = $fila['local_id'];
                        $local = $fila['local'];
                        ?>

                        <option value="<?php echo "$local_id"; ?>"><?php echo ucfirst($local) ?></option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">Local al que se relaciona la plantilla de factura</p>
                    
                    <?php
                }
            }
            ?>
            

            <p class="rdm-formularios--label"><label for="archivo">Logo</label></p>
            <p><input type="file" id="archivo" name="archivo" /></p>
            <p class="rdm-formularios--ayuda">Logo de la factura</p>
            
            <p class="rdm-formularios--label"><label for="titulo">Titulo*</label></p>
            <p><input type="text" id="titulo" name="titulo" value="<?php echo "$titulo"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Ej: Factura de venta, Recibo, Cuenta de cobro, etc.</p>

            <p class="rdm-formularios--label"><label for="prefijo">Prefijo de facturación (ABC...)</label></p>
            <p><input type="text" id="prefijo" name="prefijo" value="<?php echo "$prefijo"; ?>" spellcheck="false" /></p>
            <p class="rdm-formularios--ayuda">Prefijo que va antes del número de facturación</p>

            <p class="rdm-formularios--label"><label for="fecha_inicio">Numeración*</label></p>
            <div class="rdm-formularios--fecha">
                <p><input type="number" id="numero_inicio" name="numero_inicio" value="<?php echo "$numero_inicio"; ?>" required></p>
                <p class="rdm-formularios--ayuda">Inicio</p>
            </div>
            <div class="rdm-formularios--fecha">
                <p><input type="number" id="numero_fin" name="numero_fin" value="<?php echo "$numero_fin"; ?>" ></p>
                <p class="rdm-formularios--ayuda">Fin</p>
            </div>

            <p class="rdm-formularios--label" style="margin-top: 0"><label for="sufijo">Sufijo de facturación (...ABC)</label></p>
            <p><input type="text" id="sufijo" name="sufijo" value="<?php echo "$sufijo"; ?>" spellcheck="false"  /></p>
            <p class="rdm-formularios--ayuda">Sufijo que va después del número de facturación</p>

            <p class="rdm-formularios--label"><label for="encabezado">Encabezado*</label></p>
            <p><textarea rows="8" id="encabezado" name="encabezado"><?php echo "$encabezado"; ?></textarea></p>
            <p class="rdm-formularios--ayuda">Ej: Nit xxxxxx-x, somos regimen xxx, resolución de faturación No xxx, etc.</p>

            <?php
            //atributo checked
            if ($mostrar_local == "si")
            {
                $mostrar_local_checked = "checked";
            }
            else
            {
                $mostrar_local_checked = "";
            }
            ?>

            <p class="rdm-formularios--label"><label for="mostrar_local">Datos del local*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="mostrar_local" name="mostrar_local" class="rdm-formularios--switch" value="si" <?php echo "$mostrar_local_checked"; ?>>
                <label for="mostrar_local" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p> 
            <p class="rdm-formularios--ayuda">Mostrar datos del local</p>           
            

            <?php
            //atributo checked
            if ($mostrar_atendido == "si")
            {
                $mostrar_atendido_checked = "checked";
            }
            else
            {
                $mostrar_atendido_checked = "";
            }
            ?>
    
            <p class="rdm-formularios--label"><label for="mostrar_local">Atendido por*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="mostrar_atendido" name="mostrar_atendido" class="rdm-formularios--switch" value="si" <?php echo "$mostrar_atendido_checked"; ?>>
                <label for="mostrar_atendido" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">Mostrar atendido por</p>

            <?php
            //atributo checked
            if ($mostrar_impuesto == "si")
            {
                $mostrar_impuesto_checked = "checked";
            }
            else
            {
                $mostrar_impuesto_checked = "";
            }
            ?>
            
            <p class="rdm-formularios--label"><label for="mostrar_local">Impuestos*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="mostrar_impuesto" name="mostrar_impuesto" class="rdm-formularios--switch" value="si" <?php echo "$mostrar_impuesto_checked"; ?>>
                <label for="mostrar_impuesto" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>
            <p class="rdm-formularios--ayuda">Mostrar impuestos en cada producto/servicio</p>

            <p class="rdm-formularios--label"><label for="pie">Pié de página*</label></p>
            <p><textarea rows="8" id="pie" name="pie"><?php echo "$pie"; ?></textarea></p>
            <p class="rdm-formularios--ayuda">Ej: Gracias por su compra, vuelva pronto, propina voluntaria, etc.</p>            
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

    </section>

    </form>

    <div id="dialogo" class="rdm-tarjeta--modal">     
        <div class="rdm-tarjeta--modal-contenido">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">¿Eliminar plantilla de factura?</h1>
            </div>
            <div class="rdm-tarjeta--cuerpo">
                ¿Deseas eliminar <b><?php echo ($titulo); ?></b>?
            </div>
            <br>
            <div class="rdm-tarjeta--acciones-derecha">
                <button class="rdm-boton--plano" id="cerrar_modal">Cancelar</button>
                <a href="plantillas_factura_ver.php?eliminar=si&plantilla_factura_id=<?php echo "$plantilla_factura_id"; ?>"><button class="rdm-boton--resaltado">Eliminar</button></a>
            </div>
        </div>
    </div>

<footer></footer>

<script type="text/javascript">
    var modal = document.getElementById('dialogo');
    var btn = document.getElementById("abrir_modal");
    var span = document.getElementById("cerrar_modal");
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>