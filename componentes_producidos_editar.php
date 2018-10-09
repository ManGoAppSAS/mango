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
if(isset($_POST['componente_producido_id'])) $componente_producido_id = $_POST['componente_producido_id']; elseif(isset($_GET['componente_producido_id'])) $componente_producido_id = $_GET['componente_producido_id']; else $componente_producido_id = null;
?>

<?php
//consulto la información del componente
$consulta = $conexion->query("SELECT * FROM componente WHERE componente_id = '$componente_producido_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $componente_producido_id = $fila['componente_id'];
    
    $componente = $fila['componente'];
    $unidad_minima = $fila['unidad_minima'];
    $unidad_compra = $fila['unidad_compra'];
    $costo_unidad_minima = $fila['costo_unidad_minima'];
    $costo_unidad_compra = $fila['costo_unidad_compra'];
    $preparacion = $fila['preparacion'];
    $cantidad_unidad_compra = $fila['cantidad_unidad_compra'];

    $productor_id = $fila['productor_id'];

    //consulto el productor
    $consulta_productor = $conexion->query("SELECT * FROM productor WHERE productor_id = '$productor_id'");           

    if ($fila = $consulta_productor->fetch_assoc()) 
    {
        $productor_id_g = $fila['productor_id'];
        $productor_g = ucfirst($fila['productor']);
        $productor_g = "<option value='$productor_id_g'>$productor_g</option>";
    }
    else
    {
        $productor_id_g = 0;
        $productor_g = "<option value=''>No se ha asignado un productor</option>";
    }
}
else
{
    header("location:componentes_producidos_ver.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Componente producido - ManGo!</title>
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
            <a href="componentes_producidos_detalle.php?componente_producido_id=<?php echo "$componente_producido_id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Componente producido</h2>
        </div>
        <div class="rdm-toolbar--derecha" id="abrir_modal">
            <div class="rdm-toolbar--icono-derecha"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <h2 class="rdm-lista--titulo-largo">Editar</h2>

    <form action="componentes_producidos_detalle.php" method="post" enctype="multipart/form-data">

        <section class="rdm-formulario">

            <input type="hidden" name="componente_producido_id" value="<?php echo "$componente_producido_id"; ?>" />

            <?php
            //consulto y muestro los productores
            $consulta = $conexion->query("SELECT * FROM productor WHERE estado = 'activo' ORDER BY productor");

            //sin no hay regisros creo un input hidden con id 1
            if ($consulta->num_rows == 0)
            {
                ?>

                <input type="hidden" id="1" name="productor_id" value="1">

                <?php
            }
            else
            {
                //si solo hay un registro muestro un input hidden con el id
                if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $productor_id = $fila['productor_id'];
                        $productor = $fila['productor'];
                    }
                    ?>
                        
                    <input type="hidden" id="<?php echo ($productor_id) ?>" name="productor_id" value="<?php echo ($productor_id) ?>">

                    <?php
                    
                }
                else
                {
                    ?>

                    <p class="rdm-formularios--label"><label for="productor_id">Productor*</label></p>
                    <p><select id="productor_id" name="productor_id" required autofocus>

                    <?php
                    //si hay mas de un registro los muestro todos menos el productor que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM productor WHERE productor_id != $productor_id and estado = 'activo' ORDER BY productor");

                    ?>
                        
                    <?php echo "$productor_g"; ?>

                    <?php
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $productor_id = $fila['productor_id'];
                        $productor = $fila['productor'];
                        ?>

                        <option value="<?php echo "$productor_id"; ?>"><?php echo ucfirst($productor) ?></option>

                        <?php
                    }
                    ?>

                    </select></p>
                    <p class="rdm-formularios--ayuda">Productor que produce el componente producido/p>
                    
                    <?php
                }
            }
            ?>
            
            <p class="rdm-formularios--label"><label for="componente">Nombre*</label></p>
            <p><input type="text" id="componente" name="componente" value="<?php echo "$componente"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del componente producido</p>

            <p class="rdm-formularios--label"><label for="cantidad_unidad_compra">Cantidad básica*</label></p>
            <p><input type="number" id="cantidad_unidad_compra" name="cantidad_unidad_compra" value="<?php echo "$cantidad_unidad_compra"; ?>" step="any" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Cantidad básica de producción</p>
            
            <p class="rdm-formularios--label"><label for="unidad_compra">Unidad de produccion*</label></p>
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
                <option value="unid">unid</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Unidad de producción del componente</p>

            <p class="rdm-formularios--label"><label for="preparacion">Preparación</label></p>
            <p><textarea id="preparacion" name="preparacion"><?php echo "$preparacion"; ?></textarea></p>
            <p class="rdm-formularios--ayuda">Escribe el proceso de preparación o producción de este componente</p>  
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>

    </section>

    </form>

    <div id="dialogo" class="rdm-tarjeta--modal">     
        <div class="rdm-tarjeta--modal-contenido">
            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">¿Eliminar componente producido?</h1>
            </div>
            <div class="rdm-tarjeta--cuerpo">
                ¿Deseas eliminar <b><?php echo ($componente); ?></b>?
            </div>
            <br>
            <div class="rdm-tarjeta--acciones-derecha">
                <button class="rdm-boton--plano" id="cerrar_modal">Cancelar</button>
                <a href="componentes_producidos_ver.php?eliminar=si&componente_producido_id=<?php echo "$componente_producido_id"; ?>"><button class="rdm-boton--resaltado">Eliminar</button></a>
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