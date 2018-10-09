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
if(isset($_POST['ubicacion_id'])) $ubicacion_id = $_POST['ubicacion_id']; elseif(isset($_GET['ubicacion_id'])) $ubicacion_id = $_GET['ubicacion_id']; else $ubicacion_id = null;
?>

<?php
//consulto la información de la ubicacion
$consulta = $conexion->query("SELECT * FROM ubicacion WHERE ubicacion_id = '$ubicacion_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $ubicacion_id = $fila['ubicacion_id'];
    
    $ubicacion = $fila['ubicacion'];
    $ubicada = $fila['ubicada'];
    $tipo = $fila['tipo'];
    $impuestos = $fila['impuestos'];
    $porcentaje_comision = $fila['porcentaje_comision'];

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
    header("location:ubicaciones_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ubicación - ManGo!</title>
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
            <a href="ubicaciones_detalle.php?ubicacion_id=<?php echo "$ubicacion_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Ubicación</h2>
        </div>
        <div class="rdm-toolbar--derecha" id="abrir_modal">
            <div class="rdm-toolbar--icono-derecha"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="ubicaciones_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">

            <input type="hidden" name="ubicacion_id" value="<?php echo "$ubicacion_id"; ?>" />
            
            <p class="rdm-formularios--label"><label for="ubicacion">Nombre*</label></p>
            <p><input type="text" id="ubicacion" name="ubicacion" value="<?php echo "$ubicacion"; ?>" spellcheck="false" required autofocus/></p>
            <p class="rdm-formularios--ayuda">Ej: mesa 1, habitación 3, silla 4, etc.</p>

            <p class="rdm-formularios--label"><label for="ubicada">Ubicada en*</label></p>
            <p><input type="text" id="ubicada" name="ubicada" value="<?php echo "$ubicada"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Ej: interior, segundo piso, terraza, etc.</p>

            <p class="rdm-formularios--label"><label for="tipo">Tipo*</label></p>
            <p><select id="tipo" name="tipo" required>
                <option value="<?php echo "$tipo"; ?>"><?php echo ucfirst($tipo) ?></option>
                <option value=""></option>
                <option value="barra">Barra</option>
                <option value="caja">Caja</option>
                <option value="domicilio">Domicilio</option>
                <option value="habitacion">Habitación</option>
                <option value="mesa">Mesa</option>
                <option value="persona">Persona</option>
                <option value="silla">Silla</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Tipo de ubicación</p>
            
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
                    <p class="rdm-formularios--ayuda">Local al que se relaciona el usuario</p>
                    
                    <?php
                }
            }
            ?>

            <?php
            //atributo checked
            if ($impuestos == "si")
            {
                $impuestos_checked = "checked";
            }
            else
            {
                $impuestos_checked = "";
            }
            ?>
    
            <p class="rdm-formularios--label"><label for="impuestos">Impuestos*</label></p>
            <p class="rdm-formularios--checkbox">
                <input type="checkbox" id="impuestos" name="impuestos" class="rdm-formularios--switch" value="si" <?php echo "$impuestos_checked"; ?>>
                <label for="impuestos" class="rdm-formularios--switch-label">
                    <span class="rdm-formularios--switch-encendido">Si</span>
                    <span class="rdm-formularios--switch-apagado">No</span>
                </label>
            </p>            
            <p class="rdm-formularios--ayuda">¿Esta ubicación genera impuestos?</p>

            <p class="rdm-formularios--label"><label for="porcentaje_comision">Comisión de ventas</label></p>
            <p><input type="number" min="0" max="100" id="porcentaje_comision" name="porcentaje_comision" value="<?php echo "$porcentaje_comision"; ?>" step="any" required /></p>
            <p class="rdm-formularios--ayuda">Valor del porcentaje sin símbolos o guiones</p>
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

    </section>

    </form>

    <div id="dialogo" class="rdm-tarjeta--modal">     
        <div class="rdm-tarjeta--modal-contenido">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">¿Eliminar ubicación?</h1>
            </div>
            <div class="rdm-tarjeta--cuerpo">
                ¿Deseas eliminar <b><?php echo ($ubicacion); ?></b>?
            </div>
            <br>
            <div class="rdm-tarjeta--acciones-derecha">
                <button class="rdm-boton--plano" id="cerrar_modal">Cancelar</button>
                <a href="ubicaciones_ver.php?eliminar=si&ubicacion_id=<?php echo "$ubicacion_id"; ?>"><button class="rdm-boton--resaltado">Eliminar</button></a>
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